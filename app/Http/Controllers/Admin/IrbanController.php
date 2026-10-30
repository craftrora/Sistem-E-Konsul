<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\UnitIrban;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class IrbanController extends Controller
{
    public function index(Request $request): View
    {
        $irban = User::query()
            ->role(RoleEnum::IRBAN)
            ->with('unitIrban')
            ->when($request->string('cari')->value(), fn ($q, $cari) =>
                $q->where('name', 'like', "%{$cari}%")
                  ->orWhere('email', 'like', "%{$cari}%")
            )
            ->latest()
            ->paginate(config('ekonsul.per_halaman', 15))
            ->withQueryString();

        return view('admin.irban.index', compact('irban'));
    }

    public function create(): View
    {
        $unitIrban = UnitIrban::query()->active()->ordered()->get();

        return view('admin.irban.create', compact('unitIrban'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8|confirmed',
            'unit_irban_id' => 'required|exists:unit_irbans,id',
            'jabatan'       => 'nullable|string|max:255',
            'no_wa'         => 'nullable|string|max:20',
        ]);

        $data['role']      = RoleEnum::IRBAN->value;
        $data['is_active'] = true;
        $data['password']  = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.irban.index')
            ->with('sukses', 'Akun Irban berhasil ditambahkan.');
    }

    public function show(User $irban): View
    {
        $irban->load('unitIrban');

        return view('admin.irban.show', compact('irban'));
    }

    public function edit(User $irban): View
    {
        $unitIrban = UnitIrban::query()->active()->ordered()->get();

        return view('admin.irban.edit', compact('irban', 'unitIrban'));
    }

    public function update(Request $request, User $irban): RedirectResponse
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $irban->id,
            'password'      => 'nullable|string|min:8|confirmed',
            'unit_irban_id' => 'required|exists:unit_irbans,id',
            'jabatan'       => 'nullable|string|max:255',
            'no_wa'         => 'nullable|string|max:20',
        ]);

        if (blank($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $irban->update($data);

        return redirect()->route('admin.irban.index')
            ->with('sukses', 'Akun Irban berhasil diperbarui.');
    }

    public function toggle(User $irban): RedirectResponse
    {
        $irban->update(['is_active' => ! $irban->is_active]);

        $status = $irban->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('sukses', "Akun {$irban->name} berhasil {$status}.");
    }
}
