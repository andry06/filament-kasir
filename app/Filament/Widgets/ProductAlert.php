<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ProductAlert extends BaseWidget
{
    protected static ?string $heading = 'Produk hampir habis';
    protected static ?int $sort = 3;

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Sets up the table options for the widget.
     *
     * @param  \Filament\Tables\Table  $table
     * @return \Filament\Tables\Table
     */

/*******  05c41190-7bce-469e-b650-86e6cc3f1f6a  *******/    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::where('stock', '<=', 50)->orderBy('stock')
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->color(static function ($state): string {
                        if ($state < 20) {
                            return 'danger';
                        } else if ($state < 30) {
                            return 'warning';
                        } else {
                            return 'success';
                        }
                    })
                    ->sortable(),
            ])->defaultPaginationPageOption(5);
    }
}
