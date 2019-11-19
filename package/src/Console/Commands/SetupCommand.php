<?php

namespace InetStudio\QuizzesPackage\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

/**
 * Class SetupCommand.
 */
class SetupCommand extends BaseSetupCommand
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:quizzes-package:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup quizzes package';

    /**
     * Инициализация команд.
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Quizzes setup',
                'command' => 'inetstudio:quizzes-package:quizzes:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Quizzes questions setup',
                'command' => 'inetstudio:quizzes-package:questions:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Quizzes answers setup',
                'command' => 'inetstudio:quizzes-package:answers:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Quizzes results setup',
                'command' => 'inetstudio:quizzes-package:results:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Quizzes users results setup',
                'command' => 'inetstudio:quizzes-package:users-results:setup',
            ],            
        ];
    }
}
