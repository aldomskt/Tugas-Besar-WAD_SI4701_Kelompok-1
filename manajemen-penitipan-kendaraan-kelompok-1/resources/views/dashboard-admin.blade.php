@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Selamat datang, {{ Auth::guard('admin')->user()->nama }}</h3>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Kelola Pelanggan</h5>
                    <p>Data pengguna sebagai pelanggan</p>
                    <a href="{{ route('admin.pelanggans.index') }}" class="btn btn-primary">Lihat Pelanggan</a>
                </div>
            </div>
        </div>
    
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Kelola Penjaga</h5>
                    <p>Data penjaga kendaraan yang tersedia</p>
                    <a href="{{ route('admin.penjagas.index') }}" class="btn btn-primary">Lihat Penjaga</a>
                </div>
            </div>
        </div>
    
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Layanan & Transaksi</h5>
                    <p>Lihat transaksi yang sedang berjalan</p>
                    <a href="{{ route('layanan.index') }}" class="btn btn-primary">Lihat Layanan</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Lihat Transaksi</h5>
                    <p>Lihat semua transaksi penitipan kendaraan</p>
                    <a href="{{ route('admin.transaksis.index') }}" class="btn btn-primary">Lihat Transaksi</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Catat Transaksi</h5>
                    <p>Catat transaksi pembayaran ke penjaga untuk transaksi yang sudah selesai</p>
                    <a href="{{ route('admin.transaksis.index') }}#catat-pembayaran" class="btn btn-success">Catat Transaksi</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Lihat Catatan Pembayaran</h5>
                    <p>Lihat semua catatan pembayaran ke penjaga yang sudah dicatat admin</p>
                    <a href="{{ route('admin.transaksis.catatan.index') }}" class="btn btn-info">Lihat Catatan Pembayaran</a>
                </div>
            </div>
        </div>
    </div>

    @if(isset($transaksiSelesai) && $transaksiSelesai->count())
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Transaksi Selesai Belum Dicatat</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Layanan</th>
                                    <th>Kendaraan</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiSelesai as $i => $transaksi)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $transaksi->created_at->format('d M Y') }}</td>
                                    <td>{{ $transaksi->layanan->nama_layanan ?? '-' }}</td>
                                    <td>{{ $transaksi->kendaraan?->merk ?? '-' }} {{ $transaksi->kendaraan?->tipe ?? '' }}<br><small>{{ $transaksi->kendaraan?->plat_nomor ?? '' }}</small></td>
                                    <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.transaksis.catatan.create', $transaksi->id) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-receipt"></i> Catat Transaksi
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
