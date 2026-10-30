@props(['pesan'])

<div class="d-flex flex-column gap-3">
    @foreach ($pesan as $item)
        @php
            $dariOpd = $item->user->isOpd();
            $warnaBubble = match (true) {
                $item->tipe->value === 'pertanyaan'       => 'bg-light border',
                $item->tipe->value === 'balasan'          => 'bg-light border',
                $item->tipe->value === 'jawaban'          => 'bg-primary-subtle border border-primary-subtle',
                $item->tipe->value === 'catatan_internal' => 'bg-warning-subtle border border-warning-subtle',
                default => 'bg-light border',
            };
        @endphp

        <div class="d-flex {{ $dariOpd ? 'justify-content-start' : 'justify-content-end' }}">
            <div class="{{ $warnaBubble }} rounded p-3" style="max-width: 80%;">
                <div class="d-flex justify-content-between align-items-center mb-1 gap-3">
                    <span class="fw-semibold small">
                        {{ $item->user->name }}
                        <span class="text-muted fw-normal">&middot; {{ $item->user->role->label() }}</span>
                    </span>
                    <span class="text-muted small text-nowrap">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
                </div>

                @if ($item->tipe->value === 'catatan_internal')
                    <div class="small text-warning-emphasis mb-1">
                        <i class="bi bi-eye-slash"></i> Catatan internal — tidak terlihat oleh OPD
                    </div>
                @endif

                <div class="small" style="white-space: pre-line;">{{ $item->isi }}</div>

                <x-lampiran-list :lampiran="$item->attachments" />
            </div>
        </div>
    @endforeach
</div>
