<?php

namespace App\Mail;

use App\EmailTemplate;
use App\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierSuccess extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $password;
    private $name;
    private $template;
    private $emailParams = [];


    public function __construct($email, $name)
    {
        $this->email = $email;
        $this->name = $name;
        $this->template = EmailTemplate::where('template', 'supplier-signup')->first();
        $this->emailParams['{supplier_name}'] = $name;
        $this->emailParams['{supplier_email}'] = $email;
    }




    public function build()
    {
        $messageBody = str_replace(
            array_keys($this->emailParams),
            array_values($this->emailParams),
            $this->template->body
        );

        return $this->subject($this->template->subject)
            ->view('admin.suppliers.supplier_success', [
                'messageBody' => $messageBody
            ]);
    }
}
