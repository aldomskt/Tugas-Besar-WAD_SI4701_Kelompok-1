@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard Admin') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h5>Selamat datang, {{ Auth::guard('admin')->user()->nama }}!</h5>

                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Kelola Penjaga</h5>
                                        <p class="card-text">Lihat dan kelola data penjaga</p>
                                        <a href="{{ route('admin.penjagas.index') }}" class="btn btn-primary">Kelola Penjaga</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Kelola Pelanggan</h5>
                                        <p class="card-text">Lihat dan kelola data pelanggan</p>
                                        <a href="{{ route('admin.pelanggans.index') }}" class="btn btn-primary">Kelola Pelanggan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Laporan Transaksi</h5>
                                        <p class="card-text">Lihat laporan transaksi</p>
                                        <a href="{{ route('transaksis.index') }}" class="btn btn-primary">Lihat Laporan</a>
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