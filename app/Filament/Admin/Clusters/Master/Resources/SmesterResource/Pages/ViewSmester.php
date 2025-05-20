<?php

namespace App\Filament\Admin\Clusters\Master\Resources\SmesterResource\Pages;

use App\Filament\Admin\Clusters\Master\Resources\SmesterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSmester extends ViewRecord
{
    protected static string $resource = SmesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
