@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Detail Kendaraan') }}</h4>
                    <div>
                        <a href="{{ route('kendaraans.edit', $kendaraan->id) }}" class="btn btn-warning text-white me-2">
                            <i class="fas fa-edit me-2"></i>{{ __('Edit') }}
                        </a>
                        <form action="{{ route('kendaraans.destroy', $kendaraan->id) }}" 
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>{{ __('Hapus') }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if($kendaraan->foto)
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/' . $kendaraan->foto) }}" 
                                 alt="Foto {{ $kendaraan->merk }}"
                                 class="img-fluid rounded"
                                 style="max-height: 300px;">
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="detail-item">
                                <label class="text-muted mb-1">{{ __('Jenis Kendaraan') }}</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-{{ $kendaraan->jenis_kendaraan === 'motor' ? 'motorcycle' : 'car' }} fa-fw text-primary me-2"></i>
                                    <span class="fs-5">{{ ucfirst($kendaraan->jenis_kendaraan) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="detail-item">
                                <label class="text-muted mb-1">{{ __('Status') }}</label>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-{{ $kendaraan->status === 'aktif' ? 'success' : 'danger' }} fs-6">
                                        {{ ucfirst($kendaraan->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="detail-item">
                                <label class="text-muted mb-1">{{ __('Merk Kendaraan') }}</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tag fa-fw text-primary me-2"></i>
                                    <span class="fs-5">{{ $kendaraan->merk }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="detail-item">
                                <label class="text-muted mb-1">{{ __('Tipe Kendaraan') }}</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle fa-fw text-primary me-2"></i>
                                    <span class="fs-5">{{ $kendaraan->tipe }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="detail-item">
                                <label class="text-muted mb-1">{{ __('Plat Nomor') }}</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-id-card fa-fw text-primary me-2"></i>
                                    <span class="fs-5">{{ $kendaraan->plat_nomor }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="detail-item">
                                <label class="text-muted mb-1">{{ __('Tanggal Registrasi') }}</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar fa-fw text-primary me-2"></i>
                                    <span class="fs-5">{{ $kendaraan->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('kendaraans.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Kembali ke Daftar') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.detail-item label {
    font-size: 0.875rem;
    font-weight: 500;
}
.detail-item i {
    width: 20px;
}
</style>
@endsection 