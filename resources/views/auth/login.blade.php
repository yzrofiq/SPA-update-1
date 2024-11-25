@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; background: url('/images/background.jpg') center center/cover;">
    <div class="row w-100">
        <div class="col-md-8 col-lg-6 mx-auto">
            <div class="card shadow-lg border-0 rounded-lg" style="background-color: #ffffffaa;">
                <div class="card-header text-center p-4" style="background-color: #004d40;">
                    <h3 class="text-white mb-0">{{ __('Welcome Back!') }}</h3>
                </div>

                <div class="card-body p-5" style="background-color: #e0f2f1;">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Field -->
                        <div class="mb-4 position-relative">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   style="border-radius: 8px;">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4 position-relative">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password" 
                                   style="border-radius: 8px;">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-primary w-100" style="background-color: #00796b; border-radius: 8px;">
                                {{ __('Login') }}
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-center mt-3">
                                <a class="btn btn-link text-primary" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        @endif

                        <!-- Register Link -->
                        <div class="text-center mt-3">
                            <p>Don't have an account?</p>
                            <a class="btn btn-link text-primary" href="{{ route('register') }}">
                                {{ __('Register Here') }}
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* General Page Styling */
    body {
        font-family: 'Nunito', sans-serif;
    }

    /* Card Styling */
    .card {
        border-radius: 20px;
        background-color: rgba(255, 255, 255, 0.9);
    }

    /* Input Styling */
    .form-control {
        height: 50px;
        padding: 10px;
        font-size: 1rem;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .form-control:focus {
        outline: none;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #00796b;
        font-weight: bold;
        padding: 12px 20px;
        color: #fff;
    }

    /* Link Color Adjustment for Password Reset and Register */
    .btn-link {
        color: #00796b;
    }
    .btn-link:hover {
        color: #004d40;
    }
</style>
@endsection
