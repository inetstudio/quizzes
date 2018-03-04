<?php

Route::group([
    'namespace' => 'InetStudio\Quizzes\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::any('quizzes/data', 'QuizzesDataControllerContract@data')->name('back.quizzes.data.index');
    Route::post('quizzes/suggestions', 'QuizzesUtilityControllerContract@getSuggestions')->name('back.quizzes.getSuggestions');

    Route::get('quizzes/create/{type}', 'QuizzesControllerContract@create')->name('back.quizzes.create');
    Route::resource('quizzes', 'QuizzesControllerContract', ['except' => [
        'show', 'create',
    ], 'as' => 'back']);
});

Route::group([
    'namespace' => 'InetStudio\Quizzes\Contracts\Http\Controllers\Front',
    'middleware' => ['web'],
], function () {
    Route::any('quizzes/get', 'QuizzesControllerContract@getQuizData')->name('front.quizzes.get');
    Route::post('quizzes/result/send', 'QuizzesControllerContract@sendResultToEmail')->name('front.quizzes.result.send');
    Route::post('quizzes/result', 'QuizzesControllerContract@getQuizResult')->name('front.quizzes.result');
});
