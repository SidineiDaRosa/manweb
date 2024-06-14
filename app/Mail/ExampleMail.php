<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExampleMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('emails.example')
                    ->with([
                        'name' => 'Sidinei',
                    ])
                    ->subject('Assunto do Email');
    }
}
