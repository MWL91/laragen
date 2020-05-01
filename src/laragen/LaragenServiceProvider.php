<?php

namespace Mwl91\Laragen;

use Illuminate\Support\ServiceProvider;
use Mwl91\Laragen\Generators\MethodGenerator;
use Mwl91\Laragen\Generators\ServiceGenerator;
use Mwl91\Laragen\Commands\GenerateServiceCommand;
use Mwl91\Laragen\Interfaces\MethodGeneratorInterface;
use Mwl91\Laragen\Interfaces\ServiceGeneratorInterface;

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
            ServiceGeneratorInterface::class,
            ServiceGenerator::class
        );
    }

    private function loadCommands(): void
    {
        $this->commands([
            GenerateServiceCommand::class
        ]);
    }
}
