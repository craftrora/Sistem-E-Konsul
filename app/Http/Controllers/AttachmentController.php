<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttachmentController extends Controller
{
    public function download(Attachment $attachment): StreamedResponse
    {
        $user  = auth()->user();
        $tiket = $attachment->message->ticket;

        $diizinkan = match (true) {
            $user->isAdmin() => true,
            $user->isOpd()   => $tiket->opd_id === $user->opd_id,
            $user->isIrban() => $tiket->unit_irban_id === $user->unit_irban_id,
            default          => false,
        };

        abort_unless($diizinkan, 403, 'Anda tidak memiliki akses ke lampiran ini.');

        // Catatan internal Irban tidak boleh terlihat OPD, termasuk lampirannya,
        // meskipun tiketnya milik OPD tersebut.
        if ($user->isOpd() && $attachment->message->isInternal()) {
            abort(403, 'Anda tidak memiliki akses ke lampiran ini.');
        }

        return Storage::disk(config('ekonsul.lampiran.disk'))
            ->download($attachment->path, $attachment->nama_asli);
    }
}
