@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@section('page-title', 'Detail Peminjaman')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Informasi Peminjaman</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nama:</strong></td>
                            <td>{{ $peminjaman->user->nama ?? 'Unknown' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. Handphone:</strong></td>
                            <td>{{ $peminjaman->user->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Motor:</strong></td>
                            <td>{{ $peminjaman->jenis_motor }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Rental:</strong></td>
                            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_rental)->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Durasi Sewa:</strong></td>
                            <td>{{ $peminjaman->durasi_sewa }} hari</td>
                        </tr>
                        <tr>
                            <td><strong>Total Biaya:</strong></td>
                            <td class="fw-bold">Rp {{ number_format($peminjaman->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @php
                                    $statusColors = [
                                        'Pending' => 'warning',
                                        'Confirmed' => 'info',
                                        'Disewa' => 'primary',
                                        'Belum Kembali' => 'warning',
                                        'Selesai' => 'success',
                                        'Cancelled' => 'danger'
                                    ];
                                    $color = $statusColors[$peminjaman->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ $peminjaman->status }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Dibuat:</strong></td>
                            <td>{{ \Carbon\Carbon::parse($peminjaman->created_at)->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            @if($peminjaman->bukti_jaminan)
            <div class="row mt-3">
                <div class="col-12">
                    <h6>Bukti Jaminan:</h6>
                    <img src="{{ asset('storage/' . $peminjaman->bukti_jaminan) }}" 
                         alt="Bukti Jaminan" class="img-fluid" style="max-width: 300px;">
                </div>
            </div>
            @endif
            
            <div class="row mt-3">
                <div class="col-12">
                    @php
                        $backRoute = 'admin.konfirmasi';
                        if ($peminjaman->status === 'Confirmed' || $peminjaman->status === 'Disewa' || $peminjaman->status === 'Belum Kembali') {
                            $backRoute = 'admin.dipinjam';
                        } elseif ($peminjaman->status === 'Selesai') {
                            $backRoute = 'admin.dikembalikan';
                        }
                    @endphp
                    <a href="{{ route($backRoute) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection 