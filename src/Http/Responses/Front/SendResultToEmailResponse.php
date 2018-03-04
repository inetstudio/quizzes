<?php

namespace InetStudio\Quizzes\Http\Responses\Front;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Quizzes\Contracts\Http\Responses\Front\SendResultToEmailResponseContract;

/**
 * Class SendResultToEmailResponse.
 */
class SendResultToEmailResponse implements SendResultToEmailResponseContract, Responsable
{
    /**
     * @var array
     */
    private $data;

    /**
     * SendResultToEmailResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем slug по заголовку объекта.
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
