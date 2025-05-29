<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
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
        $transaksis = Auth::user()->transaksis()->with('layanan')->get();
        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $layanans = Layanan::all();
        return view('transaksi.create', compact('layanans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
        ]);

        $layanan = Layanan::findOrFail($validated['layanan_id']);
        
        $transaksi = new Transaksi([
            'layanan_id' => $layanan->id,
            'jumlah_pembayaran' => $layanan->harga,
            'status_pembayaran' => 'pending'
        ]);

        Auth::user()->transaksis()->save($transaksi);

        return redirect()->route('transaksis.index')->with('success', 'Transaction created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        $this->authorize('view', $transaksi);
        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $this->authorize('update', $transaksi);
        $layanans = Layanan::all();
        return view('transaksi.edit', compact('transaksi', 'layanans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $this->authorize('update', $transaksi);

        if ($transaksi->status_pembayaran === 'lunas') {
            return back()->withErrors(['error' => 'Cannot update a completed transaction']);
        }

        $validated = $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
        ]);

        $layanan = Layanan::findOrFail($validated['layanan_id']);
        
        $transaksi->update([
            'layanan_id' => $layanan->id,
            'jumlah_pembayaran' => $layanan->harga
        ]);

        return redirect()->route('transaksis.index')->with('success', 'Transaction updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $this->authorize('delete', $transaksi);

        if ($transaksi->status_pembayaran === 'lunas') {
            return back()->withErrors(['error' => 'Cannot delete a completed transaction']);
        }

        $transaksi->delete();
        return redirect()->route('transaksis.index')->with('success', 'Transaction cancelled successfully');
    }
}
