<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\ArticleCategory;
use App\Models\ArticleImage;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'article_category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'seo_title',
        'seo_description',
        'is_published',
        'published_at',
        'seo_title',
        'seo_description'
    ];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function setBodyAttribute($value)
    {
        $backendUrl = config('app.url');

        $value = preg_replace(
            '/src=[\'"]\/storage\/(.*?)[\'"]/',
            'src="' . $backendUrl . '/storage/$1"',
            $value
        );

        $this->attributes['body'] = $value;
    }
}
