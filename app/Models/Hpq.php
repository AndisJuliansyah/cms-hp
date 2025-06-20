<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\HpqScore;

class Hpq extends Model
{
    protected $fillable = [
        'code_hpq',
        'email',
        'full_name',
        'brand_name',
        'contact_number',
        'address',
        'customer_type',
        'coffee_type',
        'coffee_sample_name',
        'lot_number',
        'total_lot_quantity',
        'origin',
        'variety',
        'altitude',
        'post_harvest_process',
        'harvest_date',
        'green_bean_condition',
        'sort_before_sending',
        'specific_goal',
        'notes',
        'status',
    ];

    protected $casts = [
        'harvest_date' => 'date',
    ];

    public function refreshStatus()
    {
        $scoresCount = $this->scores()->count();

        if ($scoresCount === 0) {
            $newStatus = 'waiting';
        } elseif ($scoresCount < 3) {
            $newStatus = 'scoring';
        } else {
            $newStatus = 'completed';
        }

        if ($this->status !== $newStatus) {
            $this->status = $newStatus;
            $this->saveQuietly();
        }
    }

    public function scores(): HasMany
    {
        return $this->hasMany(HpqScore::class, 'code_hpq', 'code_hpq');
    }

    public function getIsCompleteAttribute(): bool
    {
        return !is_null($this->score_summary);
    }

    public function getScoreSummaryAttribute(): ?array
    {
        if ($this->scores()->count() < 3) {
            return null;
        }

        $fields = [
            'fragrance_aroma',
            'flavor',
            'aftertaste',
            'acidity',
            'body',
            'balance',
            'uniformity',
            'sweetness',
            'clean_cup',
            'overall',
        ];

        $summary = [];
        $total = 0;

        foreach ($fields as $field) {
            $average = round($this->scores()->avg($field), 2);
            $summary[$field] = $average;
            $total += $average;
        }

        $summary['total_score'] = round($total, 2);

        return $summary;
    }

}
