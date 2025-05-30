<?php

namespace App\Filament\Resources\HpqScoreResource\Pages;

use App\Filament\Resources\HpqScoreResource;
use App\Models\HpqScore;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Actions\Action;

class CreateHpqScore extends CreateRecord
{
    protected static string $resource = HpqScoreResource::class;

    protected ?string $codeHpq = null;

    public function mount(): void
    {
        parent::mount();

        $this->codeHpq = request()->get('code_hpq');
        if ($this->codeHpq) {
            $existingScore = HpqScore::where('jury_id', Auth::id())
                ->where('code_hpq', $this->codeHpq)
                ->first();

            if ($existingScore) {
                $this->redirect(HpqScoreResource::getUrl('edit', ['record' => $existingScore]));
            }

            $this->form->fill([
                'code_hpq' => $this->codeHpq,
            ]);
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['jury_id'] = Auth::id();
        $data['judge_name'] = Auth::user()->name;

        return $data;
    }

    protected function getFormActions(): array
    {
        return array_filter(parent::getFormActions(), function ($action) {
            return $action->getName() !== 'createAnother';
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
