<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->images = $data['images'] ?? [];
        unset($data['images']);
        return $data;
    }

    protected function afterCreate(): void
    {
        foreach ($this->images as $imagePath) {
            $this->record->images()->create([
                'file_path' => $imagePath,
            ]);
        }
    }

}
