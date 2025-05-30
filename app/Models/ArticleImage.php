<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleImage extends Model
{
    protected $fillable = [
        'article_id',
        'image_path'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    protected static function booted()
    {
        static::deleting(function ($images) {
            if ($images->file_path) {
                \Storage::disk('public')->delete($images->image_path);
            }
        });
    }
}
