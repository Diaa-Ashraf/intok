<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Inquiry $inquiry)
    {
    }

    public function build(): self
    {
        return $this->subject('استفسار جديد من موقع INTOK')->view('emails.inquiries.received');
    }
}
