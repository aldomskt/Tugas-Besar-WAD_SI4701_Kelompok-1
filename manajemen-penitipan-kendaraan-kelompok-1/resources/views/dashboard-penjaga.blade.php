@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Selamat datang, {{ Auth::guard('penjaga')->user()->nama }}</h3>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Layanan Saya</h5>
                    <p>Kelola layanan penitipan yang kamu tawarkan</p>
                    <a href="{{ route('layanan.index') }}" class="btn btn-primary">Kelola Layanan</a>
                </div>
            </div>
        </div>
    
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Profil Penjaga</h5>
                    <p>Perbarui data diri kamu</p>
                    <a href="{{ route('penjaga.profile') }}" class="btn btn-primary">Edit Profil</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Riwayat Transaksi</h5>
                    <p>Lihat riwayat transaksi layanan Anda</p>
                    <a href="{{ route('penjaga.riwayatTransaksi') }}" class="btn btn-success">Riwayat Transaksi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
