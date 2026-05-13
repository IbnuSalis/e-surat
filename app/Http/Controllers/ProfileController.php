<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $recentActivity = LogAktivitas::where('user_id', $user->id)->latest()->limit(10)->get();

        return view('profile.index', compact('user', 'recentActivity'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'jabatan' => 'nullable|string|max:100',
            'phone'   => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['name', 'email', 'jabatan', 'phone']));

        LogAktivitas::log('update_profile', 'Update profil pengguna.');

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'foto.required' => 'Foto wajib diupload.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        $user = auth()->user();

        // Delete old photo
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $foto = $request->file('foto');
        $fotoName = 'profile/' . Str::uuid() . '.' . $foto->getClientOriginalExtension();
        $foto->storeAs('', $fotoName, 'public');

        $user->update(['foto' => $fotoName]);

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.min'              => 'Password minimal 8 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        LogAktivitas::log('change_password', 'Mengubah password akun.');

        return back()->with('success', 'Password berhasil diubah!');
    }
}
