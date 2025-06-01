@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Daftar Transaksi</h4>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('transaksis.create') }}" class="btn btn-primary mb-3">+ Tambah Transaksi</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Kendaraan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $index => $transaksi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $transaksi->pelanggan->name ?? '-' }}</td>
                        <td>{{ $transaksi->layanan->nama_layanan ?? '-' }}</td>
                        <td>{{ $transaksi->kendaraan->merk ?? '-' }}</td>
                        <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $transaksi->status === 'selesai' ? 'success' : 'warning' }}">
                                {{ ucfirst($transaksi->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('transaksis.edit', $transaksi->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('transaksis.destroy', $transaksi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
