<?php

namespace InetStudio\Quizzes\Services\Front;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Arr;
use League\Fractal\Manager;
use Illuminate\Support\Facades\Mail;
use League\Fractal\Resource\Item as FractalItem;
use InetStudio\AdminPanel\Serializers\SimpleDataArraySerializer;
use InetStudio\Quizzes\Contracts\Services\Front\QuizzesServiceContract;

/**
 * Class QuizzesService.
 */
class QuizzesService implements QuizzesServiceContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    public $services = [];

    public $quizzesRepository;

    public $resultsRepository;

    public $dataManager;

    /**
     * QuizzesService constructor.
     */
    public function __construct()
    {
        $this->quizzesRepository = app()->make('InetStudio\Quizzes\Contracts\Repositories\QuizzesRepositoryContract');
        $this->resultsRepository = app()->make('InetStudio\Quizzes\Contracts\Repositories\ResultsRepositoryContract');

        $this->services['usersResults'] = app()->make('InetStudio\Quizzes\Contracts\Services\Front\UsersResultsServiceContract');
        $this->services['images'] = app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract');

        $this->dataManager = new Manager();
        $this->dataManager->setSerializer(new SimpleDataArraySerializer());
    }

    /**
     * Получаем информацию по тесту.
     *
     * @param int $id
     *
     * @return array
     */
    public function getQuizData(int $id = 0): array
    {
        $quiz = $this->quizzesRepository->getItemByID($id);

        $resource = new FractalItem($quiz, app()->make('InetStudio\Quizzes\Transformers\Front\QuizTransformer'));

        $data = $this->dataManager->createData($resource)->toArray();

        return [
            'success' => true,
            'quiz' => $data,
        ];
    }

    /**
     * Получаем информацию по результату.
     *
     * @param int $id
     *
     * @return array
     */
    public function getResultData(int $id = 0): array
    {
        $result = $this->resultsRepository->getItemByID($id);

        $resource = new FractalItem($result, app()->make('InetStudio\Quizzes\Transformers\Front\ResultTransformer'));

        $data = $this->dataManager->createData($resource)->toArray();

        return [
            'success' => true,
            'result' => $data,
        ];
    }

    /**
     * Получаем результат теста на основе ответов пользователя.
     *
     * @param int $id
     * @param $userAnswers
     *
     * @return array|string
     *
     * @throws \Throwable
     */
    public function getQuizResult(int $id, $userAnswers)
    {
        $quiz = $this->quizzesRepository->getItemByID($id);

        $userResult = null;

        switch ($quiz->quiz_type) {
            case 'trivia':
                $userResult = $this->getTriviaResult($quiz, $userAnswers);
                break;

            case 'personal':
                $userResult = $this->getPersonalResult($quiz, $userAnswers);
                break;
        }

        if (! $userResult['result']) {
            return [
                'success' => false,
                'error' => 'Не удалось определить результат',
            ];
        }

        $resource = new FractalItem($userResult['result'], app()->make('InetStudio\Quizzes\Transformers\Front\ResultTransformer'));

        $data = $this->dataManager->createData($resource)->toArray();

        $hash = Uuid::uuid4()->toString();
        $this->services['usersResults']->save([
            'hash' => $hash,
            'quiz_id' => $quiz->id,
            'result_id' => $userResult['result']->id,
            'points' => $userResult['points'],
        ], 0);
        session(['quiz_hash' => $hash]);

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
        foreach ($quiz->questions as $question) {
            foreach ($question->answers as $answer) {
                $quizAnswers[$question->id][$answer->id] = (int) $answer->points;
            }
        }

        $points = 0;
        foreach ($userAnswers as $answer) {
            if (isset($quizAnswers[(int) $answer['questionId']][(int) $answer['answerId']])) {
                $points += $quizAnswers[(int) $answer['questionId']][(int) $answer['answerId']];
            }
        }

        $userResult = $quiz->results->filter(function ($item) use ($points) {
            return $item->min_points <= $points and $item->max_points >= $points;
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

        foreach ($quiz->questions as $question) {
            foreach ($question->answers as $answer) {
                foreach ($answer->results as $result) {
                    $quizAnswers[$question->id][$answer->id][$result->id] = (int) $result->pivot->association;
                }
            }
        }

        $resultsPoints = [];
        foreach ($userAnswers as $answer) {
            if (isset($quizAnswers[(int) $answer['questionId']][(int) $answer['answerId']])) {
                $resultsPoints = Arr::arraySumIdenticalKeys($resultsPoints, $quizAnswers[(int) $answer['questionId']][(int) $answer['answerId']]);
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

    /**
     * Отправляем результат теста на почту.
     *
     * @param int $quizId
     * @param int $resultId
     * @param string $url
     * @param string $email
     *
     * @return array
     */
    public function sendResultToEmail(int $quizId, int $resultId, string $url, string $email): array
    {
        $quizObject = $this->quizzesRepository->getItemByID($quizId);
        $resultObject = $this->resultsRepository->getItemByID($resultId);

        $img = $this->services['images']->getFirstCropImageUrl($resultObject, 'preview');

        $data = [
            'quiz' => $quizObject,
            'result' => $resultObject,
            'url' => $url,
            'img' => $img,
        ];

        $quizObject->notify(app()->makeWith('InetStudio\Quizzes\Contracts\Notifications\Front\QuizResultNotificationContract', [
            'email' => $email,
            'data' => $data,
        ]));

        $hash = session('quiz_hash');
        $this->services['usersResults']->update([
            'email' => $email,
        ], [['hash', '=', $hash]]);

        return [
            'message' => 'Результат теста отправлен на указанный email',
            'success' => true,
        ];
    }
}
