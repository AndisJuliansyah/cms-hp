<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('route')->maxLength(255),
                Forms\Components\TextInput::make('icon')->maxLength(255),
                Forms\Components\Toggle::make('is_active')->label('Active')->default(true),
                Forms\Components\MultiSelect::make('permissions')
                    ->relationship('permissions', 'name')
                    ->preload()
                    ->label('Permissions'),
                Forms\Components\TextInput::make('group')->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('route')->sortable(),
                Tables\Columns\BooleanColumn::make('is_active')->label('Active'),
                Tables\Columns\TagsColumn::make('permissions.name')->label('Permissions'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create menus');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('edit menus');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete menus');
    }
}
