<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KonsultasiSelesai extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Ticket $tiket) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[E-KONSUL] Konsultasi {$this->tiket->kode_tiket} Telah Selesai",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.konsultasi-selesai',
            with: [
                'kode'  => $this->tiket->kode_tiket,
                'judul' => $this->tiket->judul,
            ],
        );
    }
}
