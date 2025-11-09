<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Transaction;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class XexpensesChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected ?string $heading = 'Pengeluaran';
    protected string $color = 'danger';

    protected function getData(): array
    {
        $startDate = ! is_null($this->pageFilters['startDate'] ?? null) ?
            Carbon::parse($this->pageFilters['startDate']) :
            now()->subDays(30);

        $endDate = ! is_null($this->pageFilters['endDate'] ?? null) ?
            Carbon::parse($this->pageFilters['endDate']) :
            now();

        $data = Trend::query(Transaction::expenses())
        ->between(
            start: $startDate,
            end: $endDate,
        )
        ->perDay()
        ->sum('amount');

        return [
            'datasets' => [
                [
                    'label' => 'Pengeluaran perhari',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
