<?php

namespace App\Filament\Admin\Clusters\Master\Resources\TahunAjaranResource\Pages;

use App\Filament\Admin\Clusters\Master\Resources\TahunAjaranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTahunAjaran extends CreateRecord
{
    
    protected static string $resource = TahunAjaranResource::class;

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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['status'] ?? false) {
            $this->getModel()::query()
                ->update(['status' => false]);
        }
        
        return $data;
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }
}
