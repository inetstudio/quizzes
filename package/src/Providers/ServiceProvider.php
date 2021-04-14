<?php

namespace InetStudio\QuizzesPackage\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerViews();
    }

    protected function registerConsoleCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands(
            [
                'InetStudio\QuizzesPackage\Console\Commands\SetupCommand',
            ]
        );
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.quizzes-package');
    }
}
