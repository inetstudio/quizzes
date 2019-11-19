<?php

namespace InetStudio\QuizzesPackage\Results\Notifications\Front;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Results\Contracts\Mail\Front\ResultMailContract;
use InetStudio\QuizzesPackage\Results\Contracts\Notifications\Front\ResultNotificationContract;

/**
 * Class ResultNotification.
 */
class ResultNotification extends Notification implements ResultNotificationContract
{
    /**
     * Токен.
     *
     * @var array
     */
    public $data;

    /**
     * ResultNotification constructor.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param $notifiable
     *
     * @return ResultMailContract
     *
     * @throws BindingResolutionException
     */
    public function toMail($notifiable): ResultMailContract
    {
        return app()->make(
            'InetStudio\QuizzesPackage\Results\Contracts\Mail\Front\ResultMailContract',
            [
                'data' => $this->data,
            ]
        );
    }
}
