@extends('layouts.user')

@section('content')
    <div class="container">
        <h1 class="dashboard-title">Pembayaran Tagihan</h1>

        <!-- Menampilkan tagihan yang akan dibayar -->
        <div class="card">
            <h3>Tagihan ID: {{ $tagihan->id }}</h3>
            <p>Jumlah Tagihan: Rp. {{ number_format($tagihan->jumlah_tagihan, 2) }}</p>
            <p>Status: {{ $tagihan->status == 1 ? 'Lunas' : 'Belum Lunas' }}</p>
            <p>Tanggal Tagihan: {{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->format('d-m-Y') }}</p>

            <!-- Form Pembayaran -->
            <form action="{{ route('user.pembayaran.store', $tagihan->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="jumlah_bayar">Jumlah Bayar</label>
                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" required min="1" max="{{ $tagihan->jumlah_tagihan }}" placeholder="Masukkan jumlah bayar">
                </div>
                <button type="submit" class="btn btn-success mt-3">Bayar</button>
            </form>
        </div>
    </div>
@endsection

<style>
    .container {
        margin-top: 30px;
        max-width: 600px;
    }

    .dashboard-title {
        font-size: 2rem;
        font-weight: bold;
        color: #34495E;
        margin-bottom: 20px;
        text-align: center;
    }

    .card {
        background-color: #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
    }

    .btn {
        width: 100%;
        padding: 10px;
        font-size: 1.1rem;
    }
</style>
