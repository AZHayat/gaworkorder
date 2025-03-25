<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override default login untuk pakai username.
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Custom credentials untuk login.
     */
    protected function credentials(Request $request)
    {
        return [
            'username' => $request->username,
            'password' => $request->password,
        ];
    }

    /**
     * Handle login request tanpa email.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba login
        if (Auth::attempt($this->credentials($request))) {
            return redirect()->intended($this->redirectPath());
        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }
}
