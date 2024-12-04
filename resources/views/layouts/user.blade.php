<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'WaterPay') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
/* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Nunito', sans-serif;
        }

        .content .user-info .user-name {
            margin-right: 15px;
            font-size: 1rem;
            color: #2C3E50;
        }

        /* Dashboard Banner */
        .dashboard-banner {
            background: linear-gradient(135deg, #4A90E2, #50E3C2);
            color: #ffffff;
            padding: 50px;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2);
            border-radius: 16px;
            animation: fadeIn 1.2s ease;
            width: 100%; /* Ensure it takes the full width */
            max-width: 100%;
            position: relative;
            left: 0;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .dashboard-banner {
                margin-left: 0; /* Remove left margin for smaller screens */
                max-width: 100%; /* Allow the banner to take full width */
            }
        }

        .dashboard-banner h1 {
            font-size: 2.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .dashboard-banner p {
            font-size: 1.15rem;
            margin-top: 15px;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: #34495E;
            padding-top: 30px;
            color: #ecf0f1;
            transition: width 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar h4 {
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #ecf0f1;
            font-weight: 500;
            display: block;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 8px;
            margin: 8px 15px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #2C3E50;
        }

        /* Content */
        .content {
            margin-left: 260px; /* Menyesuaikan dengan lebar sidebar */
            padding: 20px;      /* Memberikan ruang dalam konten */
            background: #FAFAFA;
            min-height: 100vh;
            width: 100%; /* Lebar penuh minus sidebar */
        }

        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                padding: 15px;
            }
        }

        /* Buttons */
        .btn-primary {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-secondary {
            background-color: #A6AEBF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Improve sidebar on small screens */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                box-shadow: none;
            }
            .content {
                margin-left: 0;
                padding: 20px;
            }
        }

    </style>
</head>

<body>
    <div id="app">
        @auth
            <div class="d-flex">
                <!-- Sidebar -->
                <div class="sidebar">
                    <h4>Dashboard Pengguna</h4>
                    <a href="{{ route('user.dashboard') }}">Home</a>
                    <a href="{{ route('user.tagihans.index') }}">Tagihan</a>
                    <!-- <a href="">Tagihan</a>
                    <a href="">Riwayat Pembayaran</a> -->
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>

                <!-- Main Content -->
                <div class="content">
                    <div class="dashboard-banner">
                        <h1>Selamat Datang di Waterpay!</h1>
                        <p>Kelola Tagihan dan Pembayaran Anda dengan mudah.</p>
                    </div>

                    @yield('content')
                </div>
            </div>
        @else
            <!-- Show Login Page -->
            @yield('content')
        @endauth
    </div>
</body>
</html>
