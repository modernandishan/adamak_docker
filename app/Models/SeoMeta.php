<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class SeoMeta extends Model
{
    protected $table = "seo_meta";
    protected $fillable = [
        'title',
        'description',
        'image',
        'author',
        'robots',
        'canonical_url',
        'keywords',
        'facebook_title',
        'facebook_description',
        'facebook_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'open_graph_title',
        'open_graph_description',
        'open_graph_image',
        'schema_type',
        'schema_data',
        'priority',
        'sitemap_include',
        'sitemap_priority',
        'sitemap_changefreq',
        'price',
        'sale_price',
        'currency',
        'availability',
        'sku',
        'product_condition',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'keywords' => 'array',
        'schema_data' => 'array',
        'price' => 'integer',
        'sale_price' => 'integer',
        'sitemap_include' => 'boolean',
    ];
}
