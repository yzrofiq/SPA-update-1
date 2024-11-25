@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Tagihan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tagihans.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="pelanggan_id">Pelanggan</label>
            <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                @foreach ($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                        {{ $pelanggan->nama }}
                    </option>
                @endforeach
            </select>
            @error('pelanggan_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="bulan">Bulan</label>
            <input type="number" name="bulan" id="bulan" class="form-control" value="{{ old('bulan') }}" min="1" max="12" required>
            @error('bulan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tahun">Tahun</label>
            <input type="number" name="tahun" id="tahun" class="form-control" value="{{ old('tahun') }}" min="2000" max="{{ date('Y') }}" required>
            @error('tahun')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="jumlah_tagihan">Jumlah Tagihan</label>
            <input type="number" name="jumlah_tagihan" id="jumlah_tagihan" class="form-control" value="{{ old('jumlah_tagihan') }}" min="0" step="0.01" required>
            @error('jumlah_tagihan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status Pembayaran</label>
            <select name="status" id="status" class="form-control" required>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Belum Lunas</option>
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Lunas</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Tagihan</button>
    </form>
</div>
@endsection
