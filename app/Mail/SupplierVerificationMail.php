<?php

namespace App\Mail;

use App\EmailTemplate;
use App\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupplierVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $template;
    private $emailParams;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email)
    {
        $this->template = EmailTemplate::where('template', 'supplier-approved')->first();
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
            ->view('admin.suppliers.supplier_verification_mail', [
                'messageBody' => $messageBody
            ]);
    }
}
