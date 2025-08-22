<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Test;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

class LandingController extends Controller
{
    public function home()
    {
        $latestPosts = Post::published()
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
        return view('home', compact('latestPosts'));
    }
    public function blog()
    {
        $all_views = Post::sum('view_count');
        $search = request()->query('search');

        // پرس و جو با قابلیت جستجو
        $posts = Post::query()
            ->when($search, function ($query, $search) {
                $query->where('title', 'LIKE', "%{$search}%");
            })
            ->published() // اگر scope published دارید
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        $post_categories = PostCategory::all();
        $most_viewed_posts = Post::orderBy('view_count', 'desc')->take(5)->get();

        // محاسبه آرشیو با بررسی تاریخ‌ها
        $archives = Post::whereNotNull('published_at')
            ->get()
            ->map(function ($post) {
                try {
                    $publishedAt = $post->getAttributes()['published_at'];

                    if (is_numeric($publishedAt)) {
                        $carbonDate = Carbon::createFromTimestamp($publishedAt);
                    } else {
                        $carbonDate = Carbon::parse($publishedAt);
                    }

                    $jalaliDate = Jalalian::fromCarbon($carbonDate);

                    return [
                        'year_jalali' => $jalaliDate->getYear(),
                        'month_jalali' => $jalaliDate->getMonth(),
                        'month_name' => $jalaliDate->format('F'),
                    ];
                } catch (\Exception $e) {
                    return null;
                }
            })
            ->filter()
            ->groupBy('year_jalali')
            ->map(function ($yearGroup) {
                return $yearGroup->groupBy('month_jalali')->map(function ($monthGroup) {
                    return [
                        'month_jalali' => $monthGroup->first()['month_jalali'],
                        'month_name' => $monthGroup->first()['month_name'],
                        'post_count' => $monthGroup->count(),
                    ];
                })->sortByDesc('month_jalali');
            })
            ->sortByDesc(function ($item, $key) {
                return $key;
            });

        $allTags = Post::whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->filter()
            ->values();

        return view('blog', compact(
            'posts',
            'post_categories',
            'all_views',
            'most_viewed_posts',
            'archives',
            'allTags' // ارسال تگ‌ها به ویو
        ));
    }

    public function blogDetail($slug)
    {
        $post = Post::where('slug', $slug)
            ->with('category', 'author')
            ->firstOrFail();

        $viewed = session()->get('viewed_posts', []);
        if (!in_array($post->id, $viewed)) {
            $post->increment('view_count');
            session()->push('viewed_posts', $post->id);
        }

        // دریافت پست های مرتبط (از همان دسته بندی)
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->published()
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('blog-detail', compact('post', 'relatedPosts'));
    }

    public function testArchive($year, $month)
    {
        // محاسبه آرشیو آزمون‌ها (برای سایدبار)
        $archives = Test::whereNotNull('created_at')
            ->active()
            ->published()
            ->get()
            ->map(function ($test) {
                try {
                    $jalaliDate = Jalalian::fromCarbon($test->created_at);
                    return [
                        'year_jalali' => $jalaliDate->getYear(),
                        'month_jalali' => $jalaliDate->getMonth(),
                        'month_name' => $jalaliDate->format('F'),
                    ];
                } catch (\Exception $e) {
                    return null;
                }
            })
            ->filter()
            ->groupBy('year_jalali')
            ->map(function ($yearGroup) {
                return $yearGroup->groupBy('month_jalali')->map(function ($monthGroup) {
                    return [
                        'month_jalali' => $monthGroup->first()['month_jalali'],
                        'month_name' => $monthGroup->first()['month_name'],
                        'test_count' => $monthGroup->count(),
                    ];
                })->sortByDesc('month_jalali');
            })
            ->sortByDesc(function ($item, $key) {
                return $key;
            });

        try {
            // دریافت آزمون‌های مربوط به ماه و سال جلالی
            $tests = Test::active()
                ->published()
                ->get()
                ->filter(function ($test) use ($year, $month) {
                    try {
                        $jalaliDate = Jalalian::fromCarbon($test->created_at);
                        return $jalaliDate->getYear() == $year && $jalaliDate->getMonth() == $month;
                    } catch (\Exception $e) {
                        return false;
                    }
                });

            // تبدیل به Collection پگینیت شده
            $perPage = 12;
            $currentPage = request()->get('page', 1);
            $currentPageItems = $tests->slice(($currentPage - 1) * $perPage, $perPage);

            $tests = new \Illuminate\Pagination\LengthAwarePaginator(
                $currentPageItems,
                $tests->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'pageName' => 'page']
            );

        } catch (\Exception $e) {
            return redirect()->route('tests.index')->with('error', 'تاریخ وارد شده معتبر نیست.');
        }

