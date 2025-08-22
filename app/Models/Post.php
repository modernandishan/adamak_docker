<?php

namespace App\Models;

use App\Models\SeoMeta;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'related_links',
        'tags',
        'youtube_link',
        'aparat_link',
        'status',
        'is_active',
        'published_at',
        'galleries',
        'view_count',
    ];

    protected $casts = [
        'galleries' => 'array',
        'tags' => 'array',
        'related_links' => 'array',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // حذف کردن Accessor ها و جایگزینی با متدهای جداگانه

    // متد برای نمایش تاریخ جلالی در View ها
    public function getJalaliPublishedAtAttribute()
    {
        if (!$this->published_at) return null;

        try {
            return Jalalian::fromDateTime($this->published_at)->format('Y/m/d');
        } catch (\Exception $e) {
            return $this->published_at->format('Y-m-d');
        }
    }

    public function getJalaliCreatedAtAttribute()
    {
        try {
            return Jalalian::fromDateTime($this->created_at)->format('Y/m/d H:i');
        } catch (\Exception $e) {
            return $this->created_at->format('Y-m-d H:i');
        }
    }

    public function getJalaliUpdatedAtAttribute()
    {
        try {
            return Jalalian::fromDateTime($this->updated_at)->format('Y/m/d H:i');
        } catch (\Exception $e) {
            return $this->updated_at->format('Y-m-d H:i');
        }
    }

    // متد برای نمایش تاریخ کامل جلالی
    public function getFullJalaliPublishedAtAttribute()
    {
        if (!$this->published_at) return null;

        try {
            return Jalalian::fromDateTime($this->published_at)->format('Y/m/d H:i:s');
        } catch (\Exception $e) {
            return $this->published_at->format('Y-m-d H:i:s');
        }
    }

    public function renderContentWithGalleries(): string
    {
        $content = $this->content;

        // باقی کد شما...
        $content = preg_replace_callback('/\[gallery=(.*?)\]/', function ($matches) {
            $galleryName = $matches[1];
            $gallery = collect($this->galleries)->firstWhere('title', $galleryName);

            if ($gallery) {
                $galleryHtml = '<div class="gallery">';
                foreach ($gallery['items'] as $item) {
                    $imgSrc   = asset('storage/' . ltrim($item['image'], '/'));
                    $imgTitle = $item['name'] ?? '';

                    $galleryHtml .= '<div class="gallery-item" style="cursor: pointer;">';
                    $galleryHtml .= '<img
                        src="' . $imgSrc . '"
                        alt="' . $imgTitle . '"
                        style="width: 100%; border-radius: 8px;"
                        data-bs-toggle="modal"
                        data-bs-target="#imageModal"
                        data-img-src="' . $imgSrc . '"
                        data-img-title="' . $imgTitle . '"
                    >';
                    $galleryHtml .= '<p>' . $imgTitle . '</p>';
                    $galleryHtml .= '</div>';
                }
                $galleryHtml .= '</div>';
                return $galleryHtml;
            }

            return $matches[0];
        }, $content);

        $content = preg_replace_callback('/\[carousel=(.*?),(.*?)\]/', function ($matches) {
            $galleryName = $matches[1];
            $itemCount   = intval($matches[2]);

            $gallery = collect($this->galleries)->firstWhere('title', $galleryName);
            if ($gallery) {
                $carouselId   = 'swiper_' . uniqid();
                $carouselHtml = '<div class="swiper ' . $carouselId . '">';
                $carouselHtml .= '  <div class="swiper-wrapper">';

                foreach ($gallery['items'] as $item) {
                    $imgSrc   = asset('storage/' . ltrim($item['image'], '/'));
                    $imgTitle = $item['name'] ?? '';

                    $carouselHtml .= '    <div class="swiper-slide" style="cursor:pointer;">';
                    $carouselHtml .= '      <img
                        src="' . $imgSrc . '"
                        alt="' . $imgTitle . '"
                        style="width: 100%; border-radius: 8px;"
                        data-bs-toggle="modal"
                        data-bs-target="#imageModal"
                        data-img-src="' . $imgSrc . '"
                        data-img-title="' . $imgTitle . '"
                    >';
                    $carouselHtml .= '      <p>' . $imgTitle . '</p>';
                    $carouselHtml .= '    </div>';
                }

                $carouselHtml .= '  </div>';
                $carouselHtml .= '  <div class="swiper-button-next"></div>';
                $carouselHtml .= '  <div class="swiper-button-prev"></div>';
                $carouselHtml .= '</div>';

                $carouselHtml .= '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        new Swiper(".' . $carouselId . '", {
                            slidesPerView: ' . $itemCount . ',
                            loop: true,
                            spaceBetween: 10,
                            autoplay: {
                                delay: 2000,
                                disableOnInteraction: false
                            },
                            navigation: {
                                nextEl: ".swiper-button-next",
                                prevEl: ".swiper-button-prev",
                            },
                            breakpoints: {
                                640: {
                                    slidesPerView: ' . $itemCount . ',
                                    spaceBetween: 20,
                                },
                                768: {
                                    slidesPerView: ' . $itemCount . ',
                                    spaceBetween: 30,
                                },
                                1024: {
                                    slidesPerView: ' . $itemCount . ',
                                    spaceBetween: 40,
                                },
                            }
                        });
                    });
                </script>';

                return $carouselHtml;
            }

            return '<p>گالری با عنوان "' . $galleryName . '" یافت نشد.</p>';
        }, $content);

        $content .= $this->getModalCode();

        return $content;
    }

    private function getModalCode(): string
    {
        return <<<HTML
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">عنوان تصویر</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" alt="" style="max-width: 100%; height: auto;" />
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var imageModal = document.getElementById('imageModal');
        imageModal.addEventListener('show.bs.modal', function (event) {
            var trigger = event.relatedTarget;
            var imgSrc   = trigger.getAttribute('data-img-src');
            var imgTitle = trigger.getAttribute('data-img-title');

            var modalImg   = imageModal.querySelector('.modal-body img');
            var modalTitle = imageModal.querySelector('.modal-title');

            modalImg.src       = imgSrc;
            modalImg.alt       = imgTitle;
            modalTitle.textContent = imgTitle;
        });
    });
</script>
HTML;
    }

    // ارتباطات Eloquent
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_active', true)
            ->where('status', 'published')
            ->whereNull('deleted_at');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id')
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'super_admin', 'vendor']);
            });
    }

    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'model');
    }
}
