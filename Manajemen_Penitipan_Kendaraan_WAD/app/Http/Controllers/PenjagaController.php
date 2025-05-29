<?php

namespace App\Http\Controllers;

use App\Models\Penjaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PenjagaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:penjaga')->except(['create', 'store', 'showLoginForm', 'login']);
    }

    public function showLoginForm()
    {
        return view('penjaga.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('penjaga')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/penjaga/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('penjaga')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('penjaga.login')->with('success', 'Anda telah berhasil logout.');
    }

    public function index()
    {
        $penjaga = Auth::guard('penjaga')->user();
        return view('penjaga.profile', compact('penjaga'));
    }

    public function create()
    {
        return view('penjaga.auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:penjagas',
            'password' => 'required|string|min:8|confirmed',
            'nim' => 'required|string|unique:penjagas',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'no_ktp' => 'required|string|unique:penjagas',
        ]);

        $penjaga = Penjaga::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nim' => $validated['nim'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'no_ktp' => $validated['no_ktp'],
        ]);

        Auth::guard('penjaga')->login($penjaga);

        return redirect('/penjaga/dashboard');
    }

    public function show(Penjaga $penjaga)
    {
        return view('penjaga.show', compact('penjaga'));
    }

    public function edit(Penjaga $penjaga)
    {
        return view('penjaga.edit', compact('penjaga'));
    }

    public function update(Request $request, Penjaga $penjaga)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:penjagas,email,' . $penjaga->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $penjaga->nama = $validated['nama'];
        $penjaga->email = $validated['email'];
        
        if (isset($validated['password'])) {
            $penjaga->password = Hash::make($validated['password']);
        }

        $penjaga->save();

        return redirect()->route('penjagas.index')->with('success', 'Profile updated successfully');
    }

    public function destroy(Penjaga $penjaga)
    {
        $penjaga->delete();
        return redirect()->route('penjagas.index')->with('success', 'Account deleted successfully');
    }
}
