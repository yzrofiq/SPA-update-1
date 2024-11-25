@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pembayaran</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pembayarans.update', $pembayaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="pelanggan_id">Pelanggan</label>
            <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                @foreach ($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id }}" {{ $pembayaran->tagihan->pelanggan_id == $pelanggan->id ? 'selected' : '' }}>{{ $pelanggan->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tagihan_id">Tagihan</label>
            <select name="tagihan_id" id="tagihan_id" class="form-control" required>
                @foreach ($tagihans as $tagihan)
                    <option value="{{ $tagihan->id }}" {{ $pembayaran->tagihan_id == $tagihan->id ? 'selected' : '' }}>ID: {{ $tagihan->id }} - Bulan: {{ $tagihan->bulan }} Tahun: {{ $tagihan->tahun }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
            <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control" value="{{ $pembayaran->tanggal_pembayaran }}" required>
        </div>
        <div class="form-group">
            <label for="jumlah_bayar">Jumlah Bayar</label>
            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" step="0.01" value="{{ $pembayaran->jumlah_bayar }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Pembayaran</button>
    </form>

    <form action="{{ route('pembayarans.destroy', $pembayaran->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3">Hapus Pembayaran</button>
    </form>
</div>
@endsection
