<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaction;
use Carbon\Carbon;

class StatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {

        $startDate = ! is_null($this->pageFilters['startDate'] ?? null) ?
            Carbon::parse($this->pageFilters['startDate']) :
            null;

        $endDate = ! is_null($this->pageFilters['endDate'] ?? null) ?
            Carbon::parse($this->pageFilters['endDate']) :
            now();

        $pemasukan = Transaction::incomes()
        ->whereBetween('date_transaction', [$startDate, $endDate])
        ->sum('amount');
        $pengeluaran = Transaction::expenses()
        ->whereBetween('date_transaction', [$startDate, $endDate])
        ->sum('amount');
        $selisih = $pemasukan - $pengeluaran;
        return [
            Stat::make('Total Pemasukan', $pemasukan)
            ->description('32k increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),
            Stat::make('Total Pengeluaran', $pengeluaran)
            ->description('7% increase')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('danger'),
            Stat::make('Selisih', $selisih),
        ];
    }
}
