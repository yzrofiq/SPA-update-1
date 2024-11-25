@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Pembayaran</h1>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('pembayarans.create') }}" class="btn btn-primary mb-3">Tambah Pembayaran</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tagihan</th>
                    <th>Nama Pelanggan</th>
                    <th>Jumlah Bayar</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($pembayarans as $pembayaran)
                <tr>
                    <td>{{ $pembayaran->id }}</td>
                    <td>
                        @if($pembayaran->tagihan)
                            {{ $pembayaran->tagihan->id }}
                        @else
                            <span class="text-danger">Tagihan tidak ditemukan</span>
                        @endif
                    </td>
                    <td>
                        @if($pembayaran->tagihan && $pembayaran->tagihan->pelanggan)
                            {{ $pembayaran->tagihan->pelanggan->nama }}
                        @else
                            <span class="text-danger">Pelanggan tidak ditemukan</span>
                        @endif
                    </td>
                    <td>{{ number_format($pembayaran->jumlah_bayar, 2, ',', '.') }} IDR</td>
                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('pembayarans.edit', $pembayaran->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('pembayarans.destroy', $pembayaran->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada pembayaran yang ditemukan.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $pembayarans->links() }}
    </div>
@endsection
