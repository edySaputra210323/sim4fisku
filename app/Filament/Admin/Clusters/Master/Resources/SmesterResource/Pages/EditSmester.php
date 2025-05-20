<?php

namespace App\Filament\Admin\Clusters\Master\Resources\SmesterResource\Pages;

use App\Filament\Admin\Clusters\Master\Resources\SmesterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSmester extends EditRecord
{
    protected static string $resource = SmesterResource::class;

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

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['status'] ?? false) {
            $this->getModel()::where('id', '!=', $this->record->id)
                ->update(['status' => false]);
        }
        
        return $data;
    }
}
