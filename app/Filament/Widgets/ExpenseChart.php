<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Expense;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class ExpenseChart extends ChartWidget
{
    protected static ?string $heading = 'Expense';
    protected static ?int $sort = 2;
    protected static string $color = 'danger';
    public ?string $filter = 'today';

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $dateRange = match ($activeFilter) {
            'today' => [
                'start'  => now()->startOfDay(),
                'end'    => now()->endOfDay(),
                'period' => 'perHour',
            ],
            'week' => [
                'start'  => now()->startOfWeek(),
                'end'    => now()->endOfWeek(),
                'period' => 'perDay',
            ],
            'month' => [
                'start'  => now()->startOfMonth(),
                'end'    => now()->endOfMonth(),
                'period' => 'perDay',
            ],
            'year' => [
                'start'  => now()->startOfYear(),
                'end'    => now()->endOfYear(),
                'period' => 'perMonth',
            ],
        };

        $query = Trend::model(Expense::class)
            ->between(
                start: $dateRange['start'],
                end: $dateRange['end'],
            );

        if ($dateRange['period'] == 'perHour') {
            $query->perHour();
        } else if ($dateRange['period'] == 'perDay') {
            $query->perDay();
        } else {
            $query->perMonth();
        }

        $data = $query->sum('amount');

        $labels = $data->map(function (TrendValue $value) use ($dateRange) {
            $date = Carbon::parse($value->date);

            if ($dateRange['period'] == 'perHour') {
                return $date->format('H:i');
            } else if ($dateRange['period'] == 'perDay') {
                return $date->format('d M');
            }
            return $date->format('M Y');
        });


        return [
            'datasets' => [
                [
                    'label' => 'Omset '.$this->getFilters()[$activeFilter],
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }


    protected function getType(): string
    {
        return 'line';
    }

}
