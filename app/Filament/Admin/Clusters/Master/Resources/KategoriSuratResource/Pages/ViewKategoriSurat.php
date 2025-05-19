<?php

namespace App\Filament\Admin\Clusters\Master\Resources\KategoriSuratResource\Pages;

use App\Filament\Admin\Clusters\Master\Resources\KategoriSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKategoriSurat extends ViewRecord
{
    protected static string $resource = KategoriSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
