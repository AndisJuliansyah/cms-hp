<?php

namespace App\Livewire;

use Livewire\Component;

class HpqScoreSummary extends Component
{
    public $record;

    public function render()
    {
        $summary = $this->record->score_summary ?? [];

        return view('livewire.hpq-score-summary', [
            'summary' => $summary,
        ]);
    }
}

