@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Catatan Pembayaran ke Penjaga</h3>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Penjaga</th>
                            <th>Layanan</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($catatanPembayaran as $i => $catatan)
                        <tr>
                            <td>{{ $catatanPembayaran->firstItem() + $i }}</td>
                            <td>{{ $catatan->tanggal }}</td>
                            <td>{{ $catatan->penjaga->nama ?? '-' }}</td>
                            <td>{{ $catatan->transaksi->layanan->nama_layanan ?? '-' }}</td>
                            <td>Rp {{ number_format($catatan->nominal, 0, ',', '.') }}</td>
                            <td>{{ $catatan->keterangan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada catatan pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $catatanPembayaran->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 