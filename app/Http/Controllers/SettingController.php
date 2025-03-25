<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan Model User dikenali

class SettingController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth'); // Hanya untuk user yang sudah login
    // }

    // Tampilkan halaman setting profil
    public function profil()
    {
        return view('workorder.setting_profil', ['user' => Auth::user()]);
    }

    // Update profil
    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Pastikan mendapatkan user dari database
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->route('setting.profil')->with('error', 'User tidak ditemukan.');
        }

        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Sekarang pasti bisa dipanggil

        return redirect()->route('setting.profil')->with('success', 'Profil berhasil diperbarui!');
    }

    // Tampilkan halaman setting akun
    public function akun()
    {
        // $this->authorize('user'); // Pastikan hanya admin yang bisa mengakses
        $users = User::all(); // Ambil semua user

        return view('workorder.setting_akun', ['users' => $users]);
    }

    // Simpan akun baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,executor,admin',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('setting_akun')->with('success', 'Akun berhasil ditambahkan.');
    }

    // Update akun (termasuk password tanpa perlu password lama)
    public function update(Request $request, $id)
    {
        // $this->authorize('admin');

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role' => 'required|in:user,executor,admin',
            'password' => 'nullable|string|min:6',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('setting_akun')->with('success', 'Akun berhasil diperbarui.');
    }

    // Hapus akun
    public function destroy($id)
    {
        // $this->authorize('admin');

        User::destroy($id);
        
        return back()->with('success', 'Akun berhasil dihapus');
    }

    // Reset password ke default "user12345"
    public function resetPassword($id)
    {
        // $this->authorize('admin');

        $user = User::findOrFail($id);
        $user->password = Hash::make('user12345');
        $user->save();

        return back()->with('success', "Password akun {$user->username} telah direset ke default.");
    }
}
