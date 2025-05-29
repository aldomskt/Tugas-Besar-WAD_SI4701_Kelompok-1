@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Tambah Layanan Baru') }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('layanan.store') }}" id="layananForm">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_layanan" class="form-label">{{ __('Nama Layanan') }}</label>
                            <input id="nama_layanan" type="text" 
                                   class="form-control @error('nama_layanan') is-invalid @enderror" 
                                   name="nama_layanan" value="{{ old('nama_layanan') }}" 
                                   required autofocus>
                            @error('nama_layanan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">{{ __('Deskripsi') }}</label>
                            <textarea id="deskripsi" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      name="deskripsi" rows="4" 
                                      required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Harga per Hari') }}</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="harga_motor" class="form-label">{{ __('Motor') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input id="harga_motor" type="number" 
                                               class="form-control @error('harga_motor') is-invalid @enderror" 
                                               name="harga_motor" value="{{ old('harga_motor') }}" 
                                               required min="0" onchange="updateTotalHarga()">
                                    </div>
                                    @error('harga_motor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="harga_mobil" class="form-label">{{ __('Mobil') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input id="harga_mobil" type="number" 
                                               class="form-control @error('harga_mobil') is-invalid @enderror" 
                                               name="harga_mobil" value="{{ old('harga_mobil') }}" 
                                               required min="0" onchange="updateTotalHarga()">
                                    </div>
                                    @error('harga_mobil')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="durasi" class="form-label">{{ __('Durasi') }}</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input id="durasi_nilai" type="number" 
                                           class="form-control @error('durasi_nilai') is-invalid @enderror" 
                                           name="durasi_nilai" value="{{ old('durasi_nilai') }}" 
                                           required min="1" onchange="updateTotalHarga()">
                                    @error('durasi_nilai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <select id="durasi_tipe" 
                                            class="form-select @error('durasi_tipe') is-invalid @enderror" 
                                            name="durasi_tipe" required onchange="updateTotalHarga()">
                                        <option value="">{{ __('Pilih Satuan Waktu') }}</option>
                                        <option value="hari" {{ old('durasi_tipe') == 'hari' ? 'selected' : '' }}>
                                            {{ __('Hari') }}
                                        </option>
                                        <option value="bulan" {{ old('durasi_tipe') == 'bulan' ? 'selected' : '' }}>
                                            {{ __('Bulan') }}
                                        </option>
                                    </select>
                                    @error('durasi_tipe')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kendaraan" class="form-label">{{ __('Jenis Kendaraan') }}</label>
                            <select id="jenis_kendaraan" 
                                    class="form-select @error('jenis_kendaraan') is-invalid @enderror" 
                                    name="jenis_kendaraan" required onchange="updateTotalHarga()">
                                <option value="">{{ __('Pilih Jenis Kendaraan') }}</option>
                                <option value="motor" {{ old('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>
                                    {{ __('Motor') }}
                                </option>
                                <option value="mobil" {{ old('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>
                                    {{ __('Mobil') }}
                                </option>
                            </select>
                            @error('jenis_kendaraan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Total Harga') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="total_harga" readonly>
                            </div>
                            <small class="form-text text-muted">Total harga akan dihitung otomatis berdasarkan jenis kendaraan dan durasi</small>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <select id="status" 
                                    class="form-select @error('status') is-invalid @enderror" 
                                    name="status" required>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>
                                    {{ __('Aktif') }}
                                </option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                    {{ __('Nonaktif') }}
                                </option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('layanan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Kembali') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Simpan Layanan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateTotalHarga() {
    const jenis = document.getElementById('jenis_kendaraan').value;
    const durasi = parseInt(document.getElementById('durasi_nilai').value) || 0;
    const tipe = document.getElementById('durasi_tipe').value;
    const hargaMotor = parseInt(document.getElementById('harga_motor').value) || 0;
    const hargaMobil = parseInt(document.getElementById('harga_mobil').value) || 0;
    
    let totalHari = durasi;
    if (tipe === 'bulan') {
        totalHari = durasi * 30; // Asumsi 1 bulan = 30 hari
    }
    
    let hargaPerHari = 0;
    if (jenis === 'motor') {
        hargaPerHari = hargaMotor;
    } else if (jenis === 'mobil') {
        hargaPerHari = hargaMobil;
    }
    
    const totalHarga = totalHari * hargaPerHari;
    document.getElementById('total_harga').value = totalHarga.toLocaleString('id-ID');
}

// Add event listeners to all relevant form fields
document.addEventListener('DOMContentLoaded', function() {
    const fields = ['jenis_kendaraan', 'durasi_nilai', 'durasi_tipe', 'harga_motor', 'harga_mobil'];
    fields.forEach(field => {
        document.getElementById(field).addEventListener('change', updateTotalHarga);
        document.getElementById(field).addEventListener('input', updateTotalHarga);
    });
});
</script>
@endpush

@endsection 