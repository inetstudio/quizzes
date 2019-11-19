<?php

namespace InetStudio\QuizzesPackage\Results\Http\Responses\Front;

use Illuminate\Http\Request;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Results\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\QuizzesPackage\Results\Contracts\Http\Responses\Front\SendResultToEmailResponseContract;

/**
 * Class SendResultToEmailResponse.
 */
class SendResultToEmailResponse implements SendResultToEmailResponseContract
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
     * Возвращаем ответ при отправке результата на почту.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws BindingResolutionException
     */
    public function toResponse($request)
    {
        $resultId = $request->get('result_id');
        $url = $request->get('current_url');
        $email = $request->get('email');

        if ($request->has('subscribe-agree')) {
            $subscriptionService = app()->make('InetStudio\Subscription\Contracts\Services\Front\SubscriptionServiceContract');
            $subscriptionService->subscribeByRequest($request);
        }

        $data = $this->itemsService->sendResultToEmail($resultId, $url, $email);

        return response()->json($data);
    }
}
