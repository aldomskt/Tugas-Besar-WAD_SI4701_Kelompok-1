@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 mt-5">
                <div class="card-header">
                    <h4 class="mb-0">Pembayaran Layanan</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transaksi.prosesPembayaran') }}" id="formPembayaran">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Layanan</label>
                            <input type="text" class="form-control" value="{{ $layanan->nama_layanan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga per Hari</label>
                            <input type="text" class="form-control" id="harga_per_hari" value="{{ $layanan->harga_motor }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="durasi_penitipan" class="form-label">Durasi Penitipan (hari)</label>
                            <input type="number" name="durasi_penitipan" id="durasi_penitipan" class="form-control" min="1" max="{{ $layanan->durasi }}" value="{{ old('durasi_penitipan', isset($durasi_penitipan) ? $durasi_penitipan : 1) }}" required>
                            <small class="text-muted">Maksimal: {{ $layanan->durasi }} hari</small>
                        </div>
                        <div class="mb-3">
                            <label for="total" class="form-label">Total Pembayaran</label>
                            <input type="number" class="form-control" id="total" name="total" value="{{ old('total', isset($total) ? $total : '') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Bayar & Buat Transaksi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 