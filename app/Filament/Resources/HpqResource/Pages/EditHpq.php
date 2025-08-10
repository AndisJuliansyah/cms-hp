<?php

namespace App\Filament\Resources\HpqResource\Pages;

use App\Filament\Resources\HpqResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHpq extends EditRecord
{
    protected static string $resource = HpqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;
        $scores = $record->scores;

        foreach ($scores as $score) {
            $score->update(['code_hpq' => $record->code_hpq]);
        }
    }
}
