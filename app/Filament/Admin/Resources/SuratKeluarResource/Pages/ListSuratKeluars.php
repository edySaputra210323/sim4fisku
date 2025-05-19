<?php

namespace App\Filament\Admin\Resources\SuratKeluarResource\Pages;

use App\Filament\Admin\Resources\SuratKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratKeluars extends ListRecords
{
    protected static string $resource = SuratKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
