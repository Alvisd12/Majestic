@extends('index')

@section('content')

@php
  $motors = [
    ['gambar' => 'assets/images/motor1.jpg'],
    ['gambar' => 'assets/images/unit beat 2.png'],
    ['gambar' => 'assets/images/motor4.jpg'],
    ['gambar' => 'assets/images/motor3.jpg'],
    ['gambar' => 'assets/images/motor2.jpg'],
    ['gambar' => 'assets/images/motor7.jpg'],
    ['gambar' => 'assets/images/motor5.jpg'],
    ['gambar' => 'assets/images/motor8.jpg'],
    ['gambar' => 'assets/images/motor6.jpg'],
  ];
@endphp

<style>
  .judul-sewa {
    text-align: center;
    margin-bottom: 2rem;
  }

  .judul-sewa h2 {
    font-weight: 700;
    font-size: 2rem;
    color: #004aad;
    margin-bottom: 0;
  }

  .judul-sewa h3 {
    font-weight: 600;
    font-size: 1.3rem;
    color: #f5b700;
    margin-top: 0;
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
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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

  /* Tombol Detail */
  .detail-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.8);
    background: linear-gradient(135deg, #004aad, #0066dd);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 25px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
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

  /* Animasi bounce */
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

  .motor-item:hover .detail-btn {
    animation: bounce 0.8s ease-in-out;
  }

  /* Info tambahan di sudut */
  .motor-info {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.9);
    color: #004aad;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
    z-index: 5;
  }

  .motor-item:hover .motor-info {
    opacity: 1;
    transform: translateX(0);
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

  /* Efek glow saat hover */
  .motor-item:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15), 0 0 20px rgba(245, 183, 0, 0.3);
  }

  /* Loading animation untuk tombol */
  .detail-btn:active {
    transform: translate(-50%, -50%) scale(0.95);
    transition: transform 0.1s ease;
  }
</style>

<section class="harga-sewa py-5">
  <div class="container">
    <div class="judul-sewa">
      <h2>Sewa Motor</h2>
      <h3>Sekarang</h3>
    </div>
    <div class="grid-motor">
      @foreach ($motors as $index => $motor)
        <div class="motor-item">
          <img src="{{ asset($motor['gambar']) }}" alt="motor">
          <div class="motor-info">Unit {{ $index + 1 }}</div>
          <button class="detail-btn" onclick="showDetail({{ $index + 1 }})">
            Lihat Detail
          </button>
        </div>
      @endforeach
    </div>
  </div>
</section>

<script>
function showDetail(motorId) {
  // Efek klik pada tombol
  event.target.style.transform = 'translate(-50%, -50%) scale(0.9)';
  
  setTimeout(() => {
    event.target.style.transform = 'translate(-50%, -50%) scale(1)';
    
    // Alert sementara - bisa diganti dengan modal atau redirect
    alert(`Menampilkan detail untuk Motor Unit ${motorId}\n\nFitur yang akan ditampilkan:\n• Spesifikasi motor\n• Harga sewa\n• Ketersediaan\n• Foto tambahan\n• Form booking`);
    
    // Contoh redirect ke halaman detail
    // window.location.href = `/motor-detail/${motorId}`;
    
    // Atau buka modal
    // showModalDetail(motorId);
    
  }, 150);
}

// Fungsi untuk menambah efek suara (opsional)
function playClickSound() {
  // Bisa ditambahkan audio click effect
  console.log('Click sound played');
}

// Event listener untuk keyboard accessibility
document.addEventListener('keydown', function(event) {
  if (event.key === 'Enter' || event.key === ' ') {
    const focusedBtn = document.activeElement;
    if (focusedBtn.classList.contains('detail-btn')) {
      focusedBtn.click();
    }
  }
});
</script>

@endsection