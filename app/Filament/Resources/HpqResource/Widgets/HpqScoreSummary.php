<?php

namespace App\Filament\Resources\HpqResource\Widgets;

use App\Models\Hpq;
use Filament\Widgets\Widget;

class HpqScoreSummary extends Widget
{
    protected static string $view = 'filament.resources.hpq-resource.widgets.hpq-score-summary';

    public Hpq $record;

    protected int | string | array $columnSpan = 'full';

    // public function mount(Hpq $record): void
    // {
    //     $this->record = $record;
    // }

    public function getSummary(): array
    {
        return $this->record->is_complete ? $this->record->score_summary ?? [] : [];
    }

    public function isComplete(): bool
    {
        return $this->record->is_complete;
    }
}
