@extends('index')

@section('content')

<!-- Filter and Search Section -->
<section class="filter-section py-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <form method="GET" action="{{ route('harga_sewa') }}" id="filterForm">
            <div class="row g-3 align-items-end">
                <!-- Search Box -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold text-primary">
                        <i class="fas fa-search me-1"></i>Pencarian
                    </label>
                    <input type="text" class="form-control" name="search" 
                           placeholder="Cari nama atau merk motor..." 
                           value="{{ request('search') }}">
                </div>
                
                <!-- Jenis Motor Filter -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-bold text-primary">
                        <i class="fas fa-motorcycle me-1"></i>Jenis Motor
                    </label>
                    <select class="form-select" name="jenis_motor">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisMotor as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis_motor') == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Status Filter -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-bold text-primary">
                        <i class="fas fa-check-circle me-1"></i>Ketersediaan
                    </label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Price Range -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-bold text-primary">
                        <i class="fas fa-money-bill me-1"></i>Harga Min
                    </label>
                    <input type="number" class="form-control" name="harga_min" 
                           placeholder="50000" value="{{ request('harga_min') }}">
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-bold text-primary">Harga Max</label>
                    <input type="number" class="form-control" name="harga_max" 
                           placeholder="200000" value="{{ request('harga_max') }}">
                </div>
                
                <!-- Filter Buttons -->
                <div class="col-lg-1 col-md-6">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <a href="{{ route('harga_sewa') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</section>

<style>
  /* Filter Section Styling */
  .filter-section {
    border-bottom: 3px solid #0466C8;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }
  
  .filter-section .form-label {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
  }
  
  .filter-section .form-control,
  .filter-section .form-select {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
  }
  
  .filter-section .form-control:focus,
  .filter-section .form-select:focus {
    border-color: #0466C8;
    box-shadow: 0 0 0 0.2rem rgba(4, 102, 200, 0.25);
  }
  
  .filter-section .btn {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .filter-section .btn-primary {
    background: linear-gradient(135deg, #0466C8, #004aad);
    border: none;
  }
  
  .filter-section .btn-primary:hover {
    background: linear-gradient(135deg, #004aad, #003d91);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(4, 102, 200, 0.3);
  }

 .judul-sewa {
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
    animation: fadeInDown 1s ease-out;
  }

  .judul-sewa h2 {
    font-weight: 800;
    font-size: 2.5rem;
    color: #0466C8;
    margin-bottom: 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
  }

  .judul-sewa h3 {
    font-weight: 800;
    font-size: 2.5rem;
    color: #FFC107;
    margin-top: 0;
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3);
  }

  @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @media (max-width: 768px) {
    .judul-sewa h2,
    .judul-sewa h3 {
      font-size: 2rem;
    }
  }

  @media (max-width: 480px) {
    .judul-sewa h2,
    .judul-sewa h3 {
      font-size: 1.8rem;
    }
  }

  .grid-motor {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
  }

  .motor-item {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .motor-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15), 0 0 20px rgba(245, 183, 0, 0.3);
  }

  .motor-item img {
    width: 100%;
    max-width: 100%;
    height: auto;
    display: block;
    object-fit: contain;
    padding: 10px;
    transition: all 0.3s ease;
  }

  .motor-item:hover img {
    transform: scale(1.05);
  }

  .detail-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.8);
    background: linear-gradient(135deg, #004aad, #0066dd);
    color: white;
    text-decoration: none;
    padding: 12px 24px;
    border-radius: 25px;
    font-size: 1rem;
    font-weight: 600;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 10;
    box-shadow: 0 4px 15px rgba(0, 74, 173, 0.4);
  }

  .motor-item:hover .detail-btn {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -50%) scale(1);
    animation: bounce 0.8s ease-in-out;
  }

  .detail-btn:hover {
    background: linear-gradient(135deg, #0066dd, #004aad);
    transform: translate(-50%, -50%) scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 74, 173, 0.6);
  }

  .detail-btn::before {
    content: "📋 ";
    margin-right: 6px;
  }

  @keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
      transform: translate(-50%, -50%) scale(1);
    }
    40% {
      transform: translate(-50%, -50%) scale(1.1);
    }
    60% {
      transform: translate(-50%, -50%) scale(1.05);
    }
  }

  /* POSISI UNIT DI KIRI */
  .motor-info {
    position: absolute;
    top: 15px;
    left: 15px; /* ubah dari right ke left */
    background: rgba(255, 255, 255, 0.9);
    color: #004aad;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    opacity: 0;
    transform: translateX(-20px); /* animasi masuk dari kiri */
    transition: all 0.3s ease;
    z-index: 5;
  }

  .motor-item:hover .motor-info {
    opacity: 1;
    transform: translateX(0);
  }

  .motor-item:hover .motor-price {
    opacity: 1;
    transform: translateY(0);
  }
  
  .motor-item:hover .motor-jenis,
  .motor-item:hover .motor-status {
    opacity: 1;
    transform: translateY(0);
  }

  .motor-info::before {
    content: "🏍️ ";
    margin-right: 4px;
  }

  @media (max-width: 768px) {
    .grid-motor {
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
    }

    .detail-btn {
      font-size: 0.9rem;
      padding: 10px 20px;
    }

    .motor-info {
      font-size: 0.75rem;
      padding: 4px 8px;
    }
  }

  @media (max-width: 500px) {
    .grid-motor {
      grid-template-columns: 1fr;
    }

    .detail-btn {
      font-size: 0.95rem;
      padding: 12px 22px;
    }
  }
</style>

<section class="harga-sewa py-5">
  <div class="container">
    <div class="judul-sewa">
      <h2>Harga Sewa</h2>
      @if(request()->hasAny(['search', 'jenis_motor', 'status', 'harga_min', 'harga_max']))
        <div class="filter-info mt-3">
          <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Menampilkan {{ $motors->total() }} motor dari {{ $motors->total() }} hasil
            @if(request('search'))
              untuk pencarian "<strong>{{ request('search') }}</strong>"
            @endif
            @if(request('jenis_motor'))
              dengan jenis "<strong>{{ request('jenis_motor') }}</strong>"
            @endif
            @if(request('status'))
              dengan status "<strong>{{ request('status') }}</strong>"
            @endif
            @if(request('harga_min') || request('harga_max'))
              dengan harga 
              @if(request('harga_min'))
                dari Rp {{ number_format(request('harga_min'), 0, ',', '.') }}
              @endif
              @if(request('harga_max'))
                sampai Rp {{ number_format(request('harga_max'), 0, ',', '.') }}
              @endif
            @endif
            <a href="{{ route('harga_sewa') }}" class="btn btn-sm btn-outline-primary ms-2">
              <i class="fas fa-times me-1"></i>Hapus Filter
            </a>
          </div>
        </div>
      @endif
    </div>
    @if($motors->count() > 0)
    <div class="grid-motor">
      @foreach ($motors as $index => $motor)
        <div class="motor-item">
          @if($motor->foto)
            <img src="{{ asset('storage/' . $motor->foto) }}" alt="{{ $motor->full_name }}">
          @else
            <img src="{{ asset('assets/images/default-motor.jpg') }}" alt="{{ $motor->full_name }}">
          @endif
          <div class="motor-info">{{ $motor->merk }} {{ $motor->model }}</div>
          
          <!-- Jenis Motor Badge -->
          <div class="motor-jenis" style="position: absolute; top: 15px; right: 15px; background: rgba(4, 102, 200, 0.9); color: white; padding: 4px 10px; border-radius: 15px; font-size: 0.7rem; font-weight: 600; opacity: 0; transform: translateY(-20px); transition: all 0.3s ease; z-index: 5;">
            {{ $motor->jenis_motor ?: 'Motor' }}
          </div>
          
          <!-- Status Badge -->
          @php
            $statusColors = [
              'Tersedia' => 'background: rgba(40, 167, 69, 0.9); color: white;',
              'Disewa' => 'background: rgba(255, 193, 7, 0.9); color: #000;',
              'Maintenance' => 'background: rgba(220, 53, 69, 0.9); color: white;'
            ];
            $statusStyle = $statusColors[$motor->status] ?? 'background: rgba(108, 117, 125, 0.9); color: white;';
          @endphp
          <div class="motor-status" style="position: absolute; top: 50px; right: 15px; padding: 4px 10px; border-radius: 15px; font-size: 0.7rem; font-weight: 600; opacity: 0; transform: translateY(-20px); transition: all 0.3s ease; z-index: 5; {{ $statusStyle }}">
            {{ $motor->status }}
          </div>
          
          <div class="motor-price" style="position: absolute; bottom: 15px; right: 15px; background: rgba(255, 193, 7, 0.9); color: #000; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; opacity: 0; transform: translateY(20px); transition: all 0.3s ease; z-index: 5;">
            Rp {{ number_format($motor->harga_per_hari, 0, ',', '.') }}/hari
          </div>
          <a href="{{ route('motor.detail', $motor->id) }}" class="detail-btn">
            Lihat Detail
          </a>
        </div>
      @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
      {{ $motors->appends(request()->query())->links() }}
    </div>
    
    @else
    <!-- Empty State -->
    <div class="empty-state text-center py-5">
      <div class="empty-icon mb-4">
        <i class="fas fa-search fa-4x text-muted"></i>
      </div>
      <h4 class="text-muted mb-3">Tidak ada motor ditemukan</h4>
      <p class="text-muted mb-4">
        @if(request()->hasAny(['search', 'jenis_motor', 'status', 'harga_min', 'harga_max']))
          Coba ubah kriteria pencarian atau filter Anda.
        @else
          Belum ada motor yang tersedia saat ini.
        @endif
      </p>
      @if(request()->hasAny(['search', 'jenis_motor', 'status', 'harga_min', 'harga_max']))
        <a href="{{ route('harga_sewa') }}" class="btn btn-primary">
          <i class="fas fa-refresh me-2"></i>Lihat Semua Motor
        </a>
      @endif
    </div>
    @endif
  </div>
</section>

@endsection
