<?php

namespace App\Filament\Resources\HpqScoreResource\Pages;

use App\Filament\Resources\HpqScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Filament\Forms;

class ListHpqScores extends ListRecords
{
    protected static string $resource = HpqScoreResource::class;

    protected function getHeaderActions(): array
    {
        $unscoredHpq = \App\Models\Hpq::whereDoesntHave('scores', function ($query) {
            $query->where('jury_id', auth()->id());
        })->pluck('code_hpq', 'code_hpq');

        if ($unscoredHpq->isEmpty()) {
            return []; // Hide Create button
        }

        return [
            CreateAction::make()
                ->form([
                    Forms\Components\Select::make('code_hpq')
                        ->label('Pilih Kode HPQ')
                        ->options($unscoredHpq)
                        ->required()
                ])
                ->mutateFormDataUsing(function (array $data): array {
                    $data['jury_id'] = auth()->id();
                    $data['judge_name'] = auth()->user()->name;
                    return $data;
                }),
        ];
    }
}
