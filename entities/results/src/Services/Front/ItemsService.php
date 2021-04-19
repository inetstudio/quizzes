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

class ItemsService extends BaseService implements ItemsServiceContract
{
    protected Manager $dataManager;

    public function __construct(ResultModelContract $model, SimpleDataArraySerializerContract $serializer)
    {
        parent::__construct($model);

        $this->dataManager = new Manager();
        $this->dataManager->setSerializer($serializer);
    }

    public function getItemData(int $id = 0): array
    {
        $item = $this->getItemById($id);

        $resource = new FractalItem(
            $item,
            resolve('InetStudio\QuizzesPackage\Results\Contracts\Transformers\Front\ItemTransformerContract')
        );

        $data = $this->dataManager->createData($resource)->toArray();

        return [
            'success' => true,
            'result' => $data,
        ];
    }

    public function sendResultToEmail(int $resultId, string $url, string $email): array
    {
        $usersResultsService = resolve('InetStudio\QuizzesPackage\UsersResults\Contracts\Services\Front\ItemsServiceContract');

        $result = $this->getItemById($resultId);

        $resource = new FractalItem(
            $result,
            resolve('InetStudio\QuizzesPackage\Results\Contracts\Transformers\Front\ItemTransformerContract')
        );
        $data = $this->dataManager->createData($resource)->toArray();

        $data = [
            'result' => $data,
            'url' => $url,
        ];

        $notification = resolve(
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
