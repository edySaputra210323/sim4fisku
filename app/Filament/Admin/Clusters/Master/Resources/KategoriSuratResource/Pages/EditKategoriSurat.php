<?php

namespace App\Filament\Admin\Clusters\Master\Resources\KategoriSuratResource\Pages;

use App\Filament\Admin\Clusters\Master\Resources\KategoriSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriSurat extends EditRecord
{
    protected static string $resource = KategoriSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }
}
