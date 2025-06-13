<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HpqResource\Pages;
use App\Filament\Resources\HpqResource\RelationManagers;
use App\Models\Hpq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Group;

class HpqResource extends Resource
{
    protected static ?string $model = Hpq::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
                ->schema([
                    TextInput::make('email')
                        ->email()
                        ->required(),

                    TextInput::make('full_name')
                        ->label('Full Name')
                        ->required(),

                    TextInput::make('brand_name')
                        ->label('Brand Name')
                        ->required(),

                    TextInput::make('contact_number')
                        ->label('Contact Number')
                        ->required(),

                    Textarea::make('address')
                        ->required(),

                CheckboxList::make('customer_type')
                    ->label('Customer Type')
                    ->options([
                        'Coffee Farm / Estate' => 'Coffee Farm / Estate',
                        'Processing Facility' => 'Processing Facility',
                        'Roastery' => 'Roastery',
                        'Café / Retailer' => 'Café / Retailer',
                        'Exporter / Importer' => 'Exporter / Importer',
                        'Government Institution / NGO' => 'Government Institution / NGO',
                        'Educational / Research Institution' => 'Educational / Research Institution',
                        'Other' => 'Other',
                    ])
                    ->reactive()
                    ->columns(2)
                    ->required()
                    ->formatStateUsing(function ($state) {
                        $items = is_array($state) ? $state : explode(',', (string) $state);
                        $valid = [
                            'Coffee Farm / Estate',
                            'Processing Facility',
                            'Roastery',
                            'Café / Retailer',
                            'Exporter / Importer',
                            'Government Institution / NGO',
                            'Educational / Research Institution',
                        ];

                        return collect($items)
                            ->map(fn ($item) => in_array($item, $valid) ? $item : 'Other')
                            ->unique()
                            ->values()
                            ->all();
                    })
                    ->dehydrateStateUsing(function ($state, $get) {
                        if (!is_array($state)) return $state;

                        return implode(',', array_map(function ($item) use ($get) {
                            return $item === 'Other'
                                ? $get('customer_type_other')
                                : $item;
                        }, $state));
                    }),

                TextInput::make('customer_type_other')
                    ->label('Please specify other customer type')
                    ->reactive()
                    ->visible(fn ($get) => in_array('Other', (array) $get('customer_type')))
                    ->required(fn ($get) => in_array('Other', (array) $get('customer_type')))
                    ->afterStateHydrated(function ($set, $record) {
                        if (! $record) return;

                        $valid = [
                            'Coffee Farm / Estate',
                            'Processing Facility',
                            'Roastery',
                            'Café / Retailer',
                            'Exporter / Importer',
                            'Government Institution / NGO',
                            'Educational / Research Institution',
                        ];

                        $items = explode(',', (string) $record->customer_type);
                        $custom = collect($items)->first(fn ($item) => !in_array($item, $valid));

                        if ($custom) {
                            $set('customer_type_other', $custom);
                        }
                    }),

                CheckboxList::make('coffee_type')
                    ->label('What type of coffee are you submitting for evaluation?')
                    ->options([
                        'Green Bean Arabica (Single Origin)' => 'Green Bean Arabica (Single Origin)',
                        'Roasted Bean - Blend Arabica' => 'Roasted Bean - Blend Arabica',
                        'Green Bean Canephora / Robusta (Single Origin)' => 'Green Bean Canephora / Robusta (Single Origin)',
                        'Roasted Bean Canephora / Robusta' => 'Roasted Bean Canephora / Robusta',
                        'Roasted Bean Arabica' => 'Roasted Bean Arabica',
                        'Roasted Bean - Blend Arabica & Canephora / Robusta' => 'Roasted Bean - Blend Arabica & Canephora / Robusta',
                        'Roasted Bean - Blend Canephora Robusta' => 'Roasted Bean - Blend Canephora Robusta',
                        'Other' => 'Other',
                    ])
                    ->reactive()
                    ->columns(2)
                    ->required()
                    ->formatStateUsing(function ($state) {
                        $items = is_array($state) ? $state : explode(',', (string) $state);
                        $valid = [
                            'Green Bean Arabica (Single Origin)',
                            'Roasted Bean - Blend Arabica',
                            'Green Bean Canephora / Robusta (Single Origin)',
                            'Roasted Bean Canephora / Robusta',
                            'Roasted Bean Arabica',
                            'Roasted Bean - Blend Arabica & Canephora / Robusta',
                            'Roasted Bean - Blend Canephora Robusta',
                        ];

                        return collect($items)
                            ->map(fn ($item) => in_array($item, $valid) ? $item : 'Other')
                            ->unique()
                            ->values()
                            ->all();
                    })
                    ->dehydrateStateUsing(function ($state, $get) {
                        if (!is_array($state)) return $state;

                        return implode(',', array_map(function ($item) use ($get) {
                            return $item === 'Other'
                                ? $get('coffee_type_other')
                                : $item;
                        }, $state));
                    }),

                TextInput::make('coffee_type_other')
                    ->label('Please specify other coffee type')
                    ->reactive()
                    ->visible(fn ($get) => in_array('Other', (array) $get('coffee_type')))
                    ->required(fn ($get) => in_array('Other', (array) $get('coffee_type')))
                    ->afterStateHydrated(function ($set, $record) {
                        if (! $record) return;

                        $valid = [
                            'Green Bean Arabica (Single Origin)',
                            'Roasted Bean - Blend Arabica',
                            'Green Bean Canephora / Robusta (Single Origin)',
                            'Roasted Bean Canephora / Robusta',
                            'Roasted Bean Arabica',
                            'Roasted Bean - Blend Arabica & Canephora / Robusta',
                            'Roasted Bean - Blend Canephora Robusta',
                        ];

                        $items = explode(',', (string) $record->coffee_type);
                        $custom = collect($items)->first(fn ($item) => !in_array($item, $valid));

                        if ($custom) {
                            $set('coffee_type_other', $custom);
                        }
                    }),

                    TextInput::make('coffee_sample_name')
                        ->label('Coffee Sample Name')
                        ->required(),

                    TextInput::make('lot_number')
                        ->label('Lot Number')
                        ->required(),

                    TextInput::make('total_lot_quantity')
                        ->numeric()
                        ->label('Total Lot Quantity')
                        ->required(),

                    TextInput::make('origin')
                        ->required(),

                    TextInput::make('variety')
                        ->required(),

                    TextInput::make('altitude')
                        ->required(),

                    TextInput::make('post_harvest_process')
                        ->label('Post Harvest Process')
                        ->required(),

                    DatePicker::make('harvest_date')
                        ->label('Harvest Date')
                        ->required(),

                    TextInput::make('green_bean_condition')
                        ->label('Green Bean Condition')
                        ->required(),

                    TextInput::make('sort_before_sending')
                        ->label('Sort Before Sending')
                        ->required(),

                    Textarea::make('specific_goal')
                        ->label('Specific Goal'),

                    Textarea::make('notes'),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code_hpq')->label('Kode HPQ')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('full_name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('brand_name')->label('Merk')->searchable(),
                Tables\Columns\TextColumn::make('contact_number')->label('Whatshapp')->searchable(),
                Tables\Columns\TextColumn::make('address')->label('Alamat')->searchable(),
                Tables\Columns\TextColumn::make('customer_type')->label('Tipe Pelanggan')->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match(trim(strtolower($state))) {
                    'waiting' => 'danger',
                    'scoring' => 'info',
                    'completed' => 'success',
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn ($record) => count($record->scores) >= 3),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHpqs::route('/'),
            'create' => Pages\CreateHpq::route('/create'),
            'edit' => Pages\EditHpq::route('/{record}/edit'),
            'view' => Pages\ViewHpq::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create hpqs');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('edit hpqs');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete hpqs');
    }
}
