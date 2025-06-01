@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Riwayat Transaksi</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Kendaraan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $i => $transaksi)
                <tr>
                    <td>{{ $transaksis->firstItem() + $i }}</td>
                    <td>{{ $transaksi->created_at ? $transaksi->created_at->format('d M Y') : '-' }}</td>
                    <td>{{ $transaksi->pelanggan->nama ?? '-' }}</td>
                    <td>{{ $transaksi->layanan->nama_layanan ?? '-' }}</td>
                    <td>
                        {{ $transaksi->kendaraan->merk ?? '-' }} {{ $transaksi->kendaraan->tipe ?? '' }}<br>
                        <small>{{ $transaksi->kendaraan->plat_nomor ?? '' }}</small>
                    </td>
                    <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $transaksi->status === 'selesai' ? 'success' : ($transaksi->status === 'proses' ? 'info' : ($transaksi->status === 'pending' ? 'warning text-dark' : 'secondary')) }}">
                            {{ ucfirst($transaksi->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('transaksis.update', $transaksi->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm" style="width:auto; display:inline-block;">
                                <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="proses" {{ $transaksi->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="batal" {{ $transaksi->status == 'batal' ? 'selected' : '' }}>Batal</option>
                                <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </form>
                        <a href="{{ route('transaksis.show', $transaksi->id) }}" class="btn btn-info btn-sm mt-1" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection 