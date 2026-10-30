<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KonsultasiDibuat extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Ticket $tiket) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[E-KONSUL] Konsultasi {$this->tiket->kode_tiket} Telah Diterima",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.konsultasi-dibuat',
            with: [
                'kode'    => $this->tiket->kode_tiket,
                'judul'   => $this->tiket->judul,
                'tanggal' => $this->tiket->created_at?->translatedFormat('d F Y, H:i') . ' WIB',
            ],
        );
    }
}
