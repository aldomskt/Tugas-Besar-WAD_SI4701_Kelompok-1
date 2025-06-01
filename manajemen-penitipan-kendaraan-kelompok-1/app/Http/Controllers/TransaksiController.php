<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Layanan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            
            if (Auth::guard('admin')->check() || Auth::check()) {
                return $next($request);
            }
            return redirect()->route('login');
        });
    }

    
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $transaksis = \App\Models\Transaksi::with(['layanan', 'kendaraan', 'pelanggan'])->latest()->paginate(10);
        } else {
            $transaksis = Auth::user()
                ->transaksis()
                ->with(['layanan', 'kendaraan'])
                ->latest()
                ->paginate(10);
        }
        return view('transaksi.index', compact('transaksis'));
    }

    
    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403);
        }

        $layanans = Layanan::all();
        $kendaraans = Kendaraan::all();

        return view('admin.transaksis.create', compact('layanans', 'kendaraans'));
    }

    
    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403);
        }

        $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'total' => 'required|numeric',
            'status' => 'required|in:pending,proses,selesai,batal',
        ]);

        Transaksi::create([
            'layanan_id' => $request->layanan_id,
            'kendaraan_id' => $request->kendaraan_id,
            'total' => $request->total,
            'status' => $request->status,
        ]);

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    
    public function show(Transaksi $transaksi)
    {
        $this->authorize('view', $transaksi);
        return view('transaksi.show', compact('transaksi'));
    }

    
    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403);
        }

        $transaksi = Transaksi::findOrFail($id);
        $layanans = Layanan::all();
        $kendaraans = Kendaraan::all();

        return view('admin.transaksis.edit', compact('transaksi', 'layanans', 'kendaraans'));
    }

    
    public function update(Request $request, $id)
    {
        if (Auth::guard('admin')->check()) {
            $transaksi = \App\Models\Transaksi::findOrFail($id);
            if ($request->has('status')) {
                $transaksi->status = $request->status;
                $transaksi->save();
                return redirect()->route('admin.transaksis.index')->with('success', 'Status transaksi berhasil diubah.');
            }
            
            $transaksi->update($request->all());
            return redirect()->route('admin.transaksis.index')->with('success', 'Transaksi berhasil diperbarui.');
        }
        
        if (Auth::guard('penjaga')->check()) {
            $penjaga = Auth::guard('penjaga')->user();
            $transaksi = \App\Models\Transaksi::whereHas('layanan', function($q) use ($penjaga) {
                $q->where('penjaga_id', $penjaga->id);
            })->findOrFail($id);
            $request->validate([
                'status' => 'required|in:pending,proses,selesai,batal',
            ]);
            $transaksi->status = $request->status;
            $transaksi->save();
            return redirect()->route('penjaga.riwayatTransaksi')->with('success', 'Status transaksi berhasil diubah.');
        }
        $transaksi = Transaksi::findOrFail($id);
        $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'total' => 'required|numeric',
            'status' => 'required|in:pending,proses,selesai,batal',
        ]);
        $transaksi->update([
            'layanan_id' => $request->layanan_id,
            'kendaraan_id' => $request->kendaraan_id,
            'total' => $request->total,
            'status' => $request->status,
        ]);
        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    
    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403);
        }

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil dihapus');
    }

    
    public function formTambahKendaraan($id)
    {
        $pelangganId = Auth::id();
        $kendaraan = \App\Models\Kendaraan::where('pelanggan_id', $pelangganId)->latest()->first();
        session(['layanan_dipesan' => $id]);
        if ($kendaraan) {
            
            return redirect()->route('transaksi.pembayaran');
        } else {
            
            return redirect()->route('kendaraans.create');
        }
    }

    
    public function storeAfterKendaraan()
    {
        $layananId = session('layanan_dipesan');
        $pelangganId = Auth::id();

        if (!$layananId) {
            return redirect()->route('kendaraans.index')->with('error', 'Layanan tidak ditemukan.');
        }

        $layanan = Layanan::findOrFail($layananId);
        $kendaraan = Kendaraan::where('pelanggan_id', $pelangganId)->latest()->first();

        Transaksi::create([
            'pelanggan_id' => $pelangganId,
            'layanan_id' => $layananId,
            'kendaraan_id' => $kendaraan->id,
            'total' => $layanan->harga,
            'jumlah_pembayaran' => 0, 
            'status' => 'Menunggu Konfirmasi',
        ]);

        session()->forget('layanan_dipesan');

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    
    public function showPembayaran()
    {
        $layananId = session('layanan_dipesan');
        if (!$layananId) {
            return redirect()->route('layanan.index')->with('error', 'Layanan tidak ditemukan.');
        }
        $layanan = \App\Models\Layanan::findOrFail($layananId);
        return view('transaksi.pembayaran', compact('layanan'));
    }

    
    public function prosesPembayaran(Request $request)
    {
        $layananId = session('layanan_dipesan');
        $pelangganId = Auth::id();
        $kendaraan = \App\Models\Kendaraan::where('pelanggan_id', $pelangganId)->latest()->first();
        $layanan = \App\Models\Layanan::findOrFail($layananId);

        if (!$kendaraan) {
            return redirect()->route('kendaraans.create')->with('error', 'Anda harus mendaftarkan kendaraan terlebih dahulu.');
        }

        
        $request->validate([
            'durasi_penitipan' => 'required|integer|min:1|max:' . $layanan->durasi,
        ]);
        $durasiPenitipan = $request->durasi_penitipan;
        $jumlahPembayaran = $request->total; 

        
        $request->validate([
            'total' => 'required|numeric|min:0',
        ]);

        \App\Models\Transaksi::create([
            'pelanggan_id' => $pelangganId,
            'layanan_id' => $layananId,
            'kendaraan_id' => $kendaraan->id,
            'total' => $jumlahPembayaran,
            'jumlah_pembayaran' => $jumlahPembayaran,
            'durasi_penitipan' => $durasiPenitipan,
            'status' => 'Menunggu Konfirmasi',
        ]);

        session()->forget('layanan_dipesan');
        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function createCatatanPembayaran($id)
    {
        if (!\Auth::guard('admin')->check()) abort(403);
        $transaksi = \App\Models\Transaksi::with('layanan')->findOrFail($id);
        if ($transaksi->status !== 'selesai') {
            return redirect()->back()->with('error', 'Transaksi belum selesai.');
        }
        $penjaga = $transaksi->layanan->penjaga;
        return view('admin.transaksis.catatan.create', compact('transaksi', 'penjaga'));
    }

    public function storeCatatanPembayaran(Request $request, $id)
    {
        if (!\Auth::guard('admin')->check()) abort(403);
        $transaksi = \App\Models\Transaksi::with('layanan')->findOrFail($id);
        if ($transaksi->status !== 'selesai') {
            return redirect()->back()->with('error', 'Transaksi belum selesai.');
        }
        $penjaga = $transaksi->layanan->penjaga;
        $request->validate([
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);
        \App\Models\CatatanPembayaran::create([
            'transaksi_id' => $transaksi->id,
            'penjaga_id' => $penjaga->id,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);
        return redirect()->route('admin.transaksis.index')->with('success', 'Catatan pembayaran berhasil dicatat.');
    }

    public function riwayatPenjaga()
    {
        $penjaga = Auth::guard('penjaga')->user();
        $transaksis = \App\Models\Transaksi::whereHas('layanan', function($query) use ($penjaga) {
            $query->where('penjaga_id', $penjaga->id);
        })->with(['layanan', 'kendaraan', 'pelanggan'])->latest()->paginate(10);
        return view('penjaga.riwayat-transaksi', compact('transaksis'));
    }

    public function catatanIndex()
    {
        if (!\Auth::guard('admin')->check()) abort(403, 'Bukan admin');
        $catatanPembayaran = \App\Models\CatatanPembayaran::with(['transaksi.layanan', 'penjaga'])->latest()->paginate(10);
        return view('admin.transaksis.catatan.index', compact('catatanPembayaran'));
    }
}

