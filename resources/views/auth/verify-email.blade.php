<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verifikasi Email Anda</div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <p>Terima kasih telah mendaftar! Sebelum melanjutkan, silakan cek email Anda untuk tautan verifikasi.</p>
                    <p>Jika Anda tidak menerima email, klik tombol di bawah untuk mengirim ulang.</p>

                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Kirim Ulang Email Verifikasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* General Container Styling */
.container {
    margin-top: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Card Styling */
.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    background-color: #007bff;
    color: #fff;
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
    padding: 15px;
    border-bottom: 1px solid #ddd;
}

.card-body {
    padding: 20px;
    font-size: 1rem;
    line-height: 1.6;
    color: #333;
}

/* Alert Message Styling */
.alert {
    margin-bottom: 20px;
    padding: 15px;
    border-radius: 5px;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

/* Button Styling */
.btn-primary {
    background-color: #007bff;
    border: none;
    color: #fff;
    padding: 10px 20px;
    font-size: 1rem;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
}
</style>