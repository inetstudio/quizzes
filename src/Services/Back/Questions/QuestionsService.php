<?php

namespace InetStudio\Quizzes\Services\Back\Questions;

use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\Quizzes\Contracts\Models\QuestionModelContract;
use InetStudio\Quizzes\Contracts\Repositories\QuestionsRepositoryContract;
use InetStudio\Quizzes\Contracts\Http\Requests\Back\SaveQuizRequestContract;
use InetStudio\Quizzes\Contracts\Services\Back\Questions\QuestionsServiceContract;

/**
 * Class QuestionsService.
 */
class QuestionsService implements QuestionsServiceContract
{
    /**
     * @var QuestionsRepositoryContract
     */
    private $repository;

    /**
     * QuestionsService constructor.
     *
     * @param QuestionsRepositoryContract $repository
     */
    public function __construct(QuestionsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получаем объект модели.
     *
     * @param int $id
     *
     * @return QuestionModelContract
     */
    public function getQuestionObject(int $id = 0): QuestionModelContract
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
    public function getQuestionsByIDs($ids, bool $returnBuilder = false)
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
    public function save(SaveQuizRequestContract $request, $quiz): array
    {
        $ids = $request->input('question.keys');

        $ids = is_array($ids) ? $ids : [];

        $this->repository->getItemsByQuiz($quiz->id, true)->whereNotIn('id', $ids)->get()->each(function (QuestionModelContract $question) {
            $this->repository->destroy($question->id);
        });

        $questions = [];

        foreach ($ids as $id) {
            $item = $this->repository->save($request, $quiz, $id);

            $images = [];
            if (config('quizzes.images.conversions.question')) {
                foreach (config('quizzes.images.conversions.question') as $image => $data) {
                    $images['question.'.$image.'.'.$id] = $image;
                }
            }

            app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract')
                ->attachToObject($request, $item, $images, 'quizzes', 'question');

            $questions[$id] = $item;
        }

        return $questions;
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
