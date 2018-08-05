<?php

namespace InetStudio\Quizzes\Notifications\Front;

use Illuminate\Notifications\Notification;
use InetStudio\Quizzes\Contracts\Mail\ResultMailContract;
use InetStudio\Quizzes\Contracts\Notifications\Front\QuizResultNotificationContract;

/**
 * Class QuizResultNotification.
 */
class QuizResultNotification extends Notification implements QuizResultNotificationContract
{
    /**
     * Токен.
     *
     * @var array
     */
    public $data;

    /**
     * Пользователь.
     *
     * @var string
     */
    public $email;

    /**
     * QuizResultNotification constructor.
     *
     * @param string $email
     * @param array $data
     */
    public function __construct(string $email, array $data)
    {
        $this->email = $email;
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
     */
    public function toMail($notifiable): ResultMailContract
    {
        return app()->makeWith('InetStudio\Quizzes\Contracts\Mail\ResultMailContract', [
            'data' => $this->data,
        ])->to($this->email);
    }
}
