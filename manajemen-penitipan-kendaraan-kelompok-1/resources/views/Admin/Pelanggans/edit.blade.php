@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Data Pelanggan</h3>

    <form action="{{ route('admin.pelanggans.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ $pelanggan->nama }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $pelanggan->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" value="{{ $pelanggan->no_hp }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control">{{ $pelanggan->alamat }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.pelanggans.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
