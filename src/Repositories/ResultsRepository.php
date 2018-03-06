<?php

namespace InetStudio\Quizzes\Repositories;

use Illuminate\Database\Eloquent\Builder;
use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\Quizzes\Contracts\Models\ResultModelContract;
use InetStudio\Quizzes\Contracts\Repositories\ResultsRepositoryContract;
use InetStudio\Quizzes\Contracts\Http\Requests\Back\SaveQuizRequestContract;

/**
 * Class ResultsRepository.
 */
class ResultsRepository implements ResultsRepositoryContract
{
    /**
     * @var ResultModelContract
     */
    private $model;

    /**
     * ResultsRepository constructor.
     *
     * @param ResultModelContract $model
     */
    public function __construct(ResultModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращаем объект по id, либо создаем новый.
     *
     * @param $id
     *
     * @return ResultModelContract
     */
    public function getItemByID($id): ResultModelContract
    {
        if (! (! is_null($id) && $id > 0 && $item = $this->model::find($id))) {
            $this->model = $item;
        }

        return $this->model;
    }

    /**
     * Возвращаем объекты по списку id.
     *
     * @param $ids
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getItemsByIDs($ids, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery()->whereIn('id', (array) $ids);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Возвращаем объекты, принадлежащие тесту.
     *
     * @param int $quizID
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getItemsByQuiz(int $quizID, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery()->where('quiz_id', $quizID);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Сохраняем объект.
     *
     * @param SaveQuizRequestContract $request
     * @param QuizModelContract $quiz
     * @param $id
     *
     * @return ResultModelContract
     */
    public function save(SaveQuizRequestContract $request, QuizModelContract $quiz, $id): ResultModelContract
    {
        $item = $this->getItemByID($id);

        $item->setAttribute('quiz_id', $quiz->getAttribute('id'));
        $item->setAttribute('title', trim(strip_tags($request->input('result.title.'.$id))));
        $item->setAttribute('min_points', (int) trim(strip_tags($request->input('result.min_points.'.$id))));
        $item->setAttribute('max_points', (int) trim(strip_tags($request->input('result.max_points.'.$id))));
        $item->setAttribute('short_description', $request->input('result.short_description.'.$id.'.text'));
        $item->setAttribute('full_description', $request->input('result.full_description.'.$id.'.text'));

        $item->save();

        return $item;
    }

    /**
     * Удаляем объект.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy($id): ?bool
    {
        return $this->getItemByID($id)->delete();
    }

    /**
     * Ищем объекты.
     *
     * @param string $field
     * @param $value
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function searchItemsByField(string $field, string $value, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery()->where($field, 'LIKE', '%'.$value.'%');

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Получаем все объекты.
     *
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getAllItems(bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery(['created_at', 'updated_at']);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Возвращаем запрос на получение объектов.
     *
     * @param array $extColumns
     * @param array $with
     *
     * @return Builder
     */
    protected function getItemsQuery($extColumns = [], $with = []): Builder
    {
        $defaultColumns = ['id', 'quiz_id', 'title'];

        $relations = [
            'media' => function ($query) {
                $query->select(['id', 'model_id', 'model_type', 'collection_name', 'file_name', 'disk']);
            },
        ];

        return $this->model::select(array_merge($defaultColumns, $extColumns))
            ->with(array_intersect_key($relations, array_flip($with)));
    }
}
