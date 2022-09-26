<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

final class AppServiceProvider extends ServiceProvider
{
    /**
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->registerResources();
    }

    /**
     *
     * @return void
     */
    private function registerResources(): void
    {
        View::addNamespace('web', base_path('resources/views'));
    }
}
