<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\UnitIrban;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OpdController extends Controller
{
    public function index(Request $request): View
    {
        $opd = Opd::query()
            ->with('unitIrban')
            ->when($request->string('cari')->value(), fn ($q, $cari) =>
                $q->where('nama_opd', 'like', "%{$cari}%")
                  ->orWhere('kode_opd', 'like', "%{$cari}%")
            )
            ->latest()
            ->paginate(config('ekonsul.per_halaman', 15))
            ->withQueryString();

        return view('admin.opd.index', compact('opd'));
    }

    public function create(): View
    {
        $unitIrban = UnitIrban::query()->active()->ordered()->get();

        return view('admin.opd.create', compact('unitIrban'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kode_opd'        => 'required|string|max:20|unique:opds,kode_opd',
            'nama_opd'        => 'required|string|max:255',
            'unit_irban_id'   => 'nullable|exists:unit_irbans,id',
            'alamat'          => 'nullable|string|max:500',
            'no_wa'           => 'nullable|string|max:20',
            'pendaftaran_dibuka' => 'boolean',
        ]);

        $data['kode_pendaftaran']   = strtoupper(Str::random(8));
        $data['is_active']          = true;
        $data['pendaftaran_dibuka'] = $request->boolean('pendaftaran_dibuka');

        Opd::create($data);

        return redirect()->route('admin.opd.index')
            ->with('sukses', 'OPD berhasil ditambahkan.');
    }

    public function show(Opd $opd): View
    {
        $opd->load(['unitIrban', 'users', 'tickets' => fn ($q) => $q->latest()->take(10)]);

        return view('admin.opd.show', compact('opd'));
    }

    public function edit(Opd $opd): View
    {
        $unitIrban = UnitIrban::query()->active()->ordered()->get();

        return view('admin.opd.edit', compact('opd', 'unitIrban'));
    }

    public function update(Request $request, Opd $opd): RedirectResponse
    {
        $data = $request->validate([
            'kode_opd'        => 'required|string|max:20|unique:opds,kode_opd,' . $opd->id,
            'nama_opd'        => 'required|string|max:255',
            'unit_irban_id'   => 'nullable|exists:unit_irbans,id',
            'alamat'          => 'nullable|string|max:500',
            'no_wa'           => 'nullable|string|max:20',
            'pendaftaran_dibuka' => 'boolean',
        ]);

        $data['pendaftaran_dibuka'] = $request->boolean('pendaftaran_dibuka');

        $opd->update($data);

        return redirect()->route('admin.opd.index')
            ->with('sukses', 'Data OPD berhasil diperbarui.');
    }

    public function toggle(Opd $opd): RedirectResponse
    {
        $opd->update(['is_active' => ! $opd->is_active]);

        $status = $opd->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('sukses', "OPD {$opd->nama_opd} berhasil {$status}.");
    }

    public function resetKode(Opd $opd): RedirectResponse
    {
        $opd->update(['kode_pendaftaran' => strtoupper(Str::random(8))]);

        return back()->with('sukses', 'Kode pendaftaran berhasil direset.');
    }
}
