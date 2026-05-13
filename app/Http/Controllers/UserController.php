<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:admin,staff',
            'jabatan'  => 'nullable|string|max:100',
            'phone'    => 'nullable|string|max:20',
        ], [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'role.required'     => 'Role wajib dipilih.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'jabatan'  => $request->jabatan,
            'phone'    => $request->phone,
            'status'   => 'active',
        ]);

        LogAktivitas::log('create_user', "Buat user baru: {$user->name} ({$user->role})", $user->id, 'User');

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $id,
            'role'    => 'required|in:admin,staff',
            'jabatan' => 'nullable|string|max:100',
            'phone'   => 'nullable|string|max:20',
        ]);

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'role'    => $request->role,
            'jabatan' => $request->jabatan,
            'phone'   => $request->phone,
        ]);

        LogAktivitas::log('update_user', "Edit user: {$user->name}", $user->id, 'User');

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        LogAktivitas::log('delete_user', "Hapus user: {$user->name}", $user->id, 'User');
        $user->delete();

        return back()->with('success', 'User berhasil dihapus!');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $newPassword = Str::random(10);

        $user->update(['password' => Hash::make($newPassword)]);

        LogAktivitas::log('reset_password', "Reset password user: {$user->name}", $user->id, 'User');

        return back()->with('success', "Password berhasil direset. Password baru: <strong>{$newPassword}</strong>");
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun sendiri.');
        }

        $user->update(['status' => $user->status === 'active' ? 'inactive' : 'active']);

        return back()->with('success', 'Status user berhasil diperbarui!');
    }
}
