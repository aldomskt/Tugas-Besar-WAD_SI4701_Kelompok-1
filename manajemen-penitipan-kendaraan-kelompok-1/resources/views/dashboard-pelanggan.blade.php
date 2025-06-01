@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Selamat datang, {{ Auth::user()->nama }}</h3>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Kendaraan Saya</h5>
                    <p>Data kendaraan yang kamu titipkan</p>
                    <a href="{{ route('kendaraans.index') }}" class="btn btn-primary">Lihat Kendaraan</a>
                </div>
            </div>
        </div>
    
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Layanan Tersedia</h5>
                    <p>Daftar layanan dari penjaga</p>
                    <a href="{{ route('layanan.index') }}" class="btn btn-primary">Lihat Layanan</a>
                </div>
            </div>
        </div>
    
        <div class="col-md-6 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Riwayat Transaksi</h5>
                    <p>Lihat status penitipan kendaraan</p>
                    <a href="{{ route('transaksis.index') }}" class="btn btn-primary">Lihat Transaksi</a>
                </div>
            </div>
        </div>
    
        <div class="col-md-6 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Profil Saya</h5>
                    <p>Perbarui data akun Anda</p>
                    <a href="{{ route('profile') }}" class="btn btn-primary">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
