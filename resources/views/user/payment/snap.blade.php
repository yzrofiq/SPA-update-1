@extends('layouts.user')

@section('content')
<div class="container">
    <h1>Proses Pembayaran</h1>
    <p>Mohon tunggu, Anda akan diarahkan ke halaman pembayaran...</p>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    snap.pay('{{ $snapToken }}', {
        onSuccess: function (result) {
            alert('Pembayaran berhasil!');
            // Kirim request untuk memperbarui status tagihan
            fetch('{{ route('user.tagihan.update-status', $tagihan->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: 1 }) // Set status tagihan menjadi lunas
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Gagal memperbarui status.');
            })
            .then(data => {
                console.log(data.message);
                window.location.href = '{{ route('user.tagihans.index') }}';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memperbarui status tagihan. Silakan hubungi admin.');
            });
        },
        onPending: function (result) {
            alert('Pembayaran sedang diproses. Silakan cek status pembayaran di dashboard Anda.');
        },
        onError: function (result) {
            alert('Pembayaran gagal. Silakan coba lagi.');
        },
    });
</script>
@endsection
