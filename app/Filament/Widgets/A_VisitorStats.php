<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Analytics;
use Spatie\Analytics\Period;

class A_VisitorStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $visitorsToday = Analytics::fetchTotalVisitorsAndPageViews(Period::days(1))->sum('visitors');

        $monthlyData = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
        $visitorsMonth = $monthlyData->sum('visitors');
        $pageViews = $monthlyData->sum('pageViews');

        return [
            Stat::make('Pengunjung Hari Ini', $visitorsToday),
            Stat::make('Pengunjung Bulan Ini', $visitorsMonth),
            Stat::make('Tampilan Halaman', $pageViews),
        ];
    }

    public function getColumns(): int
    {
        return 3;
    }
}
