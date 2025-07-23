<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Test extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'test_category_id',
        'title',
        'slug',
        'description',
        'image',
        'status',
        'is_need_family',
        'price',
        'sale',
        'required_minutes',
        'min_age',
        'max_age',
        'is_active',
        'admin_note',
        'type',
        'catalog',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_need_family' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'integer',
        'sale' => 'integer',
        'required_minutes' => 'integer',
        'min_age' => 'integer',
        'max_age' => 'integer',
        'sort_order' => 'integer',
        'meta_keywords' => 'array',
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
     * ارتباط با دسته‌بندی
     */
    public function category()
    {
        return $this->belongsTo(TestCategory::class, 'test_category_id');
    }

    /**
     * ارتباط با متادیتای سئو
     */
    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'model');
    }

    /**
     * اسکوپ آزمون‌های فعال
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * اسکوپ آزمون‌های منتشر شده
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'Published');
    }

    /**
     * اسکوپ مرتب‌سازی
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    /**
     * اسکوپ فیلتر براساس رده سنی
     */
    public function scopeForAge($query, $age)
    {
        return $query->where('min_age', '<=', $age)
                    ->where('max_age', '>=', $age);
    }

    /**
     * اسکوپ آزمون‌های رایگان
     */
    public function scopeFree($query)
    {
        return $query->where('price', 0);
    }

    /**
     * اسکوپ آزمون‌های پولی
     */
    public function scopePaid($query)
    {
        return $query->where('price', '>', 0);
    }

    /**
     * قیمت نهایی با احتساب تخفیف
     */
    public function getFinalPriceAttribute()
    {
        return $this->price - $this->sale;
    }

    /**
     * درصد تخفیف
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->price <= 0) {
            return 0;
        }
        return round(($this->sale / $this->price) * 100);
    }

    /**
     * آیا رایگان است؟
     */
    public function getIsFreeAttribute()
    {
        return $this->final_price <= 0;
    }

    /**
     * URL تصویر
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * زمان مورد نیاز به صورت قابل خواندن
     */
    public function getRequiredTimeAttribute()
    {
        if ($this->required_minutes < 60) {
            return $this->required_minutes . ' دقیقه';
        }

        $hours = floor($this->required_minutes / 60);
        $minutes = $this->required_minutes % 60;

        if ($minutes == 0) {
            return $hours . ' ساعت';
        }

        return $hours . ' ساعت و ' . $minutes . ' دقیقه';
    }

    /**
     * رده سنی
     */
    public function getAgeRangeAttribute()
    {
        if ($this->min_age == 0 && $this->max_age == 100) {
            return 'همه سنین';
        }

        return $this->min_age . ' تا ' . $this->max_age . ' سال';
    }

    /**
     * دریافت یا ایجاد متادیتای سئو
     */
    public function getOrCreateSeoMeta()
    {
        return $this->seoMeta()->firstOrCreate([]);
    }

    /**
     * ارتباط با سوالات
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * سوالات فعال
     */
    public function activeQuestions()
    {
        return $this->hasMany(Question::class)->where('is_active', true);
    }

    /**
     * سوالات مرتب شده
     */
    public function orderedQuestions()
    {
        return $this->hasMany(Question::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * سوالات اجباری
     */
    public function requiredQuestions()
    {
        return $this->hasMany(Question::class)->where('is_required', true);
    }

    /**
     * شمارش سوالات
     */
    public function getQuestionsCountAttribute()
    {
        return $this->questions()->count();
    }

    /**
     * شمارش سوالات فعال
     */
    public function getActiveQuestionsCountAttribute()
    {
        return $this->activeQuestions()->count();
    }
}
