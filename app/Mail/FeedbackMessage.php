<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Message;

class FeedbackMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Message $msg)
    {
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = config('mail.from.address');
        $name = config('mail.from.name');
        $ip = $_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? '-';
		$useragent = $_SERVER['HTTP_USER_AGENT'] ?? '-';

        return $this->
            to($address, $name)->
            subject('[Moon1] Новое собщение')->
            view('mails.feedback')->with([
                'ip' => $ip,
                'useragent' => $useragent,
            ]);
    }
}
