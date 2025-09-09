<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        \Log::info('Mencoba login', ['email' => $request->email]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Check if user is admin
            /** @var User $user */
            $user = Auth::user();
            \Log::info('Login berhasil', ['user_id' => $user->id, 'email' => $user->email, 'role' => $user->role]);
            if ($user && $user->isAdmin()) {
                \Log::info('User adalah admin', ['user_id' => $user->id]);
                return redirect()->intended(route('admin.dashboard'));
            } else {
                \Log::warning('User bukan admin', ['user_id' => $user->id, 'role' => $user->role]);
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Anda tidak memiliki akses admin.',
                ])->onlyInput('email');
            }
        }

        \Log::warning('Login gagal', ['email' => $request->email]);
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}