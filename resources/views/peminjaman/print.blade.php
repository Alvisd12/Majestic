<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Peminjaman - {{ $peminjaman->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
            color: #333;
        }
        .receipt {
            max-width: 600px;
            margin: 0 auto;
            border: 2px solid #007bff;
            border-radius: 10px;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .label {
            font-weight: 600;
            color: #666;
        }
        .value {
            font-weight: 500;
            color: #333;
        }
        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status.pending { background: #fff3cd; color: #856404; }
        .status.confirmed { background: #d1ecf1; color: #0c5460; }
        .status.disewa { background: #d4edda; color: #155724; }
        .status.selesai { background: #d1ecf1; color: #0c5460; }
        .status.cancelled { background: #f8d7da; color: #721c24; }
        .total {
            background: #f8f9fa;
            padding: 20px;
            margin: 20px -30px -30px -30px;
            text-align: center;
            border-top: 2px solid #007bff;
        }
        .total h3 {
            margin: 0;
            color: #007bff;
            font-size: 28px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        @media print {
            body { margin: 0; padding: 10px; }
            .receipt { border: 1px solid #000; }
            .header { 
                background: #007bff !important; 
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h2>🏍️ MAJESTIC RENTAL</h2>
            <p>Struk Peminjaman Motor</p>
        </div>
        
        <div class="content">
            <div class="info-row">
                <span class="label">ID Booking:</span>
                <span class="value">#{{ $peminjaman->id }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Nama Penyewa:</span>
                <span class="value">{{ $peminjaman->user->nama ?? $peminjaman->nama }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">No. Handphone:</span>
                <span class="value">{{ $peminjaman->user->no_handphone ?? $peminjaman->no_handphone }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Jenis Motor:</span>
                <span class="value">{{ $peminjaman->jenis_motor }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Tanggal Rental:</span>
                <span class="value">{{ \Carbon\Carbon::parse($peminjaman->tanggal_rental)->format('d F Y') }}</span>
            </div>
            
            @if($peminjaman->jam_sewa)
            <div class="info-row">
                <span class="label">Jam Sewa:</span>
                <span class="value">{{ $peminjaman->jam_sewa }}</span>
            </div>
            @endif
            
            <div class="info-row">
                <span class="label">Durasi Sewa:</span>
                <span class="value">{{ $peminjaman->durasi_sewa }} hari</span>
            </div>
            
            @if($peminjaman->tanggal_kembali)
            <div class="info-row">
                <span class="label">Tanggal Kembali:</span>
                <span class="value">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d F Y') }}</span>
            </div>
            @endif
            
            <div class="info-row">
                <span class="label">Status:</span>
                <span class="value">
                    <span class="status {{ strtolower($peminjaman->status) }}">{{ $peminjaman->status }}</span>
                </span>
            </div>
            
            <div class="info-row">
                <span class="label">Tanggal Booking:</span>
                <span class="value">{{ $peminjaman->created_at->format('d F Y H:i') }}</span>
            </div>
            
            <div class="total">
                <h3>Total: Rp {{ number_format($peminjaman->total_harga, 0, ',', '.') }}</h3>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>Terima kasih telah menggunakan layanan Majestic Rental!</strong></p>
            <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
