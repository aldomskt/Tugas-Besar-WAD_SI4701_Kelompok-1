<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $transaksiSelesai = \App\Models\Transaksi::with(['layanan', 'kendaraan', 'catatanPembayaran'])
                ->where('status', 'selesai')
                ->whereDoesntHave('catatanPembayaran')
                ->latest()
                ->take(10)
                ->get();
            return view('dashboard-admin', compact('transaksiSelesai'));
        }

        if (Auth::guard('penjaga')->check()) {
            return view('dashboard-penjaga'); 
        }

        if (Auth::check()) {
            return view('dashboard-pelanggan'); 
        }

        return view('auth.login');
    }
}
