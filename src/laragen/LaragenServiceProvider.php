<?php

namespace Mwl91\Laragen;

use Illuminate\Support\ServiceProvider;

final class LaragenServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->loadDependencies();
    }

    private function loadDependencies(): void
    {
        // $this->app->bind(
        //     ServiceInterface::class,
        //     Service::class
        // );
    }
}
