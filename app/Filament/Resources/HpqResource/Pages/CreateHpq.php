<?php

namespace App\Filament\Resources\HpqResource\Pages;

use App\Filament\Resources\HpqResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Hpq;

class CreateHpq extends CreateRecord
{
    protected static string $resource = HpqResource::class;

    protected function getFormActions(): array
    {
        return array_filter(parent::getFormActions(), function ($action) {
            return $action->getName() !== 'createAnother';
        });
    }

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Format checkbox list to string
        $data['customer_type'] = is_array($data['customer_type']) ? implode(', ', $data['customer_type']) : $data['customer_type'];
        $data['coffee_type'] = is_array($data['coffee_type']) ? implode(', ', $data['coffee_type']) : $data['coffee_type'];

        // Generate code_hpq in format 0000001-GB
        $lastCode = Hpq::where('code_hpq', 'like', '%-GB')
            ->orderByDesc('created_at')
            ->value('code_hpq');

        if ($lastCode) {
            preg_match('/(\d+)-GB$/', $lastCode, $matches);
            $number = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
        } else {
            $number = 1;
        }

        $data['code_hpq'] = str_pad($number, 7, '0', STR_PAD_LEFT) . '-GB';

        return $data;
    }
}
