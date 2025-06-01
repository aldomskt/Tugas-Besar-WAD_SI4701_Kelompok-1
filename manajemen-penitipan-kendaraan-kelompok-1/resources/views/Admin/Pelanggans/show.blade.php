@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Pelanggan</h3>

    <div class="mb-3">
        <strong>Nama:</strong> {{ $pelanggan->name }}
    </div>

    <div class="mb-3">
        <strong>Email:</strong> {{ $pelanggan->email }}
    </div>

    <div class="mb-3">
        <strong>No HP:</strong> {{ $pelanggan->no_hp }}
    </div>

    <div class="mb-3">
        <strong>Alamat:</strong> {{ $pelanggan->alamat }}
    </div>

    <a href="{{ route('admin.pelanggans.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
