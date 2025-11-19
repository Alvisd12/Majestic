@extends('layouts.app')

@section('title', 'Book a Motorbike')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-motorcycle me-2"></i>Book a Motorbike</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_rental" class="form-label">Rental Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_rental" name="tanggal_rental" 
                                       value="{{ old('tanggal_rental') }}" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="jam_sewa" class="form-label">Rental Time</label>
                                <input type="time" class="form-control" id="jam_sewa" name="jam_sewa" 
                                       value="{{ old('jam_sewa', '08:00') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_motor" class="form-label">Motorbike Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="jenis_motor" name="jenis_motor" required>
                                <option value="">Select a motorbike</option>
                                @foreach($motors as $motor)
                                    <option value="{{ $motor->merk }} {{ $motor->model }}" 
                                            data-price="{{ $motor->harga_per_hari }}"
                                            {{ old('jenis_motor') == $motor->merk . ' ' . $motor->model ? 'selected' : '' }}>
                                        {{ $motor->merk }} {{ $motor->model }} - Rp {{ number_format($motor->harga_per_hari, 0, ',', '.') }}/day
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="durasi_sewa" class="form-label">Rental Duration (days) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="durasi_sewa" name="durasi_sewa" 
                                   value="{{ old('durasi_sewa', 1) }}" min="1" max="30" required>
                        </div>

                        <div class="mb-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Total Cost</h5>
                                    <p class="card-text fs-4 text-primary fw-bold" id="total-cost">Rp 0</p>
                                    <small class="text-muted">Price will be calculated automatically based on your selection</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('home') }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Submit Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisMotorSelect = document.getElementById('jenis_motor');
    const durasiSewaInput = document.getElementById('durasi_sewa');
    const totalCostElement = document.getElementById('total-cost');

    function calculateTotal() {
        const selectedOption = jenisMotorSelect.options[jenisMotorSelect.selectedIndex];
        const pricePerDay = selectedOption.getAttribute('data-price') || 0;
        const duration = durasiSewaInput.value || 0;
        const total = pricePerDay * duration;
        
        totalCostElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    jenisMotorSelect.addEventListener('change', calculateTotal);
    durasiSewaInput.addEventListener('input', calculateTotal);
    
    // Calculate initial total
    calculateTotal();
});
</script>
@endsection
