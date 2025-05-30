<?php

namespace App\Filament\Resources\HpqResource\Pages;

use App\Filament\Resources\HpqResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Placeholder;

class ViewHpq extends ViewRecord
{
    protected static string $resource = HpqResource::class;

    protected static string $view = 'filament.hpq-score-summary';
    // public function getInfolist(string $name): ?Infolist
    // {
    //     return Infolist::make()
    //     ->record($this->record)
    //     ->schema([
    //         Components\Section::make('Informasi Umum')
    //             ->columns(2)
    //             ->schema([
    //                 Components\TextEntry::make('code_hpq'),
    //                 Components\TextEntry::make('full_name'),
    //                 Components\TextEntry::make('brand_name'),
    //                 Components\TextEntry::make('coffee_sample_name'),
    //                 Components\TextEntry::make('lot_number'),
    //                 Components\TextEntry::make('origin'),
    //                 Components\TextEntry::make('variety'),
    //                 Components\TextEntry::make('altitude'),
    //             ]),

    //         Section::make('Ringkasan Nilai')
    //                 ->schema(function () {
    //                     $summary = $this->record?->score_summary ?? [];

    //                     if (empty($summary)) {
    //                         return [
    //                             TextEntry::make('message')
    //                                 ->label('')
    //                                 ->default('⚠️ Data nilai belum lengkap.')
    //                                 ->columnSpanFull(),
    //                         ];
    //                     }

    //                     return collect($summary)->map(function ($value, $label) {
    //                         return TextEntry::make($label)
    //                                 ->label(str_replace('_', ' ', ucfirst($label)))
    //                                 ->default($value);
    //                     })->toArray();
    //                 }),
    //     ]);
    // }
}
