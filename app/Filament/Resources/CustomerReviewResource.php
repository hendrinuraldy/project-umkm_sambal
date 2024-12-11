<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerReviewResource\Pages;
use App\Filament\Resources\CustomerReviewResource\RelationManagers;
use App\Models\CustomerReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerReviewResource extends Resource
{
    protected static ?string $model = CustomerReview::class;
    protected static ?string $navigationGroup = 'Customer';
    public static ?string $pluralLabel = 'Review Pelanggan';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("username")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("rating")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("rating")
                    ->label("Rating")
                    ->formatStateUsing(function (CustomerReview $record) {
                        return str_repeat('★', $record->rating); // Mengulang simbol bintang sesuai rating
                    })
                    ->color(function (CustomerReview $record) {
                        return match ($record->rating) {
                            5 => 'text-yellow-500', // Warna untuk rating 5
                            4 => 'text-yellow-400', // Warna untuk rating 4
                            3 => 'text-yellow-300', // Warna untuk rating 3
                            2 => 'text-yellow-200', // Warna untuk rating 2
                            1 => 'text-yellow-100', // Warna untuk rating 1
                            default => 'text-gray-400',
                        };
                    })
                    ->sortable()
                    ->searchable()
                ,
                Tables\Columns\TextColumn::make("comments")
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label("Delete"),
                ])->label("Delete"),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // Disable create button
    public static function canCreate(): bool
    {
        return false;
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerReviews::route('/'),
            // 'create' => Pages\CreateCustomerReview::route('/create'),
            // 'edit' => Pages\EditCustomerReview::route('/{record}/edit'),
        ];
    }
}
