<?php

namespace InetStudio\QuizzesPackage\Tags\Services\Back\DataTables;

use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use InetStudio\QuizzesPackage\Tags\Contracts\Models\TagModelContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\DataTables\IndexServiceContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Resource\Index\ItemResourceContract;

class IndexService extends DataTable implements IndexServiceContract
{
    protected TagModelContract $model;

    protected ItemResourceContract $resource;

    public function __construct(TagModelContract $model)
    {
        $this->model = $model;
        $this->resource = resolve(
            ItemResourceContract::class,
            [
                'resource' => null,
            ]
        );
    }

    public function ajax(): JsonResponse
    {
        return DataTables::of($this->query())
            ->filterColumn('parent_name', function($query, $keyword) {
                $sql = "LOWER(`parent`.`name`) like ?";

                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->setTransformer(function ($item) {
                return $this->resource::make($item)->resolve();
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function query()
    {
        return $this->model
            ->select([$this->model->getTable().'.*', 'parent.name as parent_name'])
            ->leftJoin($this->model->getTable().' as parent', function ($join) {
                $join->on('parent.id', '=', $this->model->getTable().'.parent_id');
            });
    }

    public function html(): Builder
    {
        /** @var Builder $table */
        $table = app('datatables.html');

        return $table
            ->columns($this->getColumns())
            ->ajax($this->getAjaxOptions())
            ->parameters($this->getParameters());
    }

    protected function getColumns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => 'Название'],
            ['data' => 'parent', 'name' => 'parent_name', 'title' => 'Родительский тег'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Дата создания', 'searchable' => false],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Дата обновления', 'searchable' => false],
            [
                'data' => 'actions',
                'name' => 'actions',
                'title' => 'Действия',
                'orderable' => false,
                'searchable' => false,
            ],
        ];
    }

    protected function getAjaxOptions(): array
    {
        return [
            'url' => route('back.quizzes-package.tags.data.index'),
            'type' => 'POST',
        ];
    }

    protected function getParameters(): array
    {
        $translation = trans('admin::datatables');

        return [
            'order' => [2, 'desc',],
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $translation,
        ];
    }
}
