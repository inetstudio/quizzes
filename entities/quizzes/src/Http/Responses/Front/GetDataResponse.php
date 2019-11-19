<?php

namespace InetStudio\QuizzesPackage\Quizzes\Http\Responses\Front;

use Illuminate\Http\Request;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Front\GetDataResponseContract;

/**
 * Class GetDataResponse.
 */
class GetDataResponse implements GetDataResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $itemsService;

    /**
     * GetDataResponse constructor.
     *
     * @param  ItemsServiceContract  $itemsService
     */
    public function __construct(ItemsServiceContract $itemsService)
    {
        $this->itemsService = $itemsService;
    }

    /**
     * Возвращаем ответ при запросе теста.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $id = $request->get('id');

        $data = $this->itemsService->getItemData($id);

        return response()->json($data);
    }
}
