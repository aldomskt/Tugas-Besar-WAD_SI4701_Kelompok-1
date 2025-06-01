@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Catat Pembayaran ke Penjaga</h3>
    <div class="card mb-4">
        <div class="card-body">
            <strong>Transaksi ID:</strong> {{ $transaksi->id }}<br>
            <strong>Layanan:</strong> {{ $transaksi->layanan->nama_layanan ?? '-' }}<br>
            <strong>Penjaga:</strong> {{ $penjaga->nama }}<br>
            <strong>Total Transaksi:</strong> Rp {{ number_format($transaksi->total, 0, ',', '.') }}<br>
        </div>
    </div>
    <form action="{{ route('admin.transaksis.catatan.store', $transaksi->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nominal Pembayaran</label>
            <input type="number" name="nominal" class="form-control" required min="0" value="{{ old('nominal', $transaksi->total) }}">
        </div>
        <div class="mb-3">
            <label>Tanggal Pembayaran</label>
            <input type="date" name="tanggal" class="form-control" required value="{{ old('tanggal', date('Y-m-d')) }}">
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Catat Pembayaran</button>
        <a href="{{ route('admin.transaksis.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection 