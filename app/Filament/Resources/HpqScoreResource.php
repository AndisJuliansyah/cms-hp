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
                    ->options(\App\Models\Hpq::pluck('code_hpq', 'code_hpq'))
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
                Forms\Components\TextInput::make('fragrance_aroma')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                Forms\Components\TextInput::make('flavor')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                Forms\Components\TextInput::make('aftertaste')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                Forms\Components\TextInput::make('acidity')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                Forms\Components\TextInput::make('body')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                Forms\Components\TextInput::make('balance')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                Forms\Components\TextInput::make('uniformity')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                Forms\Components\TextInput::make('sweetness')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                Forms\Components\TextInput::make('clean_cup')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
                Forms\Components\TextInput::make('overall')->numeric()->required()->minValue(0)->maxValue(10)->step(0.01),
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
