@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-history me-2"></i>My Booking History</h4>
                    <a href="{{ route('booking.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i>New Booking
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('user.bookings') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="search" 
                                       placeholder="Search by motorbike type or status..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="status">
                                    <option value="">All Status</option>
                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="Disewa" {{ request('status') == 'Disewa' ? 'selected' : '' }}>Rented</option>
                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Motorbike</th>
                                        <th>Rental Date</th>
                                        <th>Duration</th>
                                        <th>Total Cost</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $index => $booking)
                                        <tr>
                                            <td>{{ $bookings->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $booking->jenis_motor }}</strong>
                                                @if($booking->jam_sewa)
                                                    <br><small class="text-muted">{{ $booking->jam_sewa }}</small>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($booking->tanggal_rental)->format('d M Y') }}</td>
                                            <td>{{ $booking->durasi_sewa }} day(s)</td>
                                            <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $statusClass = match($booking->status) {
                                                        'Pending' => 'warning',
                                                        'Confirmed' => 'info',
                                                        'Disewa' => 'primary',
                                                        'Selesai' => 'success',
                                                        'Cancelled' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">{{ $booking->status }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('peminjaman.show', $booking->id) }}" 
                                                       class="btn btn-outline-primary" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(in_array($booking->status, ['Pending', 'Confirmed']))
                                                        <a href="{{ route('peminjaman.edit', $booking->id) }}" 
                                                           class="btn btn-outline-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    @if(in_array($booking->status, ['Pending', 'Cancelled']))
                                                        <form action="{{ route('peminjaman.destroy', $booking->id) }}" 
                                                              method="POST" class="d-inline"
                                                              onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $bookings->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-motorcycle fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No bookings found</h5>
                            <p class="text-muted">You haven't made any bookings yet.</p>
                            <a href="{{ route('booking.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Make Your First Booking
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
