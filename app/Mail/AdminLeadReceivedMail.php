<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminLeadReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @param array<string, string> $details */
    public function __construct(public readonly string $type, public readonly array $details)
    {
    }

    public function build(): self
    {
        return $this->subject('طلب جديد من موقع INTOK')->view('emails.leads.received');
    }
}
