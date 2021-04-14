<?php

namespace InetStudio\QuizzesPackage\UsersResults\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

class SetupCommand extends BaseSetupCommand
{
    protected $name = 'inetstudio:quizzes-package:users-results:setup';

    protected $description = 'Setup quizzes useres results package';

    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Publish migrations',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\QuizzesPackage\UsersResults\Providers\ServiceProvider',
                    '--tag' => 'migrations',
                ],
            ],
            [
                'type' => 'artisan',
                'description' => 'Migration',
                'command' => 'migrate',
            ],
        ];
    }
}
