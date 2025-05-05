<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $purchaser;
    public $item_name;

    public function __construct($purchaser, $item_name)
    {
        $this->purchaser = $purchaser;
        $this->item_name = $item_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('from_address@example.com')
                    ->view('emails.completed')
                    ->subject('メールテストタイトル');
    }
}
