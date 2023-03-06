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
    }

    /**
     *
     * @return void
     */
    public function boot(): void
    {
        View::addNamespace('web', base_path('resources/views'));
    }
}
