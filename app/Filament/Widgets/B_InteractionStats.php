<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Hpq;
use Illuminate\Support\Carbon;

class B_InteractionStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        $totalHpqs = Hpq::count();
        $hpqsThisMonth = Hpq::where('created_at', '>=', $startOfMonth)->count();
        $hpqsToday = Hpq::whereDate('created_at', $today)->count();

        return [
            Stat::make('Total Pengajuan HPQ', $totalHpqs)
                ->description('Sejak awal pencatatan')
                ->icon('heroicon-o-users')
                ->color('info'),

            Stat::make('Pengajuan Bulan Ini', $hpqsThisMonth)
                ->description('Dari awal bulan ini')
                ->icon('heroicon-o-calendar')
                ->color('success'),

            Stat::make('Pengajuan Hari Ini', $hpqsToday)
                ->description('Hingga saat ini')
                ->icon('heroicon-o-clock')
                ->color('warning'),
        ];
    }

    public function getColumns(): int
    {
        return 3;
    }
}
