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

    
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            
            $layanans = Layanan::all();
        } elseif (Auth::guard('penjaga')->check()) {
            
            $penjagaId = Auth::guard('penjaga')->id();
            $layanans = Layanan::where('penjaga_id', $penjagaId)->get();
        } else {
            
            $layanans = Layanan::where('status', 'aktif')->get();
        }

        return view('layanan.index', compact('layanans'));
    }

    
    public function create()
    {
        return view('layanan.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required',
            'deskripsi' => 'required',
            'harga_motor' => 'required|numeric',
            'harga_mobil' => 'required|numeric',
            'durasi_nilai' => 'required|numeric',
            'durasi_tipe' => 'required|in:hari,bulan',
            'jenis_kendaraan' => 'required|in:motor,mobil',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $totalHari = $request->durasi_tipe === 'bulan'
            ? $request->durasi_nilai * 30
            : $request->durasi_nilai;

        $hargaPerHari = $request->jenis_kendaraan === 'motor'
            ? $request->harga_motor
            : $request->harga_mobil;

        $totalHarga = $totalHari * $hargaPerHari;

        $layanan = new \App\Models\Layanan();
        $layanan->penjaga_id = auth()->guard('penjaga')->id();
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->deskripsi = $request->deskripsi;
        $layanan->harga_motor = $request->harga_motor;
        $layanan->harga_mobil = $request->harga_mobil;
        $layanan->durasi = $totalHari;
        $layanan->jenis_kendaraan = $request->jenis_kendaraan;
        $layanan->status = $request->status;
        $layanan->save();

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan');
    }

    
    public function show(Layanan $layanan)
    {
        return view('layanan.show', compact('layanan'));
    }

    
    public function edit(Layanan $layanan)
    {
        $this->authorize('update', $layanan);
        
        
        preg_match('/(\d+)\s+(\w+)/', $layanan->durasi, $matches);
        $layanan->durasi_nilai = $matches[1] ?? '';
        $layanan->durasi_tipe = $matches[2] ?? '';
        
        return view('layanan.edit', compact('layanan'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'jenis_kendaraan' => 'required',
            'harga_motor' => 'required|numeric',
            'harga_mobil' => 'required|numeric',
            'durasi_nilai' => 'required|numeric',
            'durasi_tipe' => 'required|in:hari,bulan',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $totalHari = $request->durasi_tipe === 'bulan'
            ? $request->durasi_nilai * 30
            : $request->durasi_nilai;

        $layanan = Layanan::where('penjaga_id', auth('penjaga')->id())->findOrFail($id);
        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
            'harga_motor' => $request->harga_motor,
            'harga_mobil' => $request->harga_mobil,
            'durasi' => $totalHari,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'status' => $request->status,
        ]);

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    
    public function destroy(Layanan $layanan)
    {
        $this->authorize('delete', $layanan);
        $layanan->delete();
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus');
    }
}
