<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Opd;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        abort_unless(config('ekonsul.pendaftaran.dibuka'), 404);

        $daftarOpd = Opd::query()
            ->active()
            ->where('pendaftaran_dibuka', true)
            ->orderBy('nama_opd')
            ->get(['id', 'nama_opd']);

        return view('auth.register', compact('daftarOpd'));
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        abort_unless(config('ekonsul.pendaftaran.dibuka'), 404);

        $user = User::create([
            'name'      => $request->string('name')->trim()->value(),
            'email'     => $request->string('email')->value(),
            'password'  => Hash::make($request->string('password')->value()),
            'role'      => RoleEnum::OPD,
            'opd_id'    => $request->integer('opd_id'),
            'jabatan'   => $request->string('jabatan')->trim()->value(),
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $user->forceFill(['last_login_at' => now()])->save();

        return redirect()
            ->route('opd.dashboard')
            ->with('sukses', 'Pendaftaran berhasil. Selamat datang di E-KONSUL, ' . $user->name . '.');
    }
}
