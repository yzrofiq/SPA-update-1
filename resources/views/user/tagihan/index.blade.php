@extends('layouts.user')

@section('content')
<div class="container">
    <h1>Daftar Tagihan</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tagihans as $tagihan)
            <tr>
                <td>{{ $tagihan->id }}</td>
                <td>{{ $tagihan->jumlah_tagihan }}</td>
                <td>{{ $tagihan->status ? 'Lunas' : 'Belum Lunas' }}</td>
                <td>
                    @if (!$tagihan->status)
                    <a href="{{ route('user.bayar.create', $tagihan->id) }}" class="btn btn-primary">Bayar</a>
                    @else
                    <button class="btn btn-success" disabled>Lunas</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
