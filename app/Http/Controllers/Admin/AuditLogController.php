<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $log = AuditLog::query()
            ->with('user')
            ->when($request->string('cari')->value(), fn ($q, $cari) =>
                $q->where('aksi', 'like', "%{$cari}%")
                  ->orWhere('model_type', 'like', "%{$cari}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$cari}%"))
            )
            ->when($request->string('aksi')->value(), fn ($q, $aksi) =>
                $q->where('aksi', $aksi)
            )
            ->latest()
            ->paginate(config('ekonsul.per_halaman', 20))
            ->withQueryString();

        $daftarAksi = AuditLog::query()
            ->distinct()
            ->orderBy('aksi')
            ->pluck('aksi');

        return view('admin.audit-log.index', compact('log', 'daftarAksi'));
    }
}
