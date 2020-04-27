<?php

namespace Mwl91\Laragen;

use Illuminate\Support\ServiceProvider;
use Mwl91\Laragen\Services\LaragenService;
use Mwl91\Laragen\Commands\GenerateScaffoldCommand;
use Mwl91\Laragen\Services\Interfaces\LaragenServiceInterface;

final class LaragenServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->loadDependencies();

        if ($this->app->runningInConsole()) {
            $this->loadCommands();
        }

        $this->loadViewsFrom(__DIR__ . '/template/code', 'laragen');
    }

    private function loadDependencies(): void
    {
        $this->app->bind(
            LaragenServiceInterface::class,
            LaragenService::class
        );
    }

    private function loadCommands(): void
    {
        $this->commands([
            GenerateScaffoldCommand::class
        ]);
    }
}
