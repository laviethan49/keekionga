<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class KeekiongaMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name, $phone, $comment, $list, $total;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $phone, $comment, $list, $total)
    {
        $this->email = $email;
        $this->name = $name;
        $this->phone = $phone;
        $this->comment = $comment;
        $this->list = $list;
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.inquiry');
    }
}
