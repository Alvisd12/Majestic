<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success - Majestic Transport</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e74fd 0%, #0056d3 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
            stroke: #1e74fd;
            stroke-width: 3;
        }

        .success-title {
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 40px;
            text-align: center;
        }

        .content-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-image {
            max-height: 60px;
            width: auto;
            margin-bottom: 10px;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, #00bcd4, #ff9800);
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .company-name {
            color: #333;
        }

        .transport-text {
            font-size: 12px;
            color: #666;
            margin-left: 48px;
            letter-spacing: 2px;
        }

        .address {
            text-align: center;
            font-size: 11px;
            color: #666;
            margin-bottom: 25px;
            line-height: 1.4;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .section-icon {
            width: 16px;
            height: 16px;
        }

        .info-list {
            list-style: none;
            padding-left: 20px;
        }

        .info-list li {
            color: #555;
            font-size: 13px;
            margin-bottom: 4px;
            position: relative;
        }

        .info-list li:before {
            content: "•";
            color: #1e74fd;
            position: absolute;
            left: -15px;
        }

        .divider {
            height: 1px;
            background: #e0e0e0;
            margin: 20px 0;
        }

        .thank-you {
            text-align: center;
            color: #1e74fd;
            font-size: 18px;
            font-weight: bold;
            margin: 25px 0 15px;
        }

        .thank-message {
            text-align: center;
            color: #666;
            font-size: 12px;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .note-section {
            background: #f8f9ff;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #1e74fd;
        }

        .note-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .note-list {
            list-style: none;
        }

        .note-list li {
            color: #d32f2f;
            font-size: 12px;
            margin-bottom: 4px;
            position: relative;
            padding-left: 15px;
        }

        .note-list li:before {
            content: "•";
            color: #d32f2f;
            position: absolute;
            left: 0;
        }

        @media (max-width: 480px) {
            .content-card {
                padding: 20px;
                margin: 0 10px;
            }
            
            .success-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="success-icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <polyline points="20,6 9,17 4,12"></polyline>
        </svg>
    </div>
    
    <h1 class="success-title">Success !</h1>
    
    <div class="content-card">
        <div class="logo-section">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Majestic Transport" class="logo-image" 
                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        </div>
        
        <div class="address">
            Gg. Kaserin M.U, Lesanpuro, Kec. Kedungkandang, Kota Malang, Jawa Timur 65138, Indonesia
        </div>
        
        <div class="section">
            <div class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12,6 12,12 16,14"></polyline>
                </svg>
                Informasi Motor
            </div>
            <ul class="info-list">
                <li>Kategori: {{ $peminjaman->jenis_motor }}</li>
                <li>Fasilitas: 2 Helm SNI, 1 Jas Hujan, Bensin Awal</li>
            </ul>
        </div>
        
        <div class="divider"></div>
        
        <div class="section">
            <div class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Detail Sewa
            </div>
            <ul class="info-list">
                <li>Tanggal Ambil: {{ \Carbon\Carbon::parse($peminjaman->tanggal_rental)->format('d F Y') }}</li>
                @if($peminjaman->jam_sewa)
                    <li>Jam Ambil: {{ $peminjaman->jam_sewa }} WIB</li>
                @endif
                <li>Durasi Sewa: {{ $peminjaman->durasi_sewa }} Hari</li>
                @php
                    $tanggalKembali = \Carbon\Carbon::parse($peminjaman->tanggal_rental)->addDays($peminjaman->durasi_sewa);
                    $jamKembali = $peminjaman->jam_sewa ? $peminjaman->jam_sewa : '10:00';
                @endphp
                <li>Kembali Maks: {{ $tanggalKembali->format('d F Y') }}, pukul {{ $jamKembali }} WIB</li>
            </ul>
        </div>
        
        <div class="divider"></div>
        
        <div class="section">
            <div class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Data Diri Penyewa
            </div>
            <ul class="info-list">
                <li>{{ $peminjaman->user->nama ?? $peminjaman->nama ?? 'Nama tidak tersedia' }}</li>
                <li>{{ $peminjaman->user->alamat ?? $peminjaman->alamat ?? 'Alamat tidak tersedia' }}</li>
                <li>{{ $peminjaman->user->no_handphone ?? $peminjaman->no_handphone ?? 'No HP tidak tersedia' }}</li>
            </ul>
        </div>
        
        <div class="divider"></div>
        
        <div class="section">
            <div class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="m17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                Ringkasan Pesanan
            </div>
            <ul class="info-list">
                <li>Motor: {{ $peminjaman->jenis_motor }}</li>
                <li>Durasi: {{ $peminjaman->durasi_sewa }} Hari</li>
                <li>Tanggal Ambil: {{ \Carbon\Carbon::parse($peminjaman->tanggal_rental)->format('d F Y') }}</li>
                @if($peminjaman->jam_sewa)
                    <li>Jam Ambil: {{ $peminjaman->jam_sewa }} WIB</li>
                @endif
                <li>Status: <strong>{{ $peminjaman->status }}</strong></li>
                <li>Subtotal: Rp {{ number_format($peminjaman->total_harga, 0, ',', '.') }}</li>
                @if(isset($peminjaman->denda) && $peminjaman->denda > 0)
                    <li>Denda: Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</li>
                    <li><strong>Total + Denda: Rp {{ number_format($peminjaman->total_harga + $peminjaman->denda, 0, ',', '.') }}</strong></li>
                @endif
            </ul>
        </div>
        
        <div class="thank-you">Thanks for riding with Majestic!</div>
        <div class="thank-message">
            Kami harap perjalananmu nyaman dan menyenangkan bersama motor dari kami.
        </div>
        
        <div class="note-section">
            <div class="note-title">Note :</div>
            <ul class="note-list">
                <li>Pesanan tidak dapat dibatalkan pada hari H.</li>
                <li>Harap tunjukkan bukti booking (struk atau screenshot ini) saat pengambilan motor.</li>
            </ul>
        </div>
    </div>
</body>
</html>