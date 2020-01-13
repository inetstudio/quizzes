<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\QuizzesPackage\Results\Contracts\Http\Controllers\Front',
        'middleware' => ['web'],
    ],
    function () {
        Route::post('quizzes/result/send', 'ItemsControllerContract@sendResultToEmail')
            ->name('front.quizzes.result.send');
    }
);
