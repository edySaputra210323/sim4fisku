<?php

namespace App\Filament\Admin\Resources\SuratKeluarResource\Pages;

use App\Filament\Admin\Resources\SuratKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuratKeluar extends EditRecord
{
    protected static string $resource = SuratKeluarResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
