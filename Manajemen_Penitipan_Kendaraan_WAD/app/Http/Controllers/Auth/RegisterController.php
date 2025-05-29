<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Penjaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:penjaga');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:pelanggan,penjaga',
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'nim' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'no_ktp' => 'required|string',
        ]);

        if ($validated['role'] === 'pelanggan') {
            // Additional validation for unique fields in pelanggan table
            $request->validate([
                'email' => 'unique:pelanggans',
                'nim' => 'unique:pelanggans',
                'no_ktp' => 'unique:pelanggans',
            ]);

            $user = Pelanggan::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'nim' => $validated['nim'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'no_ktp' => $validated['no_ktp'],
            ]);

            Auth::login($user);
            return redirect('/dashboard');
        } else {
            // Additional validation for unique fields in penjaga table
            $request->validate([
                'email' => 'unique:penjagas',
                'nim' => 'unique:penjagas',
                'no_ktp' => 'unique:penjagas',
            ]);

            $user = Penjaga::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'nim' => $validated['nim'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'no_ktp' => $validated['no_ktp'],
            ]);

            Auth::guard('penjaga')->login($user);
            return redirect('/penjaga/dashboard');
        }
    }
} 