        // دسته‌بندی‌های فعال
        $test_categories = TestCategory::active()
            ->withCount(['tests' => function($query) {
                $query->active()->published();
            }])
            ->ordered()
            ->get();

        // آزمون‌های محبوب
        $popular_tests = Test::active()
            ->published()
            ->withCount('attempts')
            ->orderByDesc('attempts_count')
            ->take(5)
            ->get();

        return view('tests', compact(
            'tests',
            'test_categories',
            'popular_tests',
            'archives',
            'year',
            'month'
        ));
    }

    public function testCategoryShow($slug)
    {
        $search = request()->query('search');

        $category = TestCategory::where('slug', $slug)->active()->firstOrFail();

        $tests = $category->tests()
            ->active()
            ->published()
            ->when($search, function ($query, $search) {
                $query->where('title', 'LIKE', "%{$search}%");
            })
            ->paginate(12);

        // دسته‌بندی‌های فعال
        $test_categories = TestCategory::active()
            ->withCount(['tests' => function($query) {
                $query->active()->published();
            }])
            ->ordered()
            ->get();

        // آزمون‌های محبوب
        $popular_tests = Test::active()
            ->published()
            ->withCount('attempts')
            ->orderByDesc('attempts_count')
            ->take(5)
            ->get();

        // آرشیو ماهانه - ساختار یکسان با متد tests
        $archives = Test::whereNotNull('created_at')
            ->active()
            ->published()
            ->get()
            ->map(function ($test) {
                try {
                    $jalaliDate = Jalalian::fromCarbon($test->created_at);
                    return [
                        'year_jalali' => $jalaliDate->getYear(),
                        'month_jalali' => $jalaliDate->getMonth(),
                        'month_name' => $jalaliDate->format('F'),
                    ];
                } catch (\Exception $e) {
                    return null;
                }
            })
            ->filter()
            ->groupBy('year_jalali')
            ->map(function ($yearGroup) {
                return $yearGroup->groupBy('month_jalali')->map(function ($monthGroup) {
                    return [
                        'month_jalali' => $monthGroup->first()['month_jalali'],
                        'month_name' => $monthGroup->first()['month_name'],
                        'test_count' => $monthGroup->count(),
                    ];
                })->sortByDesc('month_jalali');
            })
            ->sortByDesc(function ($item, $key) {
                return $key;
            });

        return view('tests', compact(
            'tests',
            'test_categories',
            'popular_tests',
            'archives',
            'category'
        ));
    }

    public function tests()
    {
        $search = request()->query('search');

        $tests = Test::query()
            ->with('category')
            ->active()
            ->published()
            ->ordered()
            ->when($search, function ($query, $search) {
                $query->where('title', 'LIKE', "%{$search}%");
            })
            ->paginate(12);

        // دسته‌بندی‌های فعال
        $test_categories = TestCategory::active()
            ->withCount(['tests' => function($query) {
                $query->active()->published();
            }])
            ->ordered()
            ->get();

        // آزمون‌های محبوب
        $popular_tests = Test::active()
            ->published()
            ->withCount('attempts')
            ->orderByDesc('attempts_count')
            ->take(5)
            ->get();

        // آرشیو ماهانه (همان ساختار وبلاگ)
        $archives = Test::whereNotNull('created_at')
            ->active()
            ->published()
            ->get()
            ->map(function ($test) {
                try {
                    $jalaliDate = Jalalian::fromCarbon($test->created_at);
                    return [
                        'year_jalali' => $jalaliDate->getYear(),
                        'month_jalali' => $jalaliDate->getMonth(),
                        'month_name' => $jalaliDate->format('F'),
                    ];
                } catch (\Exception $e) {
                    return null;
                }
            })
            ->filter()
            ->groupBy('year_jalali')
            ->map(function ($yearGroup) {
                return $yearGroup->groupBy('month_jalali')->map(function ($monthGroup) {
                    return [
                        'month_jalali' => $monthGroup->first()['month_jalali'],
                        'month_name' => $monthGroup->first()['month_name'],
                        'test_count' => $monthGroup->count(),
                    ];
                })->sortByDesc('month_jalali');
            })
            ->sortByDesc(function ($item, $key) {
                return $key;
            });

        return view('tests', compact(
            'tests',
            'test_categories',
            'popular_tests',
            'archives'
        ));
    }
    public function testDetail($slug)
    {
        $test = Test::with(['category', 'questions' => function ($query) {
            $query->active()->ordered();
        }])
            ->withCount('activeQuestions')
            ->where('slug', $slug)
            ->active()
            ->published()
            ->firstOrFail();

        $user = auth()->user();

        return view('test-detail', compact('test', 'user'));
    }

    public function blogArchive($year, $month)
    {
        $all_views = Post::sum('view_count');
        $post_categories = PostCategory::all();
        $most_viewed_posts = Post::orderBy('view_count', 'desc')->take(5)->get();

        $archives = Post::whereNotNull('published_at')
            ->get()
            ->map(function ($post) {
                try {
                    $publishedAt = $post->getAttributes()['published_at'];

                    if (is_numeric($publishedAt)) {
                        $carbonDate = Carbon::createFromTimestamp($publishedAt);
                    } else {
                        $carbonDate = Carbon::parse($publishedAt);
                    }

                    $jalaliDate = Jalalian::fromCarbon($carbonDate);

                    return [
                        'year_jalali' => $jalaliDate->getYear(),
                        'month_jalali' => $jalaliDate->getMonth(),
                        'month_name' => $jalaliDate->format('F'),
                    ];
                } catch (\Exception $e) {
                    return null;
                }
            })
            ->filter()
            ->groupBy('year_jalali')
            ->map(function ($yearGroup) {
                return $yearGroup->groupBy('month_jalali')->map(function ($monthGroup) {
                    return [
                        'month_jalali' => $monthGroup->first()['month_jalali'],
                        'month_name' => $monthGroup->first()['month_name'],
                        'post_count' => $monthGroup->count(),
                    ];
                })->sortByDesc('month_jalali');
            })
            ->sortByDesc(function ($item, $key) {
                return $key;
            });

        try {
            // دریافت پست‌های مربوط به ماه و سال جلالی
            $posts = Post::whereNotNull('published_at')
                ->get()
                ->filter(function ($post) use ($year, $month) {
                    try {
                        $publishedAt = $post->getAttributes()['published_at'];

                        if (is_numeric($publishedAt)) {
                            $carbonDate = Carbon::createFromTimestamp($publishedAt);
                        } else {
                            $carbonDate = Carbon::parse($publishedAt);
                        }

                        $jalaliDate = Jalalian::fromCarbon($carbonDate);
                        return $jalaliDate->getYear() == $year && $jalaliDate->getMonth() == $month;
                    } catch (\Exception $e) {
                        return false;
                    }
                });

            // تبدیل به Collection پگینیت شده
            $perPage = 10;
            $currentPage = request()->get('page', 1);
            $currentPageItems = $posts->slice(($currentPage - 1) * $perPage, $perPage);

            $posts = new \Illuminate\Pagination\LengthAwarePaginator(
                $currentPageItems,
                $posts->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'pageName' => 'page']
            );

        } catch (\Exception $e) {
            return redirect()->route('blog')->with('error', 'تاریخ وارد شده معتبر نیست.');
        }

        $allTags = Post::whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->filter()
            ->values();

        return view('blog', compact(
            'posts',
            'post_categories',
            'all_views',
            'most_viewed_posts',
            'archives',
            'allTags' // ارسال تگ‌ها به ویو
        ));    }

    public function blogTag($tag)
    {
        $all_views = Post::sum('view_count');
        $post_categories = PostCategory::all();
        $most_viewed_posts = Post::orderBy('view_count', 'desc')->take(5)->get();

        // محاسبه آرشیو (همانند متد blog)
        $archives = Post::whereNotNull('published_at')
            ->get()
            ->map(function ($post) {
                try {
                    $publishedAt = $post->getAttributes()['published_at'];

                    if (is_numeric($publishedAt)) {
                        $carbonDate = Carbon::createFromTimestamp($publishedAt);
                    } else {
                        $carbonDate = Carbon::parse($publishedAt);
                    }

                    $jalaliDate = Jalalian::fromCarbon($carbonDate);

                    return [
                        'year_jalali' => $jalaliDate->getYear(),
                        'month_jalali' => $jalaliDate->getMonth(),
                        'month_name' => $jalaliDate->format('F'),
                    ];
                } catch (\Exception $e) {
                    return null;
                }
            })
            ->filter()
            ->groupBy('year_jalali')
            ->map(function ($yearGroup) {
                return $yearGroup->groupBy('month_jalali')->map(function ($monthGroup) {
                    return [
                        'month_jalali' => $monthGroup->first()['month_jalali'],
                        'month_name' => $monthGroup->first()['month_name'],
                        'post_count' => $monthGroup->count(),
                    ];
                })->sortByDesc('month_jalali');
            })
            ->sortByDesc(function ($item, $key) {
                return $key;
            });

        // دریافت تمام تگ‌های منحصر به فرد
        $allTags = Post::whereNotNull('tags')
            ->select('tags')
            ->get()
            ->flatMap(function ($post) {
                return $post->tags ?? [];
            })
            ->unique()
            ->filter()
            ->values();

        // دریافت پست‌های مربوط به تگ با پگینیشن
        $posts = Post::whereJsonContains('tags', $tag)
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('blog', compact(
            'posts',
            'post_categories',
            'all_views',
            'most_viewed_posts',
            'archives',
            'allTags',
            'tag' // ارسال تگ فعلی برای نمایش در عنوان
        ));
    }
}
