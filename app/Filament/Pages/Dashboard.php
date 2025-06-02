<?php

namespace App\Filament\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Resources\Pages\Page;
use App\Filament\Widgets\VisitorStats;
use App\Filament\Widgets\InteractionStats;
use App\Filament\Widgets\ContentAnalysis;
use App\Filament\Widgets\SeoStats;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getHeaderWidgetsColumns(): int
    {
        return 4;
    }
}
