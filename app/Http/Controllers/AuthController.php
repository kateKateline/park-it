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

        // Cari user terlebih dahulu untuk pengecekan case-sensitive dan status tangguhkan
        $user = \App\Models\User::where('username', $credentials['username'])->first();

        // Pengecekan case-sensitive manual (username di DB harus sama persis dengan input)
        if (!$user || $user->username !== $credentials['username']) {
            return back()
                ->withErrors(['username' => 'Username atau password salah.'])
                ->onlyInput('username');
        }

        if ($user->is_tangguhkan) {
            return back()
                ->withErrors(['username' => 'Akun Anda ditangguhkan. Silakan hubungi admin.'])
                ->onlyInput('username');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => "Login: {$user->username} ({$user->role})",
            ]);
            
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

        return redirect()->route('landing');
    }
}
