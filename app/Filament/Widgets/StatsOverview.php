<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $productCount = Product::count();
        $orderCount = Order::count();
        $omset = Order::sum('total_price');
        $expense = Expense::sum('amount');

        return [
            Stat::make('Produk', $productCount),
            Stat::make('Order', $orderCount),
            Stat::make('Omset', 'Rp '.number_format($omset, 0, ',', '.')),
            Stat::make('Expense', 'Rp '.number_format($expense, 0, ',', '.')),
        ];
    }
}
