<?php

namespace App\Filament\Resources\SalesResource\Pages;

use App\Filament\Resources\SalesResource;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use App\Models\Category;
use App\Models\Product;
use Filament\Tables\Actions\Action;
class ProductSalesPerCategory extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    protected static ?string $title = "Sales Produk Per-Kategori";
    protected static string $resource = SalesResource::class;
    protected static string $view = 'filament.resources.sales-resource.pages.product-sales-per-category';

    public $category;
    public $totalRevenue;
    // Method mount to load data when page is accessed
    public function mount($category)
    {
        // Load the category using the ID from the URL
        $this->category = Category::findOrFail($category);

        $hasProduct = Product::where('category_id', '=',$this->category->id)->exists();
        if (!$category || !$hasProduct) {
            session()->flash('error', 'Belum ada produk untuk kategori ini.');
            return redirect()->route('filament.admin.resources.sales.laporan');
        }
        // Calculate total revenue for the category by getting the top sales for each product
        $this->totalRevenue = Product::where('category_id', $category)
            ->join('sales', 'products.id', '=', 'sales.product_id')
            ->groupBy('products.id')  // Group by product to ensure each product is counted once
            ->selectRaw('MAX(sales.pendapatan) as top_revenue')  // Select max revenue for each product
            ->get()  // Get all the products with their top revenue
            ->sum('top_revenue');  // Sum up the top revenue of all products
    }

    /*define PK nya itu id lohh, kalau pake uuid bisa ganti:  return (string) $record->uuid; // Jika primary key di model bukan 'id'
     */
    public function getTableRecordKey($record): string
    {
        return (string) $record->id; // Pastikan ini mengembalikan nilai primary key dari record
    }

    // Define the query for the table
    protected function getTableQuery()
    {
        // Query products with their highest sales revenue per category
        return Product::where('category_id', $this->category->id)
            ->join('sales', 'products.id', '=', 'sales.product_id')
            ->groupBy('products.id', 'products.nama', 'products.created_at', 'products.category_id')
            ->selectRaw('products.id, products.nama, products.created_at, SUM(sales.pendapatan) as top_revenue, SUM(sales.stok_terjual) as stok_terjual');
    }

    // Define the columns of the table
    protected function getTableColumns(): array
    {
        return
            [
                Tables\Columns\TextColumn::make('nama')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('stok_terjual')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('top_revenue')
                    ->label('Pendapatan')
                    ->money("IDR")
                    ->sortable(),

            ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('edit')
                ->label('Detail Laporan')
                ->url(fn(Product $product): string => route('filament.admin.resources.sales.detailProductSales', ['product' => $product]))
        ];
    }


}