<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    /**
     * ارتباط با آزمون‌ها
     */
    public function tests()
    {
        return $this->hasMany(Test::class, 'test_category_id');
    }

}
