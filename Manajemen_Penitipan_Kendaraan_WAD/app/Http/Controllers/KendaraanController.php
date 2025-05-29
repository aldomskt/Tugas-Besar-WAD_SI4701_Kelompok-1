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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kendaraans = Auth::user()->kendaraans()->paginate(10);
        return view('kendaraan.index', compact('kendaraans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kendaraan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kendaraan $kendaraan)
    {
        if (!Auth::user()->can('view', $kendaraan)) {
            abort(403, 'Unauthorized action.');
        }
        return view('kendaraan.show', compact('kendaraan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kendaraan $kendaraan)
    {
        if (!Auth::user()->can('update', $kendaraan)) {
            abort(403, 'Unauthorized action.');
        }
        return view('kendaraan.edit', compact('kendaraan'));
    }

    /**
     * Update the specified resource in storage.
     */
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
            // Delete old photo
            if ($kendaraan->foto) {
                Storage::disk('public')->delete($kendaraan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('kendaraan-photos', 'public');
        }

        $kendaraan->update($validated);

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
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
