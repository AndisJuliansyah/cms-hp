<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HpqResource\Pages;
use App\Filament\Resources\HpqResource\RelationManagers;
use App\Models\Hpq;
use App\Models\User;
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
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;

class HpqResource extends Resource
{
    protected static ?string $model = Hpq::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
                ->schema([
                    TextInput::make('code_hpq')
                        ->label('HPQ Code')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->visible(fn ($livewire) => str($livewire::class)->contains('Edit')),

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

                    // --- Tabs untuk Penilaian Juri ---
                    Repeater::make('hpq_scores')
                    ->label('Jury Assessment')
                    ->relationship('scores')
                    ->visible(fn () => auth()->user()->hasRole('Super Admin'))
                    ->schema([
                        TextInput::make('code_hpq')
                            ->label('HPQ Code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('hpq_scores', collect($state ? [] : $get('hpq_scores') ?? [])->map(function ($item) use ($state) {
                                    $item['code_hpq'] = $state;
                                    return $item;
                                })->toArray());
                            })
                            ->visible(fn ($livewire) => Str::contains($livewire::class, 'Edit')),
                        Select::make('jury_id')
                            ->label('Judge Name')
                            ->options(function () {
                                return \App\Models\User::whereHas('roles', function ($query) {
                                    $query->where('name', 'judge');
                                })->pluck('name', 'id');
                            })
                            ->required()
                            ->rules([
                                fn (\Filament\Forms\Get $get, $record) => \Illuminate\Validation\Rule::unique(\App\Models\HpqScore::class, 'jury_id')
                                    ->where('code_hpq', $record ? $record->hpq->code_hpq : $get('../code_hpq'))
                                    ->ignore($record ? $record->id : null),
                            ])
                            ->afterStateUpdated(function ($state, \Filament\Forms\Set $set) {
                                $user = \App\Models\User::find($state);
                                $set('judge_name', $user ? $user->name : null);
                            })
                            ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),

                        // Hidden field untuk menyimpan judge_name
                        Forms\Components\Hidden::make('judge_name'),

                        Fieldset::make('fragrance')
                            ->label('Fragrance')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('fragrance_aroma')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0)
                                        ->maxValue(10)
                                        ->step(0.01)
                                        ->label('Fragrance/Aroma'),
                                    Select::make('assesment_fragrance')
                                        ->label('Assessment - Descriptive')
                                        ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                        ->nullable(),
                                ]),
                            ]),

                        Fieldset::make('aroma')
                            ->label('Aroma')
                            ->schema([
                                Grid::make(2)->schema([
                                    Select::make('assesment_aroma')
                                        ->label('Assessment - Descriptive')
                                        ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                        ->nullable(),
                                ]),
                            ]),

                        Fieldset::make('flavor')
                            ->label('Flavor')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('flavor')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0)
                                        ->maxValue(10)
                                        ->step(0.01)
                                        ->label('Flavor'),
                                    Select::make('assesment_flavor')
                                        ->label('Assessment - Descriptive')
                                        ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                        ->nullable(),
                                ]),
                            ]),

                        Fieldset::make('aftertaste')
                            ->label('Aftertaste')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('aftertaste')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0)
                                        ->maxValue(10)
                                        ->step(0.01)
                                        ->label('Aftertaste'),
                                    Select::make('assesment_aftertaste')
                                        ->label('Assessment - Descriptive')
                                        ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                        ->nullable(),
                                ]),
                            ]),

                        Fieldset::make('acidity')
                            ->label('Acidity')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('acidity')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0)
                                        ->maxValue(10)
                                        ->step(0.01)
                                        ->label('Acidity'),
                                    Select::make('assesment_acidity')
                                        ->label('Assessment - Descriptive')
                                        ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                        ->nullable(),
                                ]),
                            ]),

                        Fieldset::make('body')
                            ->label('Body')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('body')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0)
                                        ->maxValue(10)
                                        ->step(0.01)
                                        ->label('Body'),
                                    Select::make('assesment_body')
                                        ->label('Assessment - Descriptive')
                                        ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                        ->nullable(),
                                ]),
                            ]),

                        Fieldset::make('sweetness')
                            ->label('Sweetness')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('sweetness')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0)
                                        ->maxValue(10)
                                        ->step(0.01)
                                        ->label('Sweetness'),
                                    Select::make('assesment_sweetness')
                                        ->label('Assessment - Descriptive')
                                        ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                        ->nullable(),
                                ]),
                            ]),

                        Fieldset::make('uniformity')
                            ->label('Uniformity')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('uniformity')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0)
                                        ->maxValue(10)
                                        ->step(0.01)
                                        ->label('Uniformity'),
                                    Select::make('assesment_uniformity')
                                        ->label('Assessment - Descriptive')
                                        ->options(['None' => 'None', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'])
                                        ->nullable(),
                                ]),
                            ]),

                        TextInput::make('balance')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(10)
                            ->step(0.01)
                            ->label('Balance'),

                        TextInput::make('clean_cup')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(10)
                            ->step(0.01)
                            ->label('Clean Cup'),

                        TextInput::make('overall')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(10)
                            ->step(0.01)
                            ->label('Overall'),

                        Fieldset::make('Defect')
                            ->label('Defect')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('defect')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0)
                                        ->maxValue(10)
                                        ->step(0.01)
                                        ->label('Defect'),
                                    Select::make('assesment_defect')
                                        ->label('Defect')
                                        ->options(['None' => 'None', 'Moldy' => 'Moldy', 'Phenolic' => 'Phenolic', 'Potato' => 'Potato'])
                                        ->nullable(),
                                ]),
                            ]),

                        Textarea::make('fragrance_aroma_notes')
                            ->label('Fragrance & Aroma Notes')
                            ->rows(3)
                            ->nullable(),

                        Textarea::make('flavor_aftertaste_notes')
                            ->label('Flavor & Aftertaste Notes')
                            ->rows(3)
                            ->nullable(),

                        Textarea::make('acidity_mouthfeel_other_notes')
                            ->label('Acidity, Mouthfeel & Other Notes')
                            ->rows(3)
                            ->nullable(),

                        Textarea::make('notes')
                            ->label('Assessment Notes')
                            ->rows(4)
                            ->placeholder('Enter additional notes if any...')
                            ->maxLength(1000),
                    ])
                    ->maxItems(3)
                    ->defaultItems(1)
                    ->addActionLabel('Add Jury Assessment')
                    ->collapsible()
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('scores_count')
                ->label('Jury Assessment')
                ->counts('scores'),
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
