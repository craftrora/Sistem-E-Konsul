<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'jabatan'  => ['nullable', 'string', 'max:100'],
            'no_wa'    => ['required', 'string', 'regex:/^[0-9]{9,15}$/'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'no_wa.required'   => 'Nomor WhatsApp wajib diisi.',
            'no_wa.regex'      => 'Nomor WhatsApp hanya boleh berisi angka, 9 sampai 15 digit.',
            'password.min'     => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $nomor = preg_replace('/[^0-9]/', '', $data['no_wa']);
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        $user = $request->user();
        $user->name    = $data['name'];
        $user->jabatan = $data['jabatan'] ?? $user->jabatan;
        $user->no_wa   = $nomor;

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('sukses', 'Profil berhasil diperbarui.');
    }
}
