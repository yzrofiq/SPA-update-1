@extends('layouts.user')

@section('content')
<div class="container">
    <h1>Bayar Tagihan</h1>
    <form action="{{ route('user.payment.store', $tagihan->id) }}" method="POST">
        @csrf
        <!-- Display tagihan details -->
        <p>Tagihan ID: {{ $tagihan->id }}</p>
        <p>Jumlah Tagihan: Rp. {{ number_format($tagihan->jumlah_tagihan, 2) }}</p>
        
        <!-- Input field for the payment amount -->
        <div class="form-group">
            <label for="jumlah_bayar">Jumlah Bayar:</label>
            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" required>
        </div>

        <!-- Submit button for payment -->
        <button type="submit" class="btn btn-primary">Bayar</button>
    </form>
</div>
@endsection
