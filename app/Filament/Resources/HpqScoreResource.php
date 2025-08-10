<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HpqScoreResource\Pages;
use App\Filament\Resources\HpqScoreResource\RelationManagers;
use App\Models\HpqScore;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Model;

class HpqScoreResource extends Resource
{
    protected static ?string $model = HpqScore::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('code_hpq')
                    ->label('Kode HPQ')
                    ->options(\App\Models\Hpq::pluck('code_hpq', 'id'))
                    ->required()
                    ->unique(
                        ignoreRecord: true,
                        table: HpqScore::class,
                        column: 'code_hpq',
                        modifyRuleUsing: function ($rule, $livewire) {
                            $juryId = data_get($livewire->record, 'jury_id') ?? auth()->id();

                            return $rule->where(fn ($query) =>
                                $query->where('jury_id', $juryId)
                            );
                        }
                    ),
                Forms\Components\TextInput::make('judge_name')
                    ->label('Nama Penilai')
                    ->default(fn () => Auth::user()?->name)
                    ->disabled()
                    ->required(),

                // Fragrance
                Forms\Components\Fieldset::make('assesment_fragrance')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('fragrance_aroma')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                            Forms\Components\Select::make('assesment_fragrance')
                                ->label('Assessment - Descriptive')
                                ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                ->nullable(),
                        ]),
                    ]),

                // Aroma
                Forms\Components\Fieldset::make('Aroma')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Select::make('assesment_aroma')
                                ->label('Assessment - Descriptive')
                                ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                ->nullable(),
                        ]),
                    ]),

                // Flavor
                Forms\Components\Fieldset::make('Flavor')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('flavor')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                            Forms\Components\Select::make('assesment_flavor')
                                ->label('Assessment - Descriptive')
                                ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                ->nullable(),
                        ]),
                    ]),

                // Aftertaste
                Forms\Components\Fieldset::make('Aftertaste')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('aftertaste')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                            Forms\Components\Select::make('assesment_aftertaste')
                                ->label('Assessment - Descriptive')
                                ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                ->nullable(),
                        ]),
                    ]),

                // Acidity
                Forms\Components\Fieldset::make('Acidity')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('acidity')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                            Forms\Components\Select::make('assesment_acidity')
                                ->label('Assessment - Descriptive')
                                ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                ->nullable(),
                        ]),
                    ]),

                // Body
                Forms\Components\Fieldset::make('Body')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('body')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                            Forms\Components\Select::make('assesment_body')
                                ->label('Assessment - Descriptive')
                                ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                ->nullable(),
                        ]),
                    ]),

                // Sweetness
                Forms\Components\Fieldset::make('Sweetness')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('sweetness')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                            Forms\Components\Select::make('assesment_sweetness')
                                ->label('Assessment - Descriptive')
                                ->options(['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'])
                                ->nullable(),
                        ]),
                    ]),

                // Uniformity
                Forms\Components\Fieldset::make('Uniformity')
                    ->schema([

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('uniformity')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                            Forms\Components\Select::make('assesment_uniformity')
                                ->label('Assessment - Descriptive')
                                ->options(['None' => 'None', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'])
                                ->nullable(),
                        ]),
                    ]),

                // Balance
                Forms\Components\TextInput::make('balance')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),

                // Clean cup
                Forms\Components\TextInput::make('clean_cup')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),

                // Overall
                Forms\Components\TextInput::make('overall')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),

                Forms\Components\Fieldset::make('Defect')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('defect')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                            Forms\Components\Select::make('assesment_defect')
                            ->label('Assessment - Descriptive')
                            ->options(['None' => 'None', 'Moldy' => 'Moldy', 'Phenolic' => 'Phenolic', 'Potato' => 'Potato'])
                            ->nullable(),
                        ]),
                    ]),

                // Textarea tambahan
                Forms\Components\Textarea::make('fragrance_aroma_notes')
                    ->label('Fragrance & Aroma Notes')
                    ->rows(3)
                    ->nullable(),
                Forms\Components\Textarea::make('flavor_aftertaste_notes')
                    ->label('Flavor & Aftertaste Notes')
                    ->rows(3)
                    ->nullable(),
                Forms\Components\Textarea::make('acidity_mouthfeel_other_notes')
                    ->label('Acidity, Mouthfeel & Other Notes')
                    ->rows(3)
                    ->nullable(),

                // Catatan Penilaian
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan Penilaian')
                    ->rows(4)
                    ->placeholder('Masukkan catatan tambahan jika ada...')
                    ->maxLength(1000),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code_hpq')->label('Kode HPQ'),
                Tables\Columns\TextColumn::make('jury.name')->label('Penilai'),
                Tables\Columns\TextColumn::make('average_score')
                    ->label('Skor Rata-Rata')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_score')
                    ->label('Total Skor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y, H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListHpqScores::route('/'),
            'create' => Pages\CreateHpqScore::route('/create'),
            'edit' => Pages\EditHpqScore::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create hpqscores');
    }

    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();
        return $user->hasRole('Super Admin') || $user->id === $record->jury_id;
    }

    public static function canDelete(Model $record): bool
    {
        $user = auth()->user();
        return $user->hasRole('Super Admin') || $user->id === $record->jury_id;
    }
}
