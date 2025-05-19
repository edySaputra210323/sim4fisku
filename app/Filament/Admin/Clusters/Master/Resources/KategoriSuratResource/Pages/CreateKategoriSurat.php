<?php

namespace App\Filament\Admin\Clusters\Master\Resources\KategoriSuratResource\Pages;

use App\Filament\Admin\Clusters\Master\Resources\KategoriSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKategoriSurat extends CreateRecord
{
    protected static string $resource = KategoriSuratResource::class;

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

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }
}
