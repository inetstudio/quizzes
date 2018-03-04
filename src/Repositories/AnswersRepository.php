<?php

namespace InetStudio\Quizzes\Repositories;

use Illuminate\Database\Eloquent\Builder;
use InetStudio\Quizzes\Contracts\Models\AnswerModelContract;
use InetStudio\Quizzes\Contracts\Models\QuestionModelContract;
use InetStudio\Quizzes\Contracts\Repositories\AnswersRepositoryContract;
use InetStudio\Quizzes\Contracts\Http\Requests\Back\SaveQuizRequestContract;

/**
 * Class AnswersRepository.
 */
class AnswersRepository implements AnswersRepositoryContract
{
    /**
     * @var AnswerModelContract
     */
    private $model;

    /**
     * AnswersRepository constructor.
     *
     * @param AnswerModelContract $model
     */
    public function __construct(AnswerModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращаем объект по id, либо создаем новый.
     *
     * @param $id
     *
     * @return AnswerModelContract
     */
    public function getItemByID($id): AnswerModelContract
    {
        if (! (! is_null($id) && $id > 0 && $item = $this->model::find($id))) {
            $item = $this->model;
        }

        return $item;
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
     * @param $questionIDs
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getItemsByQuestionsIDs($questionIDs, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery()->whereIn('quiz_question_id', (array) $questionIDs);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Сохраняем объект.
     *
     * @param SaveQuizRequestContract $request
     * @param QuestionModelContract $quizQuestion
     * @param $id
     *
     * @return AnswerModelContract
     */
    public function save(SaveQuizRequestContract $request, QuestionModelContract $quizQuestion, $id): AnswerModelContract
    {
        $item = $this->getItemByID($id);

        $item->quiz_question_id = $quizQuestion->id;
        $item->title = trim(strip_tags($request->input('answer.title.'.$id)));
        $item->description = $request->input('answer.description.'.$id.'.text');
        $item->points = (int) trim(strip_tags($request->input('answer.points.'.$id)));
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
        $defaultColumns = ['id', 'quiz_question_id', 'title'];

        $relations = [
            'media' => function ($query) {
                $query->select(['id', 'model_id', 'model_type', 'collection_name', 'file_name', 'disk']);
            },
        ];

        return $this->model::select(array_merge($defaultColumns, $extColumns))
            ->with(array_intersect_key($relations, array_flip($with)));
    }
}
