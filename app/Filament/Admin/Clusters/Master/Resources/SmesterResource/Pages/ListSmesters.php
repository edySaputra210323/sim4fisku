<?php

namespace App\Filament\Admin\Clusters\Master\Resources\SmesterResource\Pages;

use App\Filament\Admin\Clusters\Master\Resources\SmesterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSmesters extends ListRecords
{
    protected static string $resource = SmesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
