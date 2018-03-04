<?php

namespace InetStudio\Quizzes\Http\Controllers\Back;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use InetStudio\Quizzes\Models\QuizModel;
use InetStudio\Quizzes\Contracts\Http\Controllers\Back\QuizzesUtilityControllerContract;

/**
 * Class QuizzesUtilityController.
 */
class QuizzesUtilityController extends Controller implements QuizzesUtilityControllerContract
{
    /**
     * Возвращаем тесты для поля.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuggestions(Request $request): JsonResponse
    {
        $search = $request->get('q');

        $items = QuizModel::select(['id', 'title'])->where('title', 'LIKE', '%'.$search.'%')->get();

        if ($request->filled('type') && $request->get('type') == 'autocomplete') {
            $type = get_class(new QuizModel());

            $data = $items->mapToGroups(function ($item) use ($type) {
                return [
                    'suggestions' => [
                        'value' => $item->title,
                        'data' => [
                            'id' => $item->id,
                            'type' => $type,
                            'title' => $item->title,
                            'preview' => ($item->getFirstMedia('preview')) ? url($item->getFirstMedia('preview')->getUrl('preview_sidebar')) : '',
                        ],
                    ],
                ];
            });
        } else {
            $data = $items->mapToGroups(function ($item) {
                return [
                    'items' => [
                        'id' => $item->id,
                        'name' => $item->title,
                    ],
                ];
            });
        }

        return response()->json($data);
    }
}
