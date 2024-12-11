<?php

namespace App\Filament\Resources\ResellerProfileResource\Pages;

use App\Filament\Resources\ResellerProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResellerProfile extends EditRecord
{
    protected static string $resource = ResellerProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
