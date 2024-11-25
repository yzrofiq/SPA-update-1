@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Pelanggan</h1>
        <p><strong>Nama:</strong> {{ $pelanggan->nama }}</p>
        <p><strong>Alamat:</strong> {{ $pelanggan->alamat }}</p>
        <p><strong>Nomor Telepon:</strong> {{ $pelanggan->nomor_telepon }}</p>
        <h2>Tagihan:</h2>
        <ul>
            @foreach ($tagihans as $tagihan)
                <li>{{ $tagihan->bulan }} {{ $tagihan->tahun }} - Rp {{ number_format($tagihan->jumlah_tagihan, 2) }} - {{ $tagihan->status ? 'Lunas' : 'Belum Bayar' }}</li>
            @endforeach
        </ul>
        <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
