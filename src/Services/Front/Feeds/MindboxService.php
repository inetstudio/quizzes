<?php

namespace InetStudio\Quizzes\Services\Front\Feeds;

use League\Fractal\Manager;
use InetStudio\Quizzes\Contracts\Services\Front\Feeds\MindboxServiceContract;

/**
 * Class MindboxService.
 */
class MindboxService implements MindboxServiceContract
{
    /**
     * @var
     */
    public $repository;

    /**
     * MindboxService constructor.
     */
    public function __construct()
    {
        $this->repository = app()->make('InetStudio\Quizzes\Contracts\Repositories\QuizzesRepositoryContract');
    }

    /**
     * Получаем информацию по тестам для фида mindbox.
     *
     * @return mixed
     */
    public function getItems()
    {
        $items = $this->repository->getAllItems();

        $resource = app()->make('InetStudio\Quizzes\Contracts\Transformers\Front\Feeds\Mindbox\QuizTransformerContract')
            ->transformCollection($items);

        $manager = new Manager();
        $serializer = app()->make('InetStudio\AdminPanel\Contracts\Serializers\SimpleDataArraySerializerContract');
        $manager->setSerializer($serializer);

        $transformation = $manager->createData($resource)->toArray();

        return $transformation;
    }
}
