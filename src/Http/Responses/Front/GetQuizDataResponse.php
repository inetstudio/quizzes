<?php

namespace InetStudio\Quizzes\Http\Responses\Front;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Quizzes\Contracts\Http\Responses\Front\GetQuizDataResponseContract;

/**
 * Class GetQuizDataResponse.
 */
class GetQuizDataResponse implements GetQuizDataResponseContract, Responsable
{
    /**
     * @var array
     */
    private $data;

    /**
     * GetQuizDataResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при запросе теста.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json($this->data);
    }
}
