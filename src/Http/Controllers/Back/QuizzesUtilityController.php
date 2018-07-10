<?php

namespace InetStudio\Quizzes\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\Quizzes\Contracts\Http\Controllers\Back\QuizzesUtilityControllerContract;
use InetStudio\Quizzes\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Class QuizzesUtilityController.
 */
class QuizzesUtilityController extends Controller implements QuizzesUtilityControllerContract
{
    /**
     * Возвращаем объекты для поля.
     *
     * @param Request $request
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(Request $request): SuggestionsResponseContract
    {
        $search = $request->get('q');
        $type = $request->get('type');

        $data = app()->make('InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesServiceContract')
            ->getSuggestions($search, $type);

        return app()->makeWith('InetStudio\Quizzes\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract', [
            'suggestions' => $data,
        ]);
    }
}
