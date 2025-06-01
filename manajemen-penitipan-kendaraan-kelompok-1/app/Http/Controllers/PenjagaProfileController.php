<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PenjagaProfileController extends Controller
{
    public function edit()
    {
        return view('penjaga.profile');
    }

    public function update(Request $request)
    {
        $user = auth('penjaga')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:penjagas,email,' . $user->id,
            'no_hp' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                \Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('penjaga_profile', 'public');
        }

        $user->update($data);

        return redirect()->route('penjaga.profile')->with('status', 'Profil berhasil diperbarui!');
    }
} 