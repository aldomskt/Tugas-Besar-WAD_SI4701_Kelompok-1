@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Data Penjaga</h3>

    <form action="{{ route('admin.penjagas.update', $penjaga->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ $penjaga->nama }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $penjaga->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" value="{{ $penjaga->no_hp }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control">{{ $penjaga->alamat }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.penjagas.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection 