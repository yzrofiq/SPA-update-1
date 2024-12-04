<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WaterPay</title>
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
        }

        /* Navbar Styles */
        .navbar {
            width: 100%;
            background-color: #608BC1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .navbar ul li {
            display: inline;
        }

        .navbar ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: color 0.3s;
        }

        .navbar ul li a:hover {
            color: #50E3C2;
        }

        .navbar .btn {
            padding: 8px 15px;
            background-color: white;
            color: #4A90E2;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar .btn:hover {
            background-color: #2980b9;
            color: white;
        }

        /* Hero Section Styles */
        .hero-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 20px;
            background-color: #ffff;
        }

        .hero-text {
            max-width: 50%;
            text-align: left;
        }

        .hero-text h1 {
            font-size: 2.5rem;
            color: #2d3436;
            margin-bottom: 20px;
        }

        .hero-text p {
            font-size: 1.2rem;
            color: #636e72;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .hero-text .btn {
            padding: 10px 25px;
            background-color: #608BC1;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .hero-text .btn:hover {
            background-color: #4A628A;
        }

        .hero-image {
            max-width: 50%;
            text-align: center;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">WaterPay</div>
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    @auth
                        <a href="{{ url('/home') }}" class="btn">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="btn">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn">Register</a>
                        @endif
                    @endauth
                </div>
            @endif        
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="hero-text">
            <h1>Selamat Datang <br> di <span style="color:#608BC1; font-size:3rem;"> WaterPay </span></h1>
            <p>Sistem pembayaran tagihan air yang mudah, cepat, dan aman. 
                <br>
                Silahkan membuat akun terlebih dahulu, jika belum mempunyai akun!</p>
        </div>
        <div class="hero-image">
            <img src="{{ asset('assets/img/landing.png') }}" alt="Image">

        </div>
    </header>
</body>
</html>
