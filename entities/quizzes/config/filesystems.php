<?php

return [

    /*
     * Расширение файла конфигурации app/config/filesystems.php
     * добавляет локальные диски для хранения изображений тестов
     */

    'quizzes' => [
        'driver' => 'local',
        'root' => storage_path('app/public/quizzes'),
        'url' => env('APP_URL').'/storage/quizzes',
        'visibility' => 'public',
    ],

];
