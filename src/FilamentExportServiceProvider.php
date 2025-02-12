<?php

namespace AlperenErsoy\FilamentExport;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class FilamentExportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-export.php', 'filament-export');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-export');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-export');

        $this->publishes([
            __DIR__ . '/../config/filament-export.php' => config_path('filament-export.php'),
        ], 'config');

        Filament::serving(function () {
            Filament::registerScripts([__DIR__ . '/../resources/js/filament-export.js']);
            Filament::registerStyles([__DIR__ . '/../resources/css/filament-export.css']);
        });
    }
}
