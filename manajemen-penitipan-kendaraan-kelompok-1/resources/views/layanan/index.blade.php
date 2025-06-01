@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Daftar Layanan') }}</h5>
                    @if(Auth::guard('penjaga')->check())
                        <a href="{{ route('layanan.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>{{ __('Tambah Layanan') }}
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($layanans->isEmpty())
                        <div class="text-center py-5">
                            <h4>{{ __('Belum ada layanan') }}</h4>
                            <p class="text-muted">{{ __('Mulai dengan menambahkan layanan baru') }}</p>
                            @if(Auth::guard('penjaga')->check())
                                <a href="{{ route('layanan.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus me-2"></i>{{ __('Tambah Layanan') }}
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Nama Layanan') }}</th>
                                        <th>{{ __('Deskripsi') }}</th>
                                        <th>{{ __('Harga Motor') }}</th>
                                        <th>{{ __('Harga Mobil') }}</th>
                                        <th>{{ __('Durasi') }}</th>
                                        <th>{{ __('Jenis Kendaraan') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($layanans as $layanan)
                                        <tr>
                                            <td>{{ $layanan->nama_layanan }}</td>
                                            <td>{{ Str::limit($layanan->deskripsi, 50) }}</td>
                                            <td>Rp {{ number_format($layanan->harga_motor ?? 0, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($layanan->harga_mobil ?? 0, 0, ',', '.') }}</td>
                                            <td>{{ $layanan->durasi }}</td>
                                            <td>{{ ucfirst($layanan->jenis_kendaraan) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $layanan->status === 'aktif' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($layanan->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if(Auth::guard('penjaga')->check())
                                                    <a href="{{ route('layanan.edit', $layanan->id) }}"
                                                       class="btn btn-sm btn-warning text-white me-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('layanan.destroy', $layanan->id) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @elseif(Auth::check())
                                                    <a href="{{ route('layanan.pesan', $layanan->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-cart-plus"></i> Pesan
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

