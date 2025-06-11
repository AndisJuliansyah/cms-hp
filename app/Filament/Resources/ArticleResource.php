<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('article_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\Select::make('author_id')
                    ->label('Penulis')
                    ->relationship('author', 'name')
                    ->required(),
                Forms\Components\Repeater::make('images')
                    ->label('Foto Artikel')
                    ->relationship()
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Gambar')
                            ->image()
                            ->disk('public')
                            ->directory('articles')
                            ->openable()
                            ->previewable()
                            ->preserveFilenames()
                            ->required(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('seo_title')
                    ->label('SEO Judul'),

                Forms\Components\Textarea::make('seo_description')
                    ->label('SEO Deskripsi')
                    ->rows(3),
                Forms\Components\Textarea::make('excerpt')->label('Deskripsi Singkat')->rows(3),
                Forms\Components\RichEditor::make('body')->label('Konten')->required()->columnSpan('full'),
                Forms\Components\Toggle::make('is_published')->label('Publikasi')->default(true),
                Forms\Components\DateTimePicker::make('published_at')->label('Tanggal Publikasi')
            ]);
    }

    public function handleTempFileDeleted(string $fileName): void
    {
        $tmpPath = storage_path('app/livewire-tmp/' . $fileName);

        if (file_exists($tmpPath)) {
            unlink($tmpPath);
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\ImageColumn::make('images.0.image_path')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->height(50)
                    ->width(50),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->sortable(),
                Tables\Columns\TextColumn::make('author.name')->label('Penulis'),
                Tables\Columns\BooleanColumn::make('is_published')->label('Publikasi'),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create articles');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('edit articles');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete articles');
    }
}
