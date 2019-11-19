<?php

namespace InetStudio\QuizzesPackage\Quizzes\Services\Front;

use Illuminate\Support\Arr;
use League\Fractal\Manager;
use League\Fractal\Resource\Item as FractalItem;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\AdminPanel\Base\Contracts\Serializers\SimpleDataArraySerializerContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * @var Manager
     */
    protected $dataManager;

    /**
     * ItemsService constructor.
     *
     * @param  QuizModelContract  $model
     * @param  SimpleDataArraySerializerContract  $serializer
     */
    public function __construct(QuizModelContract $model, SimpleDataArraySerializerContract $serializer)
    {
        parent::__construct($model);

        $this->dataManager = new Manager();
        $this->dataManager->setSerializer($serializer);
    }

    /**
     * Получаем информацию по тесту.
     *
     * @param  int  $id
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function getItemData(int $id = 0): array
    {
        $item = $this->getItemById($id);

        $resource = new FractalItem(
            $item,
            app()->make('InetStudio\QuizzesPackage\Quizzes\Transformers\Front\ItemTransformer')
        );
        $data = $this->dataManager->createData($resource)->toArray();

        return [
            'success' => true,
            'quiz' => $data,
        ];
    }

    /**
     * Получаем результат теста на основе ответов пользователя.
     *
     * @param  int  $id
     * @param $userAnswers
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function getItemResult(int $id, $userAnswers)
    {
        $quiz = $this->getItemById($id);

        $userResult = null;

        switch ($quiz->quiz_type) {
            case 'trivia':
                $userResult = $this->getTriviaResult($quiz, $userAnswers);
                break;

            case 'personal':
                $userResult = $this->getPersonalResult($quiz, $userAnswers);
                break;

            default:
                $userResult['result'] = null;
        }

        if (! $userResult['result']) {
            return [
                'success' => false,
                'error' => 'Не удалось определить результат',
            ];
        }

        $resource = new FractalItem(
            $userResult['result'],
            app()->make('InetStudio\QuizzesPackage\Results\Transformers\Front\ItemTransformer')
        );
        $data = $this->dataManager->createData($resource)->toArray();

        event(
            app()->make(
                'InetStudio\QuizzesPackage\Quizzes\Contracts\Events\Front\ItemPassedEventContract',
                [
                    'quiz' => $quiz,
                    'result' => $userResult['result'],
                    'points' => $userResult['points'],
                ]
            )
        );

        return [
            'success' => true,
            'result' => $data,
        ];
    }

    /**
     * Получаем результат теста "Trivia" на основе ответов пользователя.
     *
     * @param $quiz
     * @param $userAnswers
     *
     * @return null
     */
    protected function getTriviaResult($quiz, $userAnswers)
    {
        $userResult = null;

        $quizAnswers = [];
        foreach ($quiz['questions'] as $question) {
            foreach ($question['answers'] as $answer) {
                $quizAnswers[$question['id']][$answer['id']] = (int) $answer['points'];
            }
        }

        $points = 0;
        foreach ($userAnswers as $answer) {
            if (isset($quizAnswers[(int) $answer['questionId']][(int) $answer['answerId']])) {
                $points += $quizAnswers[(int) $answer['questionId']][(int) $answer['answerId']];
            }
        }

        $userResult = $quiz->results->filter(function ($item) use ($points) {
            return $item->min_points <= $points && $item->max_points >= $points;
        })->first();

        if (! $userResult) {
            $userResult = $quiz->results->sortByDesc('max_points')->first();
        }

        return [
            'result' => $userResult,
            'points' => $points,
        ];
    }

    /**
     * Получаем результат теста "Personal" на основе ответов пользователя.
     *
     * @param $quiz
     * @param $userAnswers
     *
     * @return mixed
     */
    protected function getPersonalResult($quiz, $userAnswers)
    {
        $quizAnswers = [];

        foreach ($quiz['questions'] as $question) {
            foreach ($question['answers'] as $answer) {
                foreach ($answer['results'] as $result) {
                    $quizAnswers[$question['id']][$answer['id']][$result['id']] = (int) $result->pivot->association;
                }
            }
        }

        $resultsPoints = [];
        foreach ($userAnswers as $answer) {
            if (isset($quizAnswers[(int) $answer['questionId']][(int) $answer['answerId']])) {
                $resultsPoints = Arr::arraySumIdenticalKeys($resultsPoints,
                    $quizAnswers[(int) $answer['questionId']][(int) $answer['answerId']]);
            }
        }

        arsort($resultsPoints);
        reset($resultsPoints);

        $resultId = key($resultsPoints);
        $points = $resultsPoints[$resultId];

        return [
            'result' => $quiz->results->where('id', (int) $resultId)->first(),
            'points' => $points,
        ];
    }
}
