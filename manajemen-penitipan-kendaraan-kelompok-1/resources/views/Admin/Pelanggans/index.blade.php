@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Pelanggan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelanggans as $pelanggan)
            <tr>
                <td>{{ $pelanggan->nama ?? old('nama') }}</td>
                <td>{{ $pelanggan->email }}</td>
                <td>{{ $pelanggan->no_hp }}</td>
                <td>
                    <a href="{{ route('admin.pelanggans.show', $pelanggan->id) }}" class="btn btn-sm btn-info">Detail</a>
                    <a href="{{ route('admin.pelanggans.edit', $pelanggan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.pelanggans.destroy', $pelanggan->id) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
