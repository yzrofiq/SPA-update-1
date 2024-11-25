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
                                <th>Tanggal Tagihan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tagihans as $tagihan)
<tr>
    <td>{{ $tagihan->id }}</td>
    <td>Rp. {{ number_format($tagihan->jumlah_tagihan, 2) }}</td>
    <td>{{ $tagihan->status == 1 ? 'Lunas' : 'Belum Lunas' }}</td>
    <td>{{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->format('d-m-Y') }}</td>
    <td>
        @if($tagihan->status == 0) <!-- Only show the Pay button if the bill is not paid -->
            <a href="{{ route('user.payment.create', $tagihan->id) }}" class="btn btn-primary">Bayar</a>
        @else
            <span class="text-success">Tagihan Lunas</span>
        @endif
    </td>
</tr>
@endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pembayaran Card -->
            <div class="card pembayaran-card">
                <h3>Riwayat Pembayaran</h3>
                <p>Transaksi pembayaran yang telah Anda lakukan.</p>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tagihan</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Jumlah Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembayarans as $pembayaran)
                                <tr>
                                    <td>{{ $pembayaran->id }}</td>
                                    <td>{{ $pembayaran->tagihan->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d-m-Y') }}</td>
                                    <td>Rp. {{ number_format($pembayaran->jumlah_bayar, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Page Layout */
        .container {
            margin-top: 30px;
            max-width: 1200px;
        }

        /* Dashboard Title */
        .dashboard-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #34495E;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Card Container */
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* Card Styling */
        .card {
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 20px;
            flex: 1 1 45%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            font-size: 1.5rem;
            color: #2C3E50;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 1rem;
            color: #7F8C8D;
            margin-bottom: 20px;
        }

        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        .table-responsive {
            max-width: 100%;
            overflow-x: auto;
        }

        .table thead {
            background-color: #ecf0f1;
            color: #34495E;
            font-weight: bold;
        }

        .table tbody tr:hover {
            background-color: #f2f6f7;
        }

        .table th, .table td {
            padding: 10px 15px;
            text-align: left;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .card-container {
                flex-direction: column;
            }
        }
    </style>
@endsection
