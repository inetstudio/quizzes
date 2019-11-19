<?php

namespace InetStudio\QuizzesPackage\Results\Services\Front;

use League\Fractal\Manager;
use Illuminate\Support\Facades\Notification;
use League\Fractal\Resource\Item as FractalItem;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract;
use InetStudio\QuizzesPackage\Results\Contracts\Services\Front\ItemsServiceContract;
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
     * @param  ResultModelContract  $model
     * @param  SimpleDataArraySerializerContract  $serializer
     */
    public function __construct(ResultModelContract $model, SimpleDataArraySerializerContract $serializer)
    {
        parent::__construct($model);

        $this->dataManager = new Manager();
        $this->dataManager->setSerializer($serializer);
    }

    /**
     * Получаем информацию по результату.
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
            app()->make('InetStudio\QuizzesPackage\Results\Transformers\Front\ItemTransformer')
        );

        $data = $this->dataManager->createData($resource)->toArray();

        return [
            'success' => true,
            'result' => $data,
        ];
    }

    /**
     * Отправляем результат теста на почту.
     *
     * @param int $resultId
     * @param string $url
     * @param string $email
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function sendResultToEmail(int $resultId, string $url, string $email): array
    {
        $usersResultsService = app()->make('InetStudio\QuizzesPackage\UsersResults\Services\Front\ItemsService');

        $result = $this->getItemById($resultId);

        $resource = new FractalItem(
            $result,
            app()->make('InetStudio\QuizzesPackage\Results\Transformers\Front\ItemTransformer')
        );
        $data = $this->dataManager->createData($resource)->toArray();

        $data = [
            'result' => $data,
            'url' => $url,
        ];

        $notification = app()->make(
            'InetStudio\QuizzesPackage\Results\Contracts\Notifications\Front\ResultNotificationContract',
            compact('data')
        );
        Notification::route('mail', $email)->notify($notification);

        $hash = session('quiz_hash');
        $usersResultsService->update(
            [
                'email' => $email,
            ],
            [
                ['hash', '=', $hash],
            ]
        );

        return [
            'message' => 'Результат теста отправлен на указанный email',
            'success' => true,
        ];
    }
}
