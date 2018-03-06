<?php

namespace InetStudio\Quizzes\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use InetStudio\Quizzes\Contracts\Mail\ResultMailContract;

class ResultMail extends Mailable implements ResultMailContract
{
    use SerializesModels;

    protected $recipient;
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
        $this->recipient = $recipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->to($this->recipient)
            ->subject('Результаты теста')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('admin.module.quizzes::mails.result', $this->data);
    }
}
