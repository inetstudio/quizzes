<?php

namespace InetStudio\QuizzesPackage\Quizzes\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Загрузка сервиса.
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
    }

    /**
     * Регистрация команд.
     */
    protected function registerConsoleCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            'InetStudio\QuizzesPackage\Quizzes\Console\Commands\SetupCommand',
            'InetStudio\QuizzesPackage\Quizzes\Console\Commands\CreateFoldersCommand',
        ]);
    }

    /**
     * Регистрация ресурсов.
     */
    protected function registerPublishes(): void
    {
        $this->publishes([
            __DIR__.'/../../config/quizzes.php' => config_path('quizzes.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../../config/filesystems.php', 'filesystems.disks'
        );

        if (! $this->app->runningInConsole()) {
            return;
        }

        if (Schema::hasTable('quizzes')) {
            return;
        }

        $timestamp = date('Y_m_d_His', time());
        $this->publishes(
            [
                __DIR__.'/../../database/migrations/create_quizzes_tables.php.stub' => database_path(
                    'migrations/'.$timestamp.'_create_quizzes_tables.php'
                ),
            ], 'migrations'
        );
    }

    /**
     * Регистрация путей.
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Регистрация представлений.
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.quizzes-package.quizzes');
    }
}
