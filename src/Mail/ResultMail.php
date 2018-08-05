<?php

namespace InetStudio\Quizzes\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use InetStudio\Quizzes\Contracts\Mail\ResultMailContract;

/**
 * Class ResultMail.
 */
class ResultMail extends Mailable implements ResultMailContract
{
    use SerializesModels;

    protected $data;

    /**
     * ResultMail constructor.
     *
     * @param string $recipient
     * @param array $data
     */
    public function __construct(string $recipient, array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Результаты теста')
            ->view('admin.module.quizzes::mails.result', $this->data);
    }
}
