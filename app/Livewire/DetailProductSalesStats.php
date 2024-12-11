<?php
namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Sales;

class DetailProductSalesStats extends BaseWidget
{
    public $product; // Produk yang akan digunakan dalam query


    // Gunakan mount untuk menginisialisasi data produk, startDate, dan endDate
    public function mount($product)
    {
        $this->product = $product;
    }

    protected function getStats(): array
    {
        return $this->calculateStats();
    }

    protected function calculateStats(): array
    {
        // Query Sales untuk produk yang dipilih
        $salesQuery = Sales::where('product_id', $this->product->id);

        // Hitung data statistik
        $totalRevenue = $salesQuery->sum('pendapatan');
        $totalUnitsSold = $salesQuery->sum('stok_terjual');
        $averageRevenue = $salesQuery->avg('pendapatan');

        // Kembalikan statistik dalam bentuk array
        return [
            Stat::make('Total Revenue', number_format($totalRevenue, 0, ',', '.') . ' IDR')
                ->description('Total pendapatan dari produk'),

            Stat::make('Total Units Sold', number_format($totalUnitsSold, 0, ',', '.'))
                ->description('Total unit terjual'),

            Stat::make('Average Revenue', number_format($averageRevenue, 0, ',', '.') . ' IDR')
                ->description('Pendapatan rata-rata per penjualan'),
        ];
    }


}
