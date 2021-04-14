<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\QuizzesPackage\Tags\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/quizzes-package',
    ],
    function () {
        Route::any('tags/data', 'DataControllerContract@getIndexData')
            ->name('back.quizzes-package.tags.data.index');

        Route::post('tags/suggestions', 'UtilityControllerContract@getSuggestions')
            ->name('back.quizzes-package.tags.getSuggestions');

        Route::post('tags/suggestions-children', 'UtilityControllerContract@getSuggestionsChildren')
            ->name('back.quizzes-package.tags.getSuggestionsChildren');

        Route::resource(
            'tags',
            'ResourceControllerContract',
            [
                'as' => 'back.quizzes-package',
            ]
        );
    }
);
