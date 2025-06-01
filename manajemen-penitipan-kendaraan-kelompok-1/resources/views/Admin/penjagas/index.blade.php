@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Penjaga</h3>

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
            @foreach($penjagas as $penjaga)
            <tr>
                <td>{{ $penjaga->nama }}</td>
                <td>{{ $penjaga->email }}</td>
                <td>{{ $penjaga->no_hp }}</td>
                <td>
                    <a href="{{ route('admin.penjagas.show', $penjaga->id) }}" class="btn btn-sm btn-info">Detail</a>
                    <a href="{{ route('admin.penjagas.edit', $penjaga->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.penjagas.destroy', $penjaga->id) }}" method="POST" style="display:inline-block">
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