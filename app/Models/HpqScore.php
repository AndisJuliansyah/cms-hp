<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Hpq;
use App\Models\User;

class HpqScore extends Model
{
    protected $fillable = [
        'code_hpq', 'jury_id', 'judge_name', 'fragrance_aroma', 'flavor', 'aftertaste', 'acidity',
        'body', 'balance', 'uniformity', 'sweetness', 'clean_cup', 'overall'
    ];

    public function hpq()
    {
        return $this->belongsTo(Hpq::class, 'code_hpq', 'code_hpq');
    }

    public function jury()
    {
        return $this->belongsTo(User::class, 'jury_id');
    }

    public function getAverageScoreAttribute()
    {
        $fields = [
            'fragrance_aroma', 'flavor', 'aftertaste', 'acidity',
            'body', 'balance', 'uniformity', 'sweetness',
            'clean_cup', 'overall',
        ];

        $total = collect($fields)->sum(fn($field) => $this->{$field});
        return round($total / count($fields), 2);
    }

    protected static function booted()
    {
        static::saved(function ($score) {
            $score->hpq->refreshStatus();
        });

        static::deleted(function ($score) {
            $score->hpq->refreshStatus();
        });
    }
}
