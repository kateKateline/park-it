<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = $request->user();
            if ($user) {
                LogAktivitas::create([
                    'user_id' => $user->id,
                    'aktivitas' => "Login: {$user->username} ({$user->role})",
                ]);
            }
            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors(['username' => 'Username atau password salah.'])
            ->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($user) {
            LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => "Logout: {$user->username} ({$user->role})",
            ]);
        }

        return redirect()->route('login');
    }
}
