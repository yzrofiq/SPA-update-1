@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Tagihan</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ url('tagihans/create') }}" class="btn btn-primary mb-3">Tambah Tagihan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah Tagihan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($tagihans as $tagihan)
            <tr>
                <td>{{ $tagihan->id }}</td>
                <td>{{ $tagihan->pelanggan->nama }}</td>
                <td>{{ $tagihan->bulan }}</td>
                <td>{{ $tagihan->tahun }}</td>
                <td>{{ number_format($tagihan->jumlah_tagihan, 2, ',', '.') }} IDR</td>
                <td>
    @if ($tagihan->status == 0)
        <span class="text-danger">Belum Lunas</span>
    @else
        <span class="text-success">Lunas</span>
    @endif
</td>

                <td>
                    <a href="{{ route('tagihans.edit', $tagihan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    
                    @if ($tagihan->status == 0)
                        <form action="{{ route('tagihans.updateStatus', $tagihan->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Tandai Lunas</button>
                        </form>
                    @else
                        <button class="btn btn-success btn-sm" disabled>Lunas</button>
                    @endif
                    
                    <form action="{{ route('tagihans.destroy', $tagihan->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this tagihan?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada tagihan yang ditemukan.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $tagihans->links() }}
</div>
@endsection
