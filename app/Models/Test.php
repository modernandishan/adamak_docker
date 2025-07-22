<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use SoftDeletes;

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
    ];

    public function category()
    {
        return $this->belongsTo(TestCategory::class, 'test_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'Published');
    }
}
