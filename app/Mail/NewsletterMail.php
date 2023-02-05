<?php

namespace App\Mail;

use App\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newsletter)
    {
        $this->id = $newsletter->id;
        $this->newsletter = $newsletter;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // print_r($user);die();

        // return $this->view('/admin/service_provider/background_check')->with([
        //         'id' => $this->id
        //     ]);
        return $this->view('/admin/newsletter/newsletter_mail')->with([
                'newsletter' => $this->newsletter
            ]);
    }
}
