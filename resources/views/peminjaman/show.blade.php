@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-eye me-2"></i>Booking Details</h4>
                    <a href="{{ route('user.bookings') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back to Bookings
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Booking Information</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Booking ID:</strong></td>
                                    <td>#{{ $peminjaman->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Customer:</strong></td>
                                    <td>{{ $peminjaman->user->nama ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Motorbike:</strong></td>
                                    <td>{{ $peminjaman->jenis_motor }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Rental Date:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_rental)->format('d M Y') }}</td>
                                </tr>
                                @if($peminjaman->jam_sewa)
                                <tr>
                                    <td><strong>Rental Time:</strong></td>
                                    <td>{{ $peminjaman->jam_sewa }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td><strong>Duration:</strong></td>
                                    <td>{{ $peminjaman->durasi_sewa }} day(s)</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Status & Payment</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @php
                                            $statusClass = match($peminjaman->status) {
                                                'Pending' => 'warning',
                                                'Confirmed' => 'info',
                                                'Disewa' => 'primary',
                                                'Selesai' => 'success',
                                                'Cancelled' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }} fs-6">{{ $peminjaman->status }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Total Cost:</strong></td>
                                    <td class="fs-5 text-primary fw-bold">Rp {{ number_format($peminjaman->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $peminjaman->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                @if($peminjaman->tanggal_kembali)
                                <tr>
                                    <td><strong>Returned:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if(in_array($peminjaman->status, ['Pending', 'Confirmed']) && $peminjaman->user_id == session('user_id'))
                        <hr>
                        <div class="d-flex gap-2">
                            <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i>Edit Booking
                            </a>
                            @if(in_array($peminjaman->status, ['Pending', 'Cancelled']))
                                <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-1"></i>Delete Booking
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
