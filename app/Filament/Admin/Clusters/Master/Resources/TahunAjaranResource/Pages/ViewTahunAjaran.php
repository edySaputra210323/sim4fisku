<?php

namespace App\Filament\Admin\Clusters\Master\Resources\TahunAjaranResource\Pages;

use App\Filament\Admin\Clusters\Master\Resources\TahunAjaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTahunAjaran extends ViewRecord
{
    protected static string $resource = TahunAjaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
