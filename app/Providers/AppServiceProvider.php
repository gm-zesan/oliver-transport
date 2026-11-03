<?php

namespace App\Providers;

use App\View\Components\Layouts\App;
use App\View\Components\Layouts\Guest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Explicitly register layouts outside components directory
        Blade::component(App::class, 'layouts.app');
        Blade::component(Guest::class, 'layouts.guest');

        // Enforce strict N+1 query prevention and attribute protection in non-production environments
        Model::preventLazyLoading(! app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(! app()->isProduction());
    }
}
