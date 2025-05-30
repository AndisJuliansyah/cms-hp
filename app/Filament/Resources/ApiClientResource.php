<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiClientResource\Pages;
use App\Filament\Resources\ApiClientResource\RelationManagers;
use App\Models\ApiClient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class ApiClientResource extends Resource
{
    protected static ?string $model = ApiClient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('allowed_domains')
                    ->label('Allowed Domains')
                    ->placeholder('example.com,www.example.com')
                    ->helperText('Pisahkan dengan koma untuk multiple domain')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('public_key')->copyable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
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
            'index' => Pages\ListApiClients::route('/'),
            'create' => Pages\CreateApiClient::route('/create'),
            'edit' => Pages\EditApiClient::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create apiclients');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('edit apiclients');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete apiclients');
    }
}
