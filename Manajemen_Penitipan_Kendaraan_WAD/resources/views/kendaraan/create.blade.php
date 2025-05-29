@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Tambah Kendaraan Baru') }}</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('kendaraans.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="jenis_kendaraan" class="form-label">{{ __('Jenis Kendaraan') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-car"></i>
                                </span>
                                <select id="jenis_kendaraan" 
                                        class="form-select form-select-lg @error('jenis_kendaraan') is-invalid @enderror" 
                                        name="jenis_kendaraan" required>
                                    <option value="" selected disabled>Pilih Jenis Kendaraan</option>
                                    <option value="mobil" {{ old('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                                    <option value="motor" {{ old('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>Motor</option>
                                </select>
                            </div>
                            @error('jenis_kendaraan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="merk" class="form-label">{{ __('Merk Kendaraan') }}</label>
                            <div class="input-group">
                                <span class="input-group-text vehicle-icon">
                                    <i class="fas fa-car"></i>
                                </span>
                                <input id="merk" type="text" 
                                       class="form-control form-control-lg @error('merk') is-invalid @enderror" 
                                       name="merk" value="{{ old('merk') }}" required 
                                       placeholder="Contoh: Toyota/Honda">
                            </div>
                            @error('merk')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tipe" class="form-label">{{ __('Tipe Kendaraan') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                <input id="tipe" type="text" 
                                       class="form-control form-control-lg @error('tipe') is-invalid @enderror" 
                                       name="tipe" value="{{ old('tipe') }}" required 
                                       placeholder="Contoh: Avanza/Beat">
                            </div>
                            @error('tipe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="plat_nomor" class="form-label">{{ __('Plat Nomor') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <input id="plat_nomor" type="text" 
                                       class="form-control form-control-lg @error('plat_nomor') is-invalid @enderror" 
                                       name="plat_nomor" value="{{ old('plat_nomor') }}" required 
                                       placeholder="Contoh: B 1234 CD">
                            </div>
                            @error('plat_nomor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="foto" class="form-label">{{ __('Foto Kendaraan') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-camera"></i>
                                </span>
                                <input id="foto" type="file" 
                                       class="form-control form-control-lg @error('foto') is-invalid @enderror" 
                                       name="foto" required accept="image/*">
                            </div>
                            <small class="text-muted">Format: JPG, JPEG, PNG (Max: 2MB)</small>
                            @error('foto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>{{ __('Simpan Kendaraan') }}
                            </button>
                            <a href="{{ route('kendaraans.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Kembali') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('jenis_kendaraan').addEventListener('change', function() {
    const vehicleIcon = document.querySelector('.vehicle-icon i');
    if (this.value === 'motor') {
        vehicleIcon.classList.remove('fa-car');
        vehicleIcon.classList.add('fa-motorcycle');
    } else {
        vehicleIcon.classList.remove('fa-motorcycle');
        vehicleIcon.classList.add('fa-car');
    }
});
</script>
@endpush 