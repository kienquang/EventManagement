<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegistrationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $registration;

    public function __construct(Registration $registration,Event $event)
    {
        $this->event = $event;
        $this->registration= $registration;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Xác nhận đăng ký sự kiện',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $qrData = route('checkin.qr', ['id' => $this->registration->id]);
        return new Content(
            markdown: 'emails.registration_success',
            with: [
                'event' => $this->event,
                'qr' => base64_encode(QrCode::format('png')->size(200)->generate($qrData)),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
