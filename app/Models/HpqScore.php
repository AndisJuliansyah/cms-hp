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
        'body', 'balance', 'uniformity', 'sweetness', 'clean_cup', 'overall', 'notes', 'defect',
        'assesment_fragrance', 'assesment_aroma', 'assesment_flavor', 'assesment_aftertaste', 'assesment_uniformity',
        'assesment_acidity', 'assesment_sweetness', 'assesment_body', 'assesment_defect', 'fragrance_aroma_notes',
        'flavor_aftertaste_notes', 'acidity_mouthfeel_other_notes'
    ];

    public function hpq()
    {
        return $this->belongsTo(Hpq::class, 'hpq_id', 'id');
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

    public function getTotalScoreAttribute()
    {
        $fields = [
            'fragrance_aroma', 'flavor', 'aftertaste', 'acidity',
            'body', 'balance', 'uniformity', 'sweetness',
            'clean_cup', 'overall',
        ];


        $baseScore = collect($fields)->sum(fn($field) => $this->{$field} ?? 0);

        $defectDeduction = $this->defect ?? 0;

        return $baseScore - $defectDeduction;
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
