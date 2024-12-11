<?php

namespace App\Filament\Resources\ResellerProfileResource\Pages;

use App\Filament\Resources\ResellerProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResellerProfiles extends ListRecords
{
    protected static string $resource = ResellerProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label("Tambah Reseller"),
        ];
    }
}