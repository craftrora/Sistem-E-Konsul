<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentService
{
    public function simpan(UploadedFile $file, TicketMessage $pesan, User $pengunggah): Attachment
    {
        $folder   = 'lampiran/' . now()->format('Y/m');
        $namaFile = (string) Str::uuid() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs($folder, $namaFile, config('ekonsul.lampiran.disk'));

        return Attachment::create([
            'ticket_message_id' => $pesan->id,
            'nama_asli'         => $file->getClientOriginalName(),
            'path'              => $path,
            'mime_type'         => $file->getClientMimeType(),
            'ukuran'            => $file->getSize(),
            'uploaded_by'       => $pengunggah->id,
        ]);
    }

    /** @param UploadedFile[] $files */
    public function simpanBanyak(array $files, TicketMessage $pesan, User $pengunggah): void
    {
        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $this->simpan($file, $pesan, $pengunggah);
            }
        }
    }

    public function hapus(Attachment $attachment): void
    {
        Storage::disk(config('ekonsul.lampiran.disk'))->delete($attachment->path);
        $attachment->delete();
    }
}
