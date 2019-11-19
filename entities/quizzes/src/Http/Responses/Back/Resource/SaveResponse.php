<?php

namespace InetStudio\QuizzesPackage\Quizzes\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $resourceService;

    /**
     * SaveResponse constructor.
     *
     * @param  ItemsServiceContract  $resourceService
     */
    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $id = $request->route('quiz', 0);
        $data = $request->all();

        $item = $this->resourceService->save($data, $id);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'id' => $item['id'],
            ], 200);
        } else {
            return response()->redirectToRoute(
                'back.quizzes-package.quizzes.edit',
                [
                    $item['id'],
                ]
            );
        }
    }
}
