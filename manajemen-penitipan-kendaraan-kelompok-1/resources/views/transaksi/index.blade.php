@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Riwayat Transaksi') }}</h4>
                    @auth
                    <a href="{{ route('layanan.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>{{ __('Buat Transaksi Baru') }}
                    </a>
                    @endauth
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($transaksis->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                            <p class="h4 text-muted">{{ __('Belum ada transaksi') }}</p>
                            <a href="{{ route('layanan.index') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i>{{ __('Buat Transaksi Sekarang') }}
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
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
                                            <td>{{ $transaksi->created_at->format('d M Y') }}</td>
                                            <td>
                                                <span class="d-block">{{ ucfirst($transaksi->layanan->jenis_kendaraan) }}</span>
                                                <small class="text-muted">{{ $transaksi->layanan->durasi }}</small>
                                            </td>
                                            <td>
                                                <span class="d-block">{{ $transaksi->kendaraan?->merk ?? '-' }} {{ $transaksi->kendaraan?->tipe ?? '' }}</span>
                                                <small class="text-muted">{{ $transaksi->kendaraan?->plat_nomor ?? '' }}</small>
                                            </td>

                                            <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $statusMap = [
                                                        'pending' => 'warning',
                                                        'proses' => 'info',
                                                        'selesai' => 'success',
                                                        'batal' => 'danger'
                                                    ];

                                                    $statusClass = $statusMap[$transaksi->status] ?? 'secondary';
                                                @endphp

                                                <span class="badge bg-{{ $statusClass }}">
                                                    {{ ucfirst($transaksi->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('transaksis.show', $transaksi->id) }}" class="btn btn-info btn-sm text-white">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(Auth::guard('admin')->check())
                                                        <form action="{{ route('admin.transaksis.destroy', $transaksi->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin hapus transaksi ini?');">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                        </form>
                                                        <form action="{{ route('admin.transaksis.update', $transaksi->id) }}" method="POST" style="display:inline-block; margin-left:5px;">
                                                            @csrf @method('PUT')
                                                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm" style="width:auto; display:inline-block;">
                                                                <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                                                <option value="proses" {{ $transaksi->status == 'proses' ? 'selected' : '' }}>Accepted</option>
                                                                <option value="batal" {{ $transaksi->status == 'batal' ? 'selected' : '' }}>Rejected</option>
                                                                <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Finished</option>
                                                            </select>
                                                        </form>
                                                        @if(Auth::guard('admin')->check() && $transaksi->status == 'selesai' && $transaksi->catatanPembayaran->isEmpty())
                                                            <a href="{{ route('admin.transaksis.catatan.create', $transaksi->id) }}" class="btn btn-success btn-sm" style="margin-left:5px;">
                                                                <i class="fas fa-receipt"></i> Catat Pembayaran
                                                            </a>
                                                        @endif
                                                    @else
                                                        @if($transaksi->status === 'pending')
                                                            <form action="{{ route('transaksis.destroy', $transaksi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $transaksis->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 