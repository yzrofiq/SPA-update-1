@extends('layouts.user')

@section('content')
<div class="container">
    <h1 class="dashboard-title">User Dashboard</h1>

    <div class="card-container">
        <!-- Tagihan Card -->
        <div class="card tagihan-card">
            <h3>Tagihan Saya</h3>
            <p>Daftar tagihan yang perlu Anda bayar.</p>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Jumlah Tagihan</th>
                            <th>Status</th>
                            <th>Bulan & Tahun</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tagihans as $tagihan)
                            <tr>
                                <td>{{ $tagihan->id }}</td>
                                <td>Rp. {{ number_format($tagihan->jumlah_tagihan, 2) }}</td>
                                <td>{{ $tagihan->status == 1 ? 'Lunas' : 'Belum Lunas' }}</td>
                                <td>{{ $tagihan->bulan }} - {{ $tagihan->tahun }}</td>
                                <td>
                                    @if($tagihan->status == 0)
                                    <span class="text-success">Belum Lunas</span>
                                    @else
                                        <span class="text-success">Tagihan Lunas</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada tagihan yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        </div>
    </div>
</div>

<style>
    .dashboard-title {
        text-align: center;
        margin-bottom: 20px;
    }
    .card-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }
    .card {
        width: 48%;
        padding: 20px;
        margin-bottom: 20px;
        background: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .table-responsive {
        margin-top: 10px;
    }
</style>
@endsection
