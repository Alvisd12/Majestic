@extends('index')

@section('content')

{{-- Motors data is now passed from controller --}}

<style>
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
    </div>
    <div class="grid-motor">
      @foreach ($motors as $index => $motor)
        <div class="motor-item">
          @if($motor->foto)
            <img src="{{ asset('storage/' . $motor->foto) }}" alt="{{ $motor->full_name }}">
          @else
            <img src="{{ asset('assets/images/default-motor.jpg') }}" alt="{{ $motor->full_name }}">
          @endif
          <div class="motor-info">{{ $motor->merk }} {{ $motor->model }}</div>
          <div class="motor-price" style="position: absolute; bottom: 15px; right: 15px; background: rgba(255, 193, 7, 0.9); color: #000; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; opacity: 0; transform: translateY(20px); transition: all 0.3s ease; z-index: 5;">
            Rp {{ number_format($motor->harga_per_hari, 0, ',', '.') }}/hari
          </div>
          <a href="{{ route('motor.detail', $motor->id) }}" class="detail-btn">
            Lihat Detail
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>

@endsection
