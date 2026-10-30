<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UnitIrban;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(Request $request): View
    {
        $kategori = Category::query()
            ->with('defaultUnitIrban')
            ->when($request->string('cari')->value(), fn ($q, $cari) =>
                $q->where('nama_kategori', 'like', "%{$cari}%")
            )
            ->latest()
            ->paginate(config('ekonsul.per_halaman', 15))
            ->withQueryString();

        return view('admin.kategori.index', compact('kategori'));
    }

    public function create(): View
    {
        $unitIrban = UnitIrban::query()->active()->ordered()->get();

        return view('admin.kategori.create', compact('unitIrban'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_kategori'        => 'required|string|max:255|unique:categories,nama_kategori',
            'deskripsi'            => 'nullable|string|max:1000',
            'default_unit_irban_id' => 'nullable|exists:unit_irbans,id',
        ]);

        $data['is_active'] = true;

        Category::create($data);

        return redirect()->route('admin.kategori.index')
            ->with('sukses', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $kategori): View
    {
        $unitIrban = UnitIrban::query()->active()->ordered()->get();

        return view('admin.kategori.edit', compact('kategori', 'unitIrban'));
    }

    public function update(Request $request, Category $kategori): RedirectResponse
    {
        $data = $request->validate([
            'nama_kategori'        => 'required|string|max:255|unique:categories,nama_kategori,' . $kategori->id,
            'deskripsi'            => 'nullable|string|max:1000',
            'default_unit_irban_id' => 'nullable|exists:unit_irbans,id',
        ]);

        // Reset slug saat nama berubah
        if ($data['nama_kategori'] !== $kategori->nama_kategori) {
            $data['slug'] = '';
        }

        $kategori->update($data);

        return redirect()->route('admin.kategori.index')
            ->with('sukses', 'Kategori berhasil diperbarui.');
    }

    public function toggle(Category $kategori): RedirectResponse
    {
        $kategori->update(['is_active' => ! $kategori->is_active]);

        $status = $kategori->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('sukses', "Kategori {$kategori->nama_kategori} berhasil {$status}.");
    }
}
