<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class BeritaAcaraController extends Controller
{
    public function index(Request $request)
    {
        $query = BeritaAcara::with('creator');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('nomor', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $beritaAcaras = $query->latest()->paginate(10)->withQueryString();

        return view('berita-acara.index', compact('beritaAcaras'));
    }

    public function create()
    {
        return view('berita-acara.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor'   => 'required|string|max:100|unique:berita_acara,nomor',
            'judul'   => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi'  => 'nullable|string|max:255',
            'isi'     => 'required|string',
            'peserta' => 'nullable|string',
        ]);

        $beritaAcara = BeritaAcara::create(array_merge(
            $request->only(['nomor', 'judul', 'tanggal', 'lokasi', 'isi', 'peserta']),
            ['created_by' => auth()->id(), 'status' => 'draft']
        ));

        LogAktivitas::log('create_berita_acara', "Buat berita acara: {$beritaAcara->judul}", $beritaAcara->id, 'BeritaAcara');

        return redirect()->route('berita-acara.index')->with('success', 'Berita acara berhasil ditambahkan!');
    }

    public function show($id)
    {
        $beritaAcara = BeritaAcara::with('creator')->findOrFail($id);
        return view('berita-acara.show', compact('beritaAcara'));
    }

    public function edit($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        return view('berita-acara.edit', compact('beritaAcara'));
    }

    public function update(Request $request, $id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);

        $request->validate([
            'nomor'  => 'required|string|max:100|unique:berita_acara,nomor,' . $id,
            'judul'  => 'required|string|max:255',
            'tanggal'=> 'required|date',
            'isi'    => 'required|string',
            'status' => 'required|in:draft,final,approved',
        ]);

        $beritaAcara->update($request->only(['nomor', 'judul', 'tanggal', 'lokasi', 'isi', 'peserta', 'status']));

        return redirect()->route('berita-acara.index')->with('success', 'Berita acara berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        $beritaAcara->delete();

        return back()->with('success', 'Berita acara berhasil dihapus!');
    }
}
