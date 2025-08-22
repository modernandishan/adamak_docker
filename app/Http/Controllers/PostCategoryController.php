<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

class PostCategoryController extends Controller
{
    public function show(string $slug)
    {
        // یافتن دسته‌بندی بر اساس slug
        $category = PostCategory::where('slug', $slug)->firstOrFail();

        // دریافت پست‌های مرتبط با دسته‌بندی
        $posts = $category->posts()
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        // محاسبه آمار کلی
        $all_views = Post::sum('view_count');
        $post_categories = PostCategory::all();
        $most_viewed_posts = Post::orderBy('view_count', 'desc')->take(5)->get();

        // محاسبه آرشیو
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

        // دریافت تگ‌ها
        $allTags = Post::whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->filter()
            ->values();

        return view('blog', compact(
            'category',
            'posts',
            'post_categories',
            'all_views',
            'most_viewed_posts',
            'archives',
            'allTags'
        ));
    }
}
