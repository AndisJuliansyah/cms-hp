<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
                ->schema([
                    Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Textarea::make('location')
                    ->label('Lokasi')
                    ->rows(2),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->rows(5),

                Forms\Components\TextInput::make('seo_title')
                    ->label('SEO Judul')
                    ->maxLength(70)
                    ->helperText('Judul SEO event, maksimal 70 karakter'),

                Forms\Components\Textarea::make('seo_description')
                    ->label('SEO Deskripsi')
                    ->rows(3)
                    ->maxLength(160)
                    ->helperText('Deskripsi SEO event, maksimal 160 karakter'),
                FileUpload::make('poster_path')
                    ->label('Poster')
                    ->image()
                    ->required()
                    ->directory('events')
                    ->disk('public')
                    ->preserveFilenames()
                    ->openable()
                    ->previewable()
                    ->maxSize(2048),

                Forms\Components\DateTimePicker::make('event_date')
                    ->label('Tanggal Event')
                    ->required(),

                Forms\Components\Toggle::make('is_published')
                    ->label('Publikasi')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('poster_path')
                ->label('Poster')
                ->disk('public')
                ->height(50)
                ->width(50),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->limit(30),

                Tables\Columns\TextColumn::make('event_date')
                    ->label('Mulai')
                    ->dateTime(),

                Tables\Columns\BooleanColumn::make('is_published')
                    ->label('Publikasi'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create events');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('edit events');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete events');
    }
}
