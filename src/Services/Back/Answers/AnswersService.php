<?php

namespace InetStudio\Quizzes\Services\Back\Answers;

use InetStudio\Quizzes\Contracts\Models\AnswerModelContract;
use InetStudio\Quizzes\Contracts\Repositories\AnswersRepositoryContract;
use InetStudio\Quizzes\Contracts\Http\Requests\Back\SaveQuizRequestContract;
use InetStudio\Quizzes\Contracts\Services\Back\Answers\AnswersServiceContract;

/**
 * Class AnswersService.
 */
class AnswersService implements AnswersServiceContract
{
    /**
     * @var AnswersRepositoryContract
     */
    private $repository;

    /**
     * AnswersService constructor.
     *
     * @param AnswersRepositoryContract $repository
     */
    public function __construct(AnswersRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получаем объект модели.
     *
     * @param int $id
     *
     * @return AnswerModelContract
     */
    public function getAnswerObject(int $id = 0): AnswerModelContract
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
    public function getAnswersByIDs($ids, bool $returnBuilder = false)
    {
        return $this->repository->getItemsByIDs($ids, $returnBuilder);
    }

    /**
     * Сохраняем объекты.
     *
     * @param SaveQuizRequestContract $request
     * @param array $questions
     * @param array $results
     *
     * @return array
     */
    public function save(SaveQuizRequestContract $request, array $questions, array $results): array
    {
        $ids = $request->input('answer.keys');

        $ids = is_array($ids) ? $ids : [];

        $questionsIDs = collect($questions)->pluck('id')->toArray();

        $this->repository->getItemsByQuestionsIDs($questionsIDs, true)->whereNotIn('id', $ids)->get()->each(function (AnswerModelContract $answer) {
            $this->repository->destroy($answer->id);
        });

        $answers = [];

        foreach ($ids as $id) {
            $questionID = trim(strip_tags($request->input('answer.question_id.'.$id)));
            $question = isset($questions[$questionID]) ? $questions[$questionID] : null;

            if (! $question) {
                continue;
            }

            $item = $this->repository->save($request, $question, $id);

            $images = [];
            if (config('quizzes.images.conversions.answer')) {
                foreach (config('quizzes.images.conversions.answer') as $image => $data) {
                    $images['answer.'.$image.'.'.$id] = $image;
                }
            }

            app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract')
                ->attachToObject($request, $item, $images, 'quizzes', 'answer');

            if ($request->filled('answer.association.'.$id)) {
                $assocResults = [];

                collect($request->input('answer.association.'.$id))->each(function ($item, $key) use ($results, &$assocResults) {
                    $assocResults[$results[$key]->id] = ['association' => $item];
                });

                $item->results()->sync($assocResults);
            }

            $answers[$id] = $item;
        }

        return $answers;
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
