<?php

namespace App\Models;

use App\Models\SeoMeta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'related_links',
        'tags',
        'youtube_link',
        'aparat_link',
    ];
    protected $casts = [
        'tags' => 'array',
        'related_links' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'model');
    }
}

