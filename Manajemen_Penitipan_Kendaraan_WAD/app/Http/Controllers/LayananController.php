<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:penjaga')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $layanans = Layanan::with('penjaga')->get();
        return view('layanan.index', compact('layanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'jenis_kendaraan' => 'required|string|in:motor,mobil',
            'harga_motor' => 'required|integer|min:0',
            'harga_mobil' => 'required|integer|min:0',
            'durasi_nilai' => 'required|integer|min:1',
            'durasi_tipe' => 'required|string|in:hari,bulan',
            'deskripsi' => 'required|string',
            'status' => 'required|string|in:aktif,nonaktif'
        ]);

        // Calculate total days
        $totalHari = $validated['durasi_nilai'];
        if ($validated['durasi_tipe'] === 'bulan') {
            $totalHari *= 30; // Asumsi 1 bulan = 30 hari
        }

        $layanan = new Layanan([
            'nama_layanan' => $validated['nama_layanan'],
            'jenis_kendaraan' => $validated['jenis_kendaraan'],
            'harga_motor' => $validated['harga_motor'],
            'harga_mobil' => $validated['harga_mobil'],
            'durasi' => $validated['durasi_nilai'] . ' ' . $validated['durasi_tipe'],
            'deskripsi' => $validated['deskripsi'],
            'status' => $validated['status']
        ]);

        Auth::guard('penjaga')->user()->layanans()->save($layanan);

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan)
    {
        return view('layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan)
    {
        $this->authorize('update', $layanan);
        
        // Split duration into value and type
        preg_match('/(\d+)\s+(\w+)/', $layanan->durasi, $matches);
        $layanan->durasi_nilai = $matches[1] ?? '';
        $layanan->durasi_tipe = $matches[2] ?? '';
        
        return view('layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan)
    {
        $this->authorize('update', $layanan);

        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'jenis_kendaraan' => 'required|string|in:motor,mobil',
            'harga_motor' => 'required|integer|min:0',
            'harga_mobil' => 'required|integer|min:0',
            'durasi_nilai' => 'required|integer|min:1',
            'durasi_tipe' => 'required|string|in:hari,bulan',
            'deskripsi' => 'required|string',
            'status' => 'required|string|in:aktif,nonaktif'
        ]);

        // Calculate total days
        $totalHari = $validated['durasi_nilai'];
        if ($validated['durasi_tipe'] === 'bulan') {
            $totalHari *= 30; // Asumsi 1 bulan = 30 hari
        }

        $layanan->update([
            'nama_layanan' => $validated['nama_layanan'],
            'jenis_kendaraan' => $validated['jenis_kendaraan'],
            'harga_motor' => $validated['harga_motor'],
            'harga_mobil' => $validated['harga_mobil'],
            'durasi' => $validated['durasi_nilai'] . ' ' . $validated['durasi_tipe'],
            'deskripsi' => $validated['deskripsi'],
            'status' => $validated['status']
        ]);

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        $this->authorize('delete', $layanan);
        $layanan->delete();
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus');
    }
}
