<?php

namespace InetStudio\Quizzes\Services\Back\Quizzes;

use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use InetStudio\Quizzes\Contracts\Repositories\QuizzesRepositoryContract;
use InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesDataTableServiceContract;

/**
 * Class QuizzesDataTableService.
 */
class QuizzesDataTableService extends DataTable implements QuizzesDataTableServiceContract
{
    /**
     * @var QuizzesRepositoryContract
     */
    private $repository;

    /**
     * QuizzesDataTableService constructor.
     *
     * @param QuizzesRepositoryContract $repository
     */
    public function __construct(QuizzesRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Запрос на получение данных таблицы.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function ajax()
    {
        $transformer = app()->make('InetStudio\Quizzes\Contracts\Transformers\Back\QuizTransformerContract');

        return DataTables::of($this->query())
            ->setTransformer($transformer)
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = $this->repository->getAllItems(true);

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): Builder
    {
        $table = app('datatables.html');

        return $table
            ->columns($this->getColumns())
            ->ajax($this->getAjaxOptions())
            ->parameters($this->getParameters());
    }

    /**
     * Получаем колонки.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'title', 'name' => 'title', 'title' => 'Название'],
            ['data' => 'type', 'name' => 'quiz_type', 'title' => 'Тип'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Дата создания'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Дата обновления'],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Действия', 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Свойства ajax datatables.
     *
     * @return array
     */
    protected function getAjaxOptions(): array
    {
        return [
            'url' => route('back.quizzes.data.index'),
            'type' => 'POST',
        ];
    }

    /**
     * Свойства datatables.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $i18n = trans('admin::datatables');

        return [
            'order' => [
                2,
                'desc'
            ],
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $i18n,
        ];
    }
}
