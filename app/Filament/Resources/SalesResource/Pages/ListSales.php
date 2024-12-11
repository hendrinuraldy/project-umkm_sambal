<?php

namespace App\Filament\Resources\SalesResource\Pages;

use App\Filament\Resources\SalesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSales extends ListRecords
{
    protected static string $resource = SalesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label("Buat Data Sales"),
            Actions\CreateAction::make('Laporan')
                ->label("Lihat Laporan")
                ->url(fn() => route('filament.admin.resources.sales.laporan'))
                ->color("success")
        ];
    }
}