<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use Authenticatable;

    protected $redirectTo = '/dashboard';
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menangani login
    public function login(Request $request)
    {
        // Validasi data login
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Melakukan upaya login
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika login berhasil, perbarui last_login, device_id, dan device_name
            Auth::user()->update([
                'last_login' => now(),
                'device_id' => $request->input('device_id'),
                'device_name' => $request->input('device_name'),
            ]);

            return redirect()->intended($this->redirectTo);
        }

        // Jika login gagal
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Logout
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
