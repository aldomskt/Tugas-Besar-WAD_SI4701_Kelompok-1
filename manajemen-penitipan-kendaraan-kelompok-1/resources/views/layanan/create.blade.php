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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('layanan.store') }}" id="layananForm">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_layanan" class="form-label">Nama Layanan</label>
                            <input type="text" name="nama_layanan" class="form-control" value="{{ old('nama_layanan') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="harga_motor" class="form-label">Harga per Hari (Motor)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_motor" class="form-control" value="{{ old('harga_motor') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="harga_mobil" class="form-label">Harga per Hari (Mobil)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_mobil" class="form-control" value="{{ old('harga_mobil') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="durasi_nilai" class="form-label">Durasi</label>
                            <div class="input-group">
                                <input type="number" name="durasi_nilai" class="form-control" value="{{ old('durasi_nilai') }}" min="1" required>
                                <select name="durasi_tipe" class="form-select" required>
                                    <option value="hari" {{ old('durasi_tipe') == 'hari' ? 'selected' : '' }}>Hari</option>
                                    <option value="bulan" {{ old('durasi_tipe') == 'bulan' ? 'selected' : '' }}>Bulan</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                            <select name="jenis_kendaraan" class="form-select" required>
                                <option value="">Pilih</option>
                                <option value="motor" {{ old('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>Motor</option>
                                <option value="mobil" {{ old('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('layanan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Simpan Layanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
