<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CLIP extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    protected $type;
    protected $topic;

    /**
    * Create a new message instance.
    *
    * @return void
    */
    public function __construct($data, $type, $topic)
    {
        $this->data = $data;
        $this->type = $type;
        $this->topic = $topic;
    }

    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        if ($this->type == 'pics') {
            $subject = 'BTA PressClip - pic ' . $this->topic;
        } elseif ($this->type == 'text') {
            $subject = 'BTA PressClip ' . $this->topic;
        }

        $email = $this->view('emails.clip')
                      ->subject($subject)
                      ->markdown('emails.clip');

        foreach ($this->data as $attachment) {
           $email->attach($attachment);
        }

        sleep(3);
    }
}

// $data = [
//     'pic' => [
//         'topic-num' => [
//             0 => 'path',
//             1 => 'path',
//         ],
//     ],
// ];
