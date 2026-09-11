<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login admin.
     */
    public function showLogin(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Memproses login admin.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $success = Auth::attempt(
            [
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'status' => 'active',
            ],
            $request->boolean('remember')
        );

        if (! $success) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password salah, atau akun tidak aktif.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (! $user->role || ! $user->role->is_active) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'email' => 'Role akun tidak aktif.',
                ])
                ->onlyInput('email');
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}