<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        $kendaraans = Auth::user()->kendaraans()->paginate(10);
        return view('kendaraan.index', compact('kendaraans'));
    }

    
    public function create()
    {
        return view('kendaraan.create');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_kendaraan' => 'required|in:mobil,motor',
            'merk' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20|unique:kendaraans',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $fotoPath = $request->file('foto')->store('kendaraan-photos', 'public');

        $kendaraan = new Kendaraan([
            'jenis_kendaraan' => $validated['jenis_kendaraan'],
            'merk' => $validated['merk'],
            'tipe' => $validated['tipe'],
            'plat_nomor' => $validated['plat_nomor'],
            'foto' => $fotoPath
        ]);
        

        Auth::user()->kendaraans()->save($kendaraan);

        if (session()->has('layanan_dipesan')) {
            return redirect()->route('transaksi.storeAfterKendaraan');
        }

        return redirect()->route('transaksi.storeAfterKendaraan');

    }

    
    public function show(Kendaraan $kendaraan)
    {
        if (!Auth::user()->can('view', $kendaraan)) {
            abort(403, 'Unauthorized action.');
        }
        return view('kendaraan.show', compact('kendaraan'));
    }

    
    public function edit(Kendaraan $kendaraan)
    {
        if (!Auth::user()->can('update', $kendaraan)) {
            abort(403, 'Unauthorized action.');
        }
        return view('kendaraan.edit', compact('kendaraan'));
    }

    
    public function update(Request $request, Kendaraan $kendaraan)
    {
        if (!Auth::user()->can('update', $kendaraan)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'jenis_kendaraan' => 'required|in:mobil,motor',
            'merk' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20|unique:kendaraans,plat_nomor,' . $kendaraan->id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            
            if ($kendaraan->foto) {
                Storage::disk('public')->delete($kendaraan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('kendaraan-photos', 'public');
        }

        $kendaraan->update($validated);

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil diperbarui');
    }

    
    public function destroy(Kendaraan $kendaraan)
    {
        if (!Auth::user()->can('delete', $kendaraan)) {
            abort(403, 'Unauthorized action.');
        }

        if ($kendaraan->foto) {
            Storage::disk('public')->delete($kendaraan->foto);
        }

        $kendaraan->delete();

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil dihapus');
    }
}
