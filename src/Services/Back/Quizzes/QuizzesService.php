<?php

namespace InetStudio\Quizzes\Services\Back\Quizzes;

use League\Fractal\Manager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\AdminPanel\Serializers\SimpleDataArraySerializer;
use InetStudio\Quizzes\Contracts\Repositories\QuizzesRepositoryContract;
use InetStudio\Quizzes\Contracts\Http\Requests\Back\SaveQuizRequestContract;
use InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesServiceContract;

/**
 * Class QuizzesService.
 */
class QuizzesService implements QuizzesServiceContract
{
    /**
     * @var QuizzesRepositoryContract
     */
    private $repository;

    /**
     * QuizzesService constructor.
     *
     * @param QuizzesRepositoryContract $repository
     */
    public function __construct(QuizzesRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получаем объект модели.
     *
     * @param int $id
     *
     * @return QuizModelContract
     */
    public function getQuizObject(int $id = 0): QuizModelContract
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
    public function getQuizzesByIDs($ids, bool $returnBuilder = false)
    {
        return $this->repository->getItemsByIDs($ids, $returnBuilder);
    }

    /**
     * Сохраняем модель.
     *
     * @param SaveQuizRequestContract $request
     * @param int $id
     *
     * @return QuizModelContract
     */
    public function save(SaveQuizRequestContract $request, int $id): QuizModelContract
    {
        Log::info('Save quiz: '.json_encode($request->all()));

        $action = ($id) ? 'отредактирован' : 'создан';
        $item = $this->repository->save($request, $id);

        $images = collect(config('quizzes.images.conversions.quiz'))->map(function ($item, $key) {
            return $key;
        })->toArray();

        app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract')
            ->attachToObject($request, $item, $images, 'quizzes', 'quiz');

        $results = app()->make('InetStudio\Quizzes\Contracts\Services\Back\Results\ResultsServiceContract')
            ->save($request, $item);

        $questions = app()->make('InetStudio\Quizzes\Contracts\Services\Back\Questions\QuestionsServiceContract')
            ->save($request, $item);

        app()->make('InetStudio\Quizzes\Contracts\Services\Back\Answers\AnswersServiceContract')
            ->save($request, $questions, $results);

        event(app()->makeWith('InetStudio\Quizzes\Contracts\Events\Back\ModifyQuizEventContract', [
            'object' => $item,
        ]));

        Session::flash('success', 'Тест «'.$item->title.'» успешно '.$action);

        return $item;
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

    /**
     * Получаем подсказки.
     *
     * @param string $search
     * @param $type
     *
     * @return array
     */
    public function getSuggestions(string $search, $type): array
    {
        $items = $this->repository->searchItems([['title', 'LIKE', '%'.$search.'%']]);

        $resource = (app()->makeWith('InetStudio\Quizzes\Contracts\Transformers\Back\SuggestionTransformerContract', [
            'type' => $type,
        ]))->transformCollection($items);

        $manager = new Manager();
        $manager->setSerializer(new SimpleDataArraySerializer());

        $transformation = $manager->createData($resource)->toArray();

        $data = [];

        if ($type && $type == 'autocomplete') {
            $data['suggestions'] = $transformation;
        } else {
            $data['items'] = $transformation;
        }

        return $data;
    }
}
