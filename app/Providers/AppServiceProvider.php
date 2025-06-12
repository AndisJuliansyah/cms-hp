<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        FilamentAsset::register([
            Css::make('example-local-stylesheet', asset('css/filament-custom.css')),
        ]);
    }
}
