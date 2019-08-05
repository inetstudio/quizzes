<?php

namespace InetStudio\Quizzes\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\Quizzes\Contracts\Http\Requests\Back\SaveQuizRequestContract;
use InetStudio\Quizzes\Contracts\Http\Controllers\Back\QuizzesControllerContract;
use InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\FormResponseContract;
use InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\SaveResponseContract;
use InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\IndexResponseContract;
use InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\DestroyResponseContract;

/**
 * Class QuizzesController.
 */
class QuizzesController extends Controller implements QuizzesControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * QuizzesController constructor.
     */
    public function __construct()
    {
        $this->services['quizzes'] = app()->make('InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesServiceContract');
        $this->services['dataTables'] = app()->make('InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesDataTableServiceContract');
    }

    /**
     * Список объектов.
     *
     * @return IndexResponseContract
     */
    public function index(): IndexResponseContract
    {
        $table = $this->services['dataTables']->html();

        return app()->makeWith('InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\IndexResponseContract', [
            'data' => compact('table'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param string $type
     *
     * @return FormResponseContract
     */
    public function create(string $type): FormResponseContract
    {
        $item = $this->services['quizzes']->getQuizObject();

        return app()->makeWith('InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\FormResponseContract', [
            'data' => compact('item', 'type'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param SaveQuizRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(SaveQuizRequestContract $request): SaveResponseContract
    {
        return $this->save($request);
    }

    /**
     * Редактирование объекта.
     *
     * @param int $id
     *
     * @return FormResponseContract
     */
    public function edit(int $id = 0): FormResponseContract
    {
        $item = $this->services['quizzes']->getQuizObject($id);

        return app()->makeWith('InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\FormResponseContract', [
            'data' => compact('item'),
        ]);
    }

    /**
     * Обновление объекта.
     *
     * @param SaveQuizRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(SaveQuizRequestContract $request, $id = 0): SaveResponseContract
    {
        return $this->save($request, $id);
    }

    /**
     * Сохранение теста.
     *
     * @param SaveQuizRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    protected function save(SaveQuizRequestContract $request, $id = 0): SaveResponseContract
    {
        $item = $this->services['quizzes']->save($request, $id);

        return app()->makeWith('InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\SaveResponseContract', [
            'item' => $item,
        ]);
    }

    /**
     * Удаление объекта.
     *
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(int $id = 0): DestroyResponseContract
    {
        $result = $this->services['quizzes']->destroy($id);

        return app()->makeWith('InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\DestroyResponseContract', [
            'result' => ($result === null) ? false : $result,
        ]);
    }
}
