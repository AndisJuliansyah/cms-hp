<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'location',
        'description',
        'poster_path',
        'event_date',
        'is_published',
        'seo_title',
        'seo_description',
    ];
}
