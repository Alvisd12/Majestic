@extends('index')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-credit-card me-2"></i>
                    <h5 class="mb-0">Proses Pembayaran</h5>
                </div>
                <div class="card-body text-center py-5">
                    <h4 class="mb-3">Silakan selesaikan pembayaran Anda</h4>
                    <p class="text-muted mb-4">Jangan tutup halaman ini sampai proses pembayaran selesai.</p>

                    <div class="mb-4">
                        <div class="fw-bold">Pesanan #{{ $peminjaman->id }}</div>
                        <div>{{ $peminjaman->jenis_motor }}</div>
                        <div class="mt-2 fs-4 text-primary fw-bold">
                            Rp {{ number_format($peminjaman->total_harga, 0, ',', '.') }}
                        </div>
                    </div>

                    <button id="pay-button" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-wallet me-2"></i>Bayar Sekarang
                    </button>

                    <p class="text-muted mt-3 mb-0"
                       id="payment-countdown"
                       data-expires-at="{{ isset($expiresAt) ? $expiresAt->getTimestamp() * 1000 : '' }}"
                       style="font-size: 0.9rem;"></p>

                    <p class="text-muted mt-4 mb-0" style="font-size: 0.9rem;">
                        Jika popup pembayaran tidak muncul, klik tombol "Bayar Sekarang" di atas.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $isProduction = config('midtrans.is_production');
    $snapScriptUrl = $isProduction
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
@endphp

<script src="{{ $snapScriptUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var payButton = document.getElementById('pay-button');
        var countdownEl = document.getElementById('payment-countdown');
        var expiresAtMs = null;
        if (countdownEl && countdownEl.dataset.expiresAt) {
            var parsed = parseInt(countdownEl.dataset.expiresAt, 10);
            if (!isNaN(parsed) && parsed > 0) {
                expiresAtMs = parsed;
            }
        }

        function disablePayment(reason) {
            if (payButton) {
                payButton.disabled = true;
                payButton.classList.add('disabled');
            }
            if (countdownEl && reason) {
                countdownEl.textContent = reason;
            }
        }

        function updateCountdown() {
            if (!expiresAtMs || !countdownEl) return;

            var now = Date.now();
            var diff = expiresAtMs - now;

            if (diff <= 0) {
                disablePayment('Waktu pembayaran 1 jam telah habis. Silakan buat pesanan baru.');
                return;
            }

            var totalSeconds = Math.floor(diff / 1000);
            var minutes = Math.floor(totalSeconds / 60);
            var seconds = totalSeconds % 60;

            var mm = minutes.toString().padStart(2, '0');
            var ss = seconds.toString().padStart(2, '0');

            countdownEl.textContent = 'Waktu tersisa untuk menyelesaikan pembayaran: ' + mm + ':' + ss;
        }

        if (expiresAtMs && countdownEl) {
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        function startPayment() {
            if (expiresAtMs && Date.now() >= expiresAtMs) {
                disablePayment('Waktu pembayaran 1 jam telah habis. Silakan buat pesanan baru.');
                return;
            }

            window.snap.pay("{{ $snapToken }}", {
                onSuccess: function (result) {
                    window.location.href = "{{ route('midtrans.finish') }}?order_id={{ $peminjaman->midtrans_order_id }}";
                },
                onPending: function (result) {
                    window.location.href = "{{ route('midtrans.finish') }}?order_id={{ $peminjaman->midtrans_order_id }}";
                },
                onError: function (result) {
                    window.location.href = "{{ route('midtrans.error') }}";
                },
                onClose: function () {
                    // User closes the popup without finishing the payment
                }
            });
        }

        payButton.addEventListener('click', function (e) {
            e.preventDefault();
            startPayment();
        });

        // Auto trigger payment popup on page load
        if (!expiresAtMs || Date.now() < expiresAtMs) {
            startPayment();
        } else {
            disablePayment('Waktu pembayaran 1 jam telah habis. Silakan buat pesanan baru.');
        }
    });
</script>
@endsection
