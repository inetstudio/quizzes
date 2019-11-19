<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/quizzes-package',
    ],
    function () {
        Route::any('quizzes/data/index', 'DataControllerContract@getIndexData')
            ->name('back.quizzes-package.quizzes.data.index');

        Route::post('quizzes/suggestions', 'UtilityControllerContract@getSuggestions')
            ->name('back.quizzes-package.quizzes.utility.suggestions');

        Route::get('quizzes/create/{type}', 'ResourceControllerContract@create')
            ->name('back.quizzes-package.quizzes.create');
        Route::resource(
            'quizzes',
            'ResourceControllerContract',
            [
                'except' => [
                    'create',
                ],
                'as' => 'back.quizzes-package',
            ]
        );
    }
);

Route::group(
    [
        'namespace' => 'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Controllers\Front',
        'middleware' => ['web'],
    ],
    function () {
        Route::any('quizzes/get', 'ItemsControllerContract@getData')
            ->name('front.quizzes.get');

        Route::post('quizzes/result', 'ItemsControllerContract@getResult')
            ->name('front.quizzes.result');
    }
);
