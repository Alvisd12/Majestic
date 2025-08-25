@extends('index')

@section('content')

@php
  $motors = [
    ['gambar' => 'assets/images/g1.jpg', 'tanggal_sewa' => '2025-01-15'],
    ['gambar' => 'assets/images/g2.jpg', 'tanggal_sewa' => '2025-01-18'],
    ['gambar' => 'assets/images/g3.jpg', 'tanggal_sewa' => '2025-01-20'],
    ['gambar' => 'assets/images/g4.jpg', 'tanggal_sewa' => '2025-01-22'],
    ['gambar' => 'assets/images/g5.jpg', 'tanggal_sewa' => '2025-01-25'],
    ['gambar' => 'assets/images/g6.png', 'tanggal_sewa' => '2025-01-28'],
    ['gambar' => 'assets/images/g7.png', 'tanggal_sewa' => '2025-01-30'],
    ['gambar' => 'assets/images/g8.png', 'tanggal_sewa' => '2025-02-02'],
    ['gambar' => 'assets/images/g9.png', 'tanggal_sewa' => '2025-02-05'],
  ];
@endphp

<style>
  body {
    font-family: 'Poppins', sans-serif;
  }

  .judul-galeri {
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
    animation: fadeInDown 1s ease-out;
  }

  .judul-galeri h2 {
    font-weight: 800;
    font-size: 2.5rem;
    color: #0466C8;
    margin-bottom: 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
  }

  /* Animations */
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

  .grid-motor {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
  }

  .motor-item {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
  }

  .motor-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  }

  .motor-item img {
    width: 100%;
    max-width: 100%;
    height: auto;
    display: block;
    object-fit: contain;
    padding: 8px;
    transition: opacity 0.3s;
  }

  .motor-item:hover img {
    opacity: 0.9;
  }

  .tanggal-sewa {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: linear-gradient(135deg, #004aad, #0066dd);
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(0, 74, 173, 0.4);
    z-index: 10;
    opacity: 0;
    visibility: hidden;
    transform: translate(-50%, -50%) scale(0.8);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.2);
  }

  .motor-item:hover .tanggal-sewa {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -50%) scale(1);
  }

  .tanggal-sewa::before {
    content: "📅 ";
    margin-right: 6px;
  }

  /* Overlay background saat hover */
  .motor-item::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.4);
    opacity: 0;
    transition: opacity 0.3s;
    pointer-events: none;
    z-index: 5;
  }

  .motor-item:hover::after {
    opacity: 1;
  }

  /* Indikator hover */
  .motor-item::before {
    content: '📅 Hover untuk lihat tanggal';
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.75rem;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 3;
  }

  .motor-item:hover::before {
    opacity: 0;
    visibility: hidden;
  }

  /* Animasi bounce untuk tanggal yang baru muncul */
  @keyframes bounce {
    0% { transform: translate(-50%, -50%) scale(0.8); }
    50% { transform: translate(-50%, -50%) scale(1.1); }
    100% { transform: translate(-50%, -50%) scale(1); }
  }

  .tanggal-sewa.bounce {
    animation: bounce 0.5s ease-out;
  }

  /* Efek glow */
  .tanggal-sewa.show {
    box-shadow: 0 4px 15px rgba(0, 74, 173, 0.4), 0 0 20px rgba(245, 183, 0, 0.3);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .judul-galeri h2 {
      font-size: 2rem;
    }

    .grid-motor {
      grid-template-columns: repeat(2, 1fr);
    }
    
    .tanggal-sewa {
      font-size: 0.8rem;
      padding: 10px 16px;
    }
    
    .motor-item::before {
      font-size: 0.7rem;
      padding: 4px 8px;
    }
  }

  @media (max-width: 500px) {
    .judul-galeri h2 {
      font-size: 1.8rem;
    }

    .grid-motor {
      grid-template-columns: 1fr;
    }
    
    .tanggal-sewa {
      font-size: 0.85rem;
      padding: 10px 18px;
    }
  }
</style>

<section class="harga-sewa py-4">
  <div class="container">
    <div class="judul-galeri">
      <h2>Galeri</h2>
    </div>
    <div class="grid-motor">
      @foreach ($motors as $index => $motor)
        <div class="motor-item" onclick="toggleTanggal({{ $index }})">
          <img src="{{ asset($motor['gambar']) }}" alt="motor" id="img-{{ $index }}">
          <div class="tanggal-sewa" id="tanggal-{{ $index }}">
            {{ date('d M Y', strtotime($motor['tanggal_sewa'])) }}
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<script>
function toggleTanggal(index) {
  const tanggalElement = document.getElementById('tanggal-' + index);
  const motorItem = tanggalElement.closest('.motor-item');
  
  // Toggle class show untuk menampilkan/menyembunyikan tanggal
  if (tanggalElement.classList.contains('show')) {
    hideTanggal(tanggalElement, motorItem);
  } else {
    // Sembunyikan tanggal lain yang sedang tampil
    hideAllDates();
    
    // Tampilkan tanggal yang diklik
    showTanggal(tanggalElement, motorItem);
    
    // Auto hide setelah 4 detik
    setTimeout(() => {
      if (tanggalElement.classList.contains('show')) {
        hideTanggal(tanggalElement, motorItem);
      }
    }, 4000);
  }
}

function showTanggal(tanggalElement, motorItem) {
  tanggalElement.classList.add('show');
  motorItem.classList.add('clicked');
  
  // Tambah efek bounce
  setTimeout(() => {
    tanggalElement.classList.add('bounce');
  }, 50);
  
  // Hapus efek bounce setelah animasi selesai
  setTimeout(() => {
    tanggalElement.classList.remove('bounce');
  }, 550);
}

function hideTanggal(tanggalElement, motorItem) {
  tanggalElement.classList.remove('show', 'bounce');
  motorItem.classList.remove('clicked');
}

function hideAllDates() {
  const allTanggal = document.querySelectorAll('.tanggal-sewa');
  const allMotorItems = document.querySelectorAll('.motor-item');
  
  allTanggal.forEach(tanggal => {
    tanggal.classList.remove('show', 'bounce');
  });
  
  allMotorItems.forEach(item => {
    item.classList.remove('clicked');
  });
}

// Event listener untuk menyembunyikan tanggal saat klik di luar
document.addEventListener('click', function(event) {
  if (!event.target.closest('.motor-item')) {
    hideAllDates();
  }
});

// Mencegah event bubbling pada gambar
document.querySelectorAll('.motor-item img').forEach(img => {
  img.addEventListener('click', function(event) {
    event.stopPropagation();
    const motorItem = this.closest('.motor-item');
    const index = Array.from(motorItem.parentNode.children).indexOf(motorItem);
    toggleTanggal(index);
  });
});
</script>

@endsection