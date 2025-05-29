<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:penjaga')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|in:pelanggan,penjaga,admin',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        switch ($request->role) {
            case 'admin':
                if (Auth::guard('admin')->attempt($credentials)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/admin/dashboard');
                }
                break;

            case 'penjaga':
                if (Auth::guard('penjaga')->attempt($credentials)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/penjaga/dashboard');
                }
                break;

            case 'pelanggan':
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
                break;
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        $guard = 'web'; // default guard for pelanggan

        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $guard = 'admin';
        } elseif (Auth::guard('penjaga')->check()) {
            Auth::guard('penjaga')->logout();
            $guard = 'penjaga';
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the appropriate login page based on the guard
        switch ($guard) {
            case 'admin':
                return redirect()->route('admin.login')->with('success', 'Anda telah berhasil logout.');
            case 'penjaga':
                return redirect()->route('penjaga.login')->with('success', 'Anda telah berhasil logout.');
            default:
                return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
        }
    }
} 