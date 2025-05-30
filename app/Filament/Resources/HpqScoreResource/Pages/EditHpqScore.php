<?php

namespace App\Filament\Resources\HpqScoreResource\Pages;

use App\Filament\Resources\HpqScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHpqScore extends EditRecord
{
    protected static string $resource = HpqScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
