<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['create', 'store', 'showLoginForm', 'login']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function index()
    {
        $pelanggan = Auth::user();
        return view('pelanggan.profile', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggans',
            'password' => 'required|string|min:8|confirmed',
            'nim' => 'required|string|unique:pelanggans',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'no_ktp' => 'required|string|unique:pelanggans',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nim' => $validated['nim'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'no_ktp' => $validated['no_ktp'],
        ]);

        Auth::login($pelanggan);

        return redirect('/dashboard');
    }

    public function show(Pelanggan $pelanggan)
    {
        return view('pelanggan.show', compact('pelanggan'));
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggans,email,' . $pelanggan->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $pelanggan->nama = $validated['nama'];
        $pelanggan->email = $validated['email'];
        
        if (isset($validated['password'])) {
            $pelanggan->password = Hash::make($validated['password']);
        }

        $pelanggan->save();

        return redirect()->route('pelanggans.index')->with('success', 'Profile updated successfully');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggans.index')->with('success', 'Account deleted successfully');
    }
}
