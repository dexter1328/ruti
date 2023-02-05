<?php

namespace App\Mail;

use App\SuggestedPlace;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuggestedPlaceMail extends Mailable
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
    public function __construct($suggested_place)
    {
        $this->id = $suggested_place->id;
        $this->suggested_place = $suggested_place;

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
        return $this->view('/admin/suggested_place/suggested_place_mail')->with([
                'suggested_place' => $this->suggested_place
            ]);
    }
}
