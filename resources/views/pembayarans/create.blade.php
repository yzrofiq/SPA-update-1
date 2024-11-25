@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Pembayaran</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pembayarans.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="pelanggan_id">Pelanggan</label>
            <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                <option value="">-- Pilih Pelanggan --</option>
                @foreach ($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tagihan_id">Tagihan</label>
            <select name="tagihan_id" id="tagihan_id" class="form-control" required>
                <option value="">-- Pilih Tagihan --</option>
                @foreach ($tagihans as $tagihan)
                    <option value="{{ $tagihan->id }}">ID: {{ $tagihan->id }} - Bulan: {{ $tagihan->bulan }} Tahun: {{ $tagihan->tahun }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
            <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jumlah_bayar">Jumlah Bayar</label>
            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
    </form>
</div>
@endsection
