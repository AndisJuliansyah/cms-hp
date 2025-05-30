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

class HpqResource extends Resource
{
    protected static ?string $model = Hpq::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
