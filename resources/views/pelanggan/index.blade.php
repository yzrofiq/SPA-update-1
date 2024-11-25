@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Pelanggan</h1>

    <!-- Pencarian Pelanggan -->
    <div class="row mb-3">
        <div class="col-md-4">
        <form action="{{ route('pelanggans.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari pelanggan..." value="{{ request()->query('search') }}">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>
        <div class="col-md-8 text-end">
        <a href="{{ route('pelanggans.create') }}" class="btn btn-success">Tambah Pelanggan</a>
        </div>
    </div>

    <!-- Tabel Daftar Pelanggan -->
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Nomor Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
    @forelse ($pelanggans as $p)
        <tr>
            <td>{{ $p->nama }}</td>
            <td>{{ $p->alamat }}</td>
            <td>{{ $p->nomor_telepon }}</td>
            <td>
                <a href="{{ route('pelanggans.show', $p->id) }}" class="btn btn-info btn-sm">Lihat</a>
                <a href="{{ route('pelanggans.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('pelanggans.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">Tidak ada pelanggan yang ditemukan.</td>
        </tr>
    @endforelse
</tbody>

    </table>

    <!-- Pagination -->
    @if ($pelanggans->hasPages())
        <div class="d-flex justify-content-center">
            {{ $pelanggans->links() }}
        </div>
    @endif
</div>
@endsection
