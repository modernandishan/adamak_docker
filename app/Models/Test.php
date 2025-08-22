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

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

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

    public function getDescriptionShortAttribute()
    {
        return Str::limit(strip_tags($this->description), 100);
    }

    public function getRequiredMinutesAttribute()
    {
        return $this->attributes['required_minutes'];
    }

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

    public function getFinalPriceAttribute()
    {
        if(($this->price === 0 && $this->sale === null) || ($this->price === 0 && $this->sale === 0)){
            return 0;
        }elseif ($this->price !== 0 && $this->sale === 0){
            return 0;
        }elseif ($this->price > 0 && $this->sale > 0){
            return $this->sale;
        }elseif ($this->price > 0 && $this->sale === null){
            return $this->price;
        }
    }

    // در مدل Test
    public function purchasedByUsers()
    {
        return $this->belongsToMany(User::class, 'test_user_purchases')
            ->using(TestUserPurchase::class)
            ->withPivot('amount', 'wallet_transaction_id', 'purchased_at');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->price <= 0) {
            return 0;
        }
        return round(($this->sale / $this->price) * 100);
    }

    public function getIsFreeAttribute()
    {
        return $this->final_price <= 0;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getRequiredTimeAttribute()
    {
        $minutes = $this->required_minutes;

        if ($minutes < 60) {
            return $minutes . ' دقیقه';
        }

        $hours = floor($minutes / 60);
        $remaining = $minutes % 60;

        if ($remaining == 0) {
            return $hours . ' ساعت';
        }

        return $hours . ' ساعت و ' . $remaining . ' دقیقه';
    }

    public function getAgeRangeAttribute()
    {
        if ($this->min_age == 0 && $this->max_age == 100) {
            return 'همه سنین';
        }

        return $this->min_age . ' تا ' . $this->max_age . ' سال';
    }


    public function getOrCreateSeoMeta()
    {
        return $this->seoMeta()->firstOrCreate([]);
    }

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
