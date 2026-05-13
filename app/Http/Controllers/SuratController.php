<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    public function masuk(Request $request)
    {
        $query = Surat::masuk()->with('creator');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_surat', 'like', "%{$request->search}%")
                  ->orWhere('kode_surat', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_surat', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_surat', '<=', $request->tanggal_sampai);
        }

        $surats = $query->latest()->paginate(10)->withQueryString();

        return view('surat.masuk', compact('surats'));
    }

    public function keluar(Request $request)
    {
        $query = Surat::keluar()->with('creator');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_surat', 'like', "%{$request->search}%")
                  ->orWhere('kode_surat', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $surats = $query->latest()->paginate(10)->withQueryString();

        return view('surat.keluar', compact('surats'));
    }

    public function rahasia(Request $request)
    {
        // Check if session has verified access
        if (!session('rahasia_verified')) {
            return view('surat.rahasia-lock');
        }

        $surats = Surat::rahasia()->with('creator')->latest()->paginate(10);

        return view('surat.rahasia', compact('surats'));
    }

    public function verifyRahasia(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        // Check against current user's password
        if (\Hash::check($request->password, auth()->user()->password)) {
            session(['rahasia_verified' => true]);
            LogAktivitas::log('access_rahasia', 'User mengakses halaman Surat Rahasia.');
            return redirect()->route('surat.rahasia');
        }

        return back()->withErrors(['password' => 'Password salah. Akses ditolak.']);
    }

    public function create()
    {
        return view('surat.input');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_surat'    => 'required|string|max:50|unique:surats',
            'nama_surat'    => 'required|string|max:255',
            'jenis_surat'   => 'required|in:masuk,keluar',
            'kategori'      => 'required|in:umum,penting,rahasia',
            'tanggal_surat' => 'required|date',
            'keterangan'    => 'nullable|string',
            'file'          => 'nullable|file|max:20480', // 20MB
        ], [
            'kode_surat.required'    => 'Kode surat wajib diisi.',
            'kode_surat.unique'      => 'Kode surat sudah digunakan.',
            'nama_surat.required'    => 'Nama surat wajib diisi.',
            'jenis_surat.required'   => 'Jenis surat wajib dipilih.',
            'kategori.required'      => 'Kategori surat wajib dipilih.',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
            'file.max'               => 'Ukuran file maksimal 20MB.',
        ]);

        $data = $request->only(['kode_surat', 'nama_surat', 'jenis_surat', 'kategori', 'tanggal_surat', 'keterangan']);
        $data['created_by'] = auth()->id();
        $data['status'] = 'aktif';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('surat', $fileName, 'public');
            $data['file_path'] = $filePath;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['file_type'] = $file->getMimeType();
        }

        $surat = Surat::create($data);

        LogAktivitas::log('create_surat', "Upload surat: {$surat->nama_surat} ({$surat->kode_surat})", $surat->id, 'Surat');

        return redirect()->route('surat.' . $surat->jenis_surat)
            ->with('success', 'Surat berhasil ditambahkan!');
    }

    public function show($id)
    {
        $surat = Surat::with('creator')->findOrFail($id);
        return view('surat.show', compact('surat'));
    }

    public function edit($id)
    {
        $surat = Surat::findOrFail($id);
        return view('surat.edit', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);

        $request->validate([
            'kode_surat'    => 'required|string|max:50|unique:surats,kode_surat,' . $id,
            'nama_surat'    => 'required|string|max:255',
            'jenis_surat'   => 'required|in:masuk,keluar',
            'kategori'      => 'required|in:umum,penting,rahasia',
            'tanggal_surat' => 'required|date',
            'file'          => 'nullable|file|max:20480',
        ]);

        $data = $request->only(['kode_surat', 'nama_surat', 'jenis_surat', 'kategori', 'tanggal_surat', 'keterangan']);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }
            $file = $request->file('file');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('surat', $fileName, 'public');
            $data['file_path'] = $filePath;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['file_type'] = $file->getMimeType();
        }

        $surat->update($data);

        LogAktivitas::log('update_surat', "Edit surat: {$surat->nama_surat} ({$surat->kode_surat})", $surat->id, 'Surat');

        return redirect()->route('surat.' . $surat->jenis_surat)
            ->with('success', 'Surat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);

        // Simpan jenis sebelum dihapus
        $jenis = $surat->jenis_surat;

        if ($surat->file_path) {
            Storage::disk('public')->delete($surat->file_path);
        }

        LogAktivitas::log('delete_surat', "Hapus surat: {$surat->nama_surat} ({$surat->kode_surat})", $surat->id, 'Surat');

        $surat->delete();

        // Redirect ke list yang sesuai, bukan back()
        return redirect()->route('surat.' . $jenis)
            ->with('success', 'Surat berhasil dihapus!');
    }

    public function download($id)
    {
        $surat = Surat::findOrFail($id);

        if (!$surat->file_path || !Storage::disk('public')->exists($surat->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($surat->file_path, $surat->file_name);
    }
}
