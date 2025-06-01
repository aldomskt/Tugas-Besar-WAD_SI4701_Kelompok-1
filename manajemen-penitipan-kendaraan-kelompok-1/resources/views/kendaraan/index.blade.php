@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Daftar Kendaraan') }}</h4>
                    <a href="{{ route('kendaraans.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>{{ __('Tambah Kendaraan') }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($kendaraans->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-car fa-4x text-muted mb-3"></i>
                            <p class="h4 text-muted">{{ __('Belum ada kendaraan yang terdaftar') }}</p>
                            <a href="{{ route('kendaraans.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i>{{ __('Tambah Kendaraan Sekarang') }}
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Merk</th>
                                        <th>Tipe</th>
                                        <th>Plat Nomor</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kendaraans as $index => $kendaraan)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $kendaraan->foto) }}" 
                                                     alt="Foto {{ $kendaraan->merk }}"
                                                     class="img-thumbnail"
                                                     style="max-width: 100px;">
                                            </td>
                                            <td>{{ $kendaraan->merk }}</td>
                                            <td>{{ $kendaraan->tipe }}</td>
                                            <td>{{ $kendaraan->plat_nomor }}</td>
                                            <td>
                                                <span class="badge bg-{{ $kendaraan->status === 'aktif' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($kendaraan->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('kendaraans.show', $kendaraan->id) }}" 
                                                       class="btn btn-info btn-sm text-white">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('kendaraans.edit', $kendaraan->id) }}" 
                                                       class="btn btn-warning btn-sm text-white">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('kendaraans.destroy', $kendaraan->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $kendaraans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 