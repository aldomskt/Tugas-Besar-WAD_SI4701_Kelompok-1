@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard Penjaga') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h5>Selamat datang, {{ Auth::guard('penjaga')->user()->nama }}!</h5>

                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Layanan Saya</h5>
                                        <p class="card-text">Kelola layanan yang Anda tawarkan</p>
                                        <a href="{{ route('layanan.index') }}" class="btn btn-primary">Kelola Layanan</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Transaksi Masuk</h5>
                                        <p class="card-text">Lihat dan kelola transaksi dari pelanggan</p>
                                        <a href="{{ route('transaksis.index') }}" class="btn btn-primary">Lihat Transaksi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Profil Saya</h5>
                                        <p class="card-text">Kelola informasi akun Anda</p>
                                        <a href="{{ route('penjaga.profile') }}" class="btn btn-primary">Edit Profil</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
