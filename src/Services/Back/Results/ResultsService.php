<?php

namespace InetStudio\Quizzes\Services\Back\Results;

use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\Quizzes\Contracts\Models\ResultModelContract;
use InetStudio\Quizzes\Contracts\Repositories\ResultsRepositoryContract;
use InetStudio\Quizzes\Contracts\Http\Requests\Back\SaveQuizRequestContract;
use InetStudio\Quizzes\Contracts\Services\Back\Results\ResultsServiceContract;

/**
 * Class ResultsService.
 */
class ResultsService implements ResultsServiceContract
{
    /**
     * @var ResultsRepositoryContract
     */
    private $repository;

    /**
     * ResultsService constructor.
     *
     * @param ResultsRepositoryContract $repository
     */
    public function __construct(ResultsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получаем объект модели.
     *
     * @param int $id
     *
     * @return ResultModelContract
     */
    public function getResultObject(int $id = 0): ResultModelContract
    {
        return $this->repository->getItemByID($id);
    }

    /**
     * Получаем объекты по списку id.
     *
     * @param array|int $ids
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getResultsByIDs($ids, bool $returnBuilder = false)
    {
        return $this->repository->getItemsByIDs($ids, $returnBuilder);
    }

    /**
     * Сохраняем объекты.
     *
     * @param SaveQuizRequestContract $request
     * @param QuizModelContract $quiz
     *
     * @return array
     */
    public function save(SaveQuizRequestContract $request, QuizModelContract $quiz): array
    {
        $ids = $request->input('result.keys');

        $ids = is_array($ids) ? $ids : [];

        $this->repository->getItemsByQuiz($quiz->getAttribute('id'), true)->whereNotIn('id', $ids)->get()->each(function (ResultModelContract $result) {
            $this->repository->destroy($result->getAttribute('id'));
        });

        $results = [];

        foreach ($ids as $id) {
            $item = $this->repository->save($request, $quiz, $id);

            $images = [];
            if (config('quizzes.images.conversions.result')) {
                foreach (config('quizzes.images.conversions.result') as $image => $data) {
                    $images['result.'.$image.'.'.$id] = $image;
                }
            }

            app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract')
                ->attachToObject($request, $item, $images, 'quizzes', 'result');

            $results[$id] = $item;
        }

        return $results;
    }

    /**
     * Удаляем объект.
     *
     * @param $id
     *
     * @return bool
     */
    public function destroy(int $id): ?bool
    {
        return $this->repository->destroy($id);
    }
}
