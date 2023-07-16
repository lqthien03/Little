<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $name = "";
    public $phone = "";
    public $email = "";
    public $address = "";
    public $messeger = "";
    public function __construct($name, $phone, $email, $address, $messeger)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->messeger = $messeger;
    }
    public function envelope()
    {
        return new Envelope(subject: 'Mail liên hệ từ khách hàng',);
    }
    public function content()
    {
        return new Content(view: 'viewMailLienHe',);
    }
    public function attachments()
    {
        return [];
    }
}
