<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'test_id',
        'title',
        'description',
        'type',
        'settings',
        'options',
        'image',
        'is_required',
        'is_active',
        'sort_order',
        'hint',
        'explanation',
        'admin_note'
    ];

    protected $casts = [
        'settings' => 'array',
        'options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * انواع سوالات قابل استفاده
     */
    public const TYPES = [
        'text' => 'متنی',
        'upload' => 'آپلود فایل',
    ];

    /**
     * ارتباط با آزمون
     */
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * اسکوپ سوالات فعال
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
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * اسکوپ سوالات اجباری
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    /**
     * دریافت انواع سوالات
     */
    public static function getTypes(): array
    {
        return self::TYPES;
    }

    /**
     * دریافت نام نوع سوال به فارسی
     */
    public function getTypeNameAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    /**
     * بررسی اعتبار گزینه‌ها براساس نوع سوال
     */
    public function validateOptions(): bool
    {
        if (!$this->options) {
            return in_array($this->type, ['text', 'number', 'date', 'upload']);
        }

        switch ($this->type) {
            case 'multiple_choice':
            case 'single_choice':
                return is_array($this->options) && count($this->options) >= 2;
            case 'true_false':
                return is_array($this->options) && count($this->options) === 2;
            default:
                return true;
        }
    }

    /**
     * دریافت تنظیمات پیش‌فرض براساس نوع سوال
     */
    public function getDefaultSettings(): array
    {
        $defaults = [
            'multiple_choice' => [
                'min_selections' => 1,
                'max_selections' => null,
            ],
            'upload' => [
                'allowed_types' => ['pdf', 'doc', 'docx', 'jpg', 'png'],
                'max_size' => 5120, // 5MB
            ],
            'number' => [
                'min' => null,
                'max' => null,
                'step' => 1,
            ],
            'date' => [
                'min_date' => null,
                'max_date' => null,
                'format' => 'Y-m-d',
            ],
        ];

        return $defaults[$this->type] ?? [];
    }

    public function getFormattedOptionsAttribute(): array
    {
        return array_map(function ($option) {
            return [
                'text' => strval($option['text'] ?? ''),
                'value' => strval($option['value'] ?? ''),
            ];
        }, $this->options ?? []);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($question) {
            if (empty($question->settings)) {
                $question->settings = $question->getDefaultSettings();
            }
        });
    }
}
