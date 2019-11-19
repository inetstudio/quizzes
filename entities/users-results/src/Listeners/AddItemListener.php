<?php

namespace InetStudio\QuizzesPackage\UsersResults\Listeners;

use Exception;
use Ramsey\Uuid\Uuid;
use InetStudio\QuizzesPackage\UsersResults\Contracts\Listeners\AddItemListenerContract;
use InetStudio\QuizzesPackage\UsersResults\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class AddItemListener.
 */
class AddItemListener implements AddItemListenerContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $itemsService;

    /**
     * AddItemListener constructor.
     *
     * @param  ItemsServiceContract  $itemsService
     */
    public function __construct(ItemsServiceContract $itemsService)
    {
        $this->itemsService = $itemsService;
    }

    /**
     * Handle the event.
     *
     * @param $event
     *
     * @throws Exception
     */
    public function handle($event): void
    {
        $quiz = $event->quiz;
        $result = $event->result;
        $points = $event->points;

        $hash = Uuid::uuid4()->toString();

        $data = [
            'hash' => $hash,
            'quiz_id' => $quiz->id,
            'result_id' => $result->id,
            'points' => $points,
        ];

        session(['quiz_hash' => $hash]);

        $this->itemsService->save($data, 0);
    }
}
