<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class TestCategory extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'meta_keywords' => 'array',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') && empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::deleting(function ($model) {
            $model->seoMeta()?->delete();
        });
    }

    /**
     * ارتباط با آزمون‌ها
     */
    public function tests()
    {
        return $this->hasMany(Test::class, 'test_category_id');
    }

    /**
     * آزمون‌های فعال
     */
    public function activeTests()
    {
        return $this->hasMany(Test::class, 'test_category_id')->where('is_active', true);
    }

    /**
     * آزمون‌های منتشر شده
     */
    public function publishedTests()
    {
        return $this->hasMany(Test::class, 'test_category_id')->where('status', 'Published');
    }

    /**
     * ارتباط با متادیتای سئو
     */
    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'model');
    }

    /**
     * اسکوپ دسته‌های فعال
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * اسکوپ مرتب‌سازی
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    /**
     * شمارش آزمون‌ها
     */
    public function getTestsCountAttribute()
    {
        return $this->tests()->count();
    }

    /**
     * شمارش آزمون‌های فعال
     */
    public function getActiveTestsCountAttribute()
    {
        return $this->activeTests()->count();
    }

    /**
     * URL تصویر
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * دریافت یا ایجاد متادیتای سئو
     */
    public function getOrCreateSeoMeta()
    {
        return $this->seoMeta()->firstOrCreate([]);
    }
}
