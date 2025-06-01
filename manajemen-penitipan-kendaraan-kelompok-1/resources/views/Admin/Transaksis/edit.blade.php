@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Transaksi</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transaksis.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Layanan</label>
            <select name="layanan_id" class="form-control @error('layanan_id') is-invalid @enderror" required>
                @foreach($layanans as $layanan)
                    <option value="{{ $layanan->id }}" 
                        {{ (old('layanan_id', $transaksi->layanan_id) == $layanan->id) ? 'selected' : '' }}>
                        {{ $layanan->nama_layanan }}
                    </option>
                @endforeach
            </select>
            @error('layanan_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Kendaraan</label>
            <select name="kendaraan_id" class="form-control @error('kendaraan_id') is-invalid @enderror" required>
                @foreach($kendaraans as $kendaraan)
                    <option value="{{ $kendaraan->id }}" 
                        {{ (old('kendaraan_id', $transaksi->kendaraan_id) == $kendaraan->id) ? 'selected' : '' }}>
                        {{ $kendaraan->merk }} - {{ $kendaraan->plat_nomor }}
                    </option>
                @endforeach
            </select>
            @error('kendaraan_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Total (Rp)</label>
            <input type="number" name="total" class="form-control @error('total') is-invalid @enderror" 
                   value="{{ old('total', $transaksi->total) }}" required>
            @error('total')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror">
                @php
                    $statuses = ['pending', 'proses', 'selesai', 'batal'];
                @endphp
                @foreach($statuses as $status)
                    <option value="{{ $status }}" 
                        {{ (old('status', $transaksi->status) == $status) ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
