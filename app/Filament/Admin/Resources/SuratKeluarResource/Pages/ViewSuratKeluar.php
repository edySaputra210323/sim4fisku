<?php

namespace App\Filament\Admin\Resources\SuratKeluarResource\Pages;

use App\Filament\Admin\Resources\SuratKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSuratKeluar extends ViewRecord
{
    protected static string $resource = SuratKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
