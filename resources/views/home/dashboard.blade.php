@extends('index')

@section('content')

  <style>
    :root {
      --primary-yellow: #FFD700;
      --secondary-blue: #1E90FF;
      --accent-orange: #FF8C00;
    }

    body {
      font-family: 'Poppins', sans-serif;
    }


    .section-title-tentangkami {
      font-size: 2rem;
      font-weight: bold;
      color: #0466C8;
      margin-bottom: 20px;
    }

    .section-title {
      font-size: 2.9rem;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
    }

    .decorative-line {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 30px;
      margin-top: -5px;
    }

    .decorative-line::before,
    .decorative-line::after {
      content: '';
      flex: 1;
      height: 2px;
      background-color: var(--secondary-blue);
      max-width: 150px;
    }

    .decorative-line .dot {
      width: 16px;
      height: 16px;
      background-color: #FFF56C;
      border-radius: 50%;
      margin: 0 20px;
    }

    .section-description {
      font-size: 1rem;
      font-weight: 500;
      line-height: 1.6;
      color: #333333;
      max-width: 800px;
      margin: 0 auto;
      text-align: center;
    }

    .about-section {
      padding: 80px 0;
      background: #fff;
    }

    /* Carousel Container */
    .tentangkami-carousel-wrapper {
      position: relative;
      max-width: 100%;
      margin-top: 50px;
      overflow: hidden;
    }

    /* Carousel Track */
    .tentangkami-carousel {
      display: flex;
      transition: transform 0.8s ease-in-out;
      gap: 0;
    }

    /* Carousel Slide - Contains 3 photos */
    .carousel-slide {
      min-width: 100%;
      display: flex;
      justify-content: center;
      gap: 40px;
      padding: 10px;
      padding-bottom: 50px;
      box-sizing: border-box;
    }

    /* Individual Photo Card */
    .photo-card {
      flex: 1;
      max-width: 250px;
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .photo-card:hover {
      transform: translateY(-10px);
    }

    /* Image styling - ukuran asli dengan aspect ratio terjaga */
    .photo-card img {
      width: 100%;
      height: auto;
      min-height: 250px;
      max-height: none;
      object-fit: contain;
      display: block;
      background: #f8f9fa;
    }

    /* Carousel Navigation Buttons */
    .carousel-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255, 255, 255, 0.9);
      border: none;
      font-size: 2rem;
      color: var(--secondary-blue);
      z-index: 10;
      cursor: pointer;
      padding: 15px 20px;
      border-radius: 50%;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }

    .carousel-btn:hover {
      background: white;
      color: var(--accent-orange);
      transform: translateY(-50%) scale(1.1);
    }

    .carousel-btn.left {
      left: 20px;
    }

    .carousel-btn.right {
      right: 20px;
    }

    /* Carousel Indicators */
    .carousel-indicators {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 120px;
      padding-top: 30px;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .carousel-indicator {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #ddd;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .carousel-indicator.active {
      background: var(--secondary-blue);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .carousel-slide {
        flex-direction: column;
        align-items: center;
        gap: 25px;
        padding-bottom: 40px;
      }

      .photo-card {
        max-width: 90%;
      }

      .carousel-btn {
        padding: 10px 15px;
        font-size: 1.5rem;
      }

      .carousel-btn.left {
        left: 10px;
      }

      .carousel-btn.right {
        right: 10px;
      }

      .carousel-indicators {
        margin-top: 90px;
        padding-top: 25px;
      }
    }

    @media (max-width: 576px) {
      .carousel-slide {
        padding-bottom: 35px;
      }

      .photo-card img {
        min-height: 250px;
        object-fit: contain;
      }

      .carousel-indicators {
        margin-top: 70px;
        padding-top: 20px;
      }
    }

    body {
      font-family: 'Poppins', sans-serif;
    }

    /* Layout utama */
    .halaman-layanan-wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }

    .spacer-top {
      height: 80px;
      background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
    }

    .layanan-section {
      background: #ffffff;
      /* putih polos */
      padding: 80px 20px 120px 20px;
      color: #333;
      /* teks default hitam */
      flex-grow: 1;
      position: relative;
    }


    /* Background decorative elements */
    .layanan-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background:
        radial-gradient(circle at 20% 80%, rgba(255, 235, 59, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 235, 59, 0.1) 0%, transparent 50%);
      pointer-events: none;
    }

    .layanan-section h2 {
      font-family: 'Poppins', sans-serif;
      font-weight: bold;
      color: #0466C8;
      text-align: center;
      margin-bottom: 20px;
      font-size: 2rem;
      position: relative;
      animation: fadeInDown 1s ease-out;
    }



    .layanan-container {
      max-width: 1100px;
      margin: 30px auto 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 40px;
    }

    .layanan-row {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .layanan-card {
      background: linear-gradient(145deg, #ffffff, #f8f9fa);
      color: #333;
      width: 300px;
      border-radius: 20px;
      padding: 30px 25px;
      box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.1),
        0 4px 15px rgba(0, 0, 0, 0.05);
      text-align: center;
      position: relative;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      transform: translateY(0);
      opacity: 0;
      animation: cardFadeInUp 0.8s ease-out forwards;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .layanan-card:nth-child(1) {
      animation-delay: 0.2s;
    }

    .layanan-card:nth-child(2) {
      animation-delay: 0.4s;
    }

    .layanan-card:nth-child(3) {
      animation-delay: 0.6s;
    }

    .layanan-card:nth-child(4) {
      animation-delay: 0.8s;
    }

    .layanan-card:nth-child(5) {
      animation-delay: 1s;
    }

    .layanan-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, #FFEB3B, #FDD835);
      border-radius: 20px 20px 0 0;
      transform: scaleX(0);
      transition: transform 0.3s ease-out;
    }


    .layanan-card:hover::before {
      transform: scaleX(1);
    }

    .icon-container {
      background: linear-gradient(135deg, #FFEB3B 0%, #FDD835 50%, #F9A825 100%);
      border-radius: 50%;
      width: 80px;
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 25px;
      box-shadow:
        0 8px 25px rgba(255, 235, 59, 0.4),
        inset 0 2px 4px rgba(255, 255, 255, 0.3);
      position: relative;
      transition: all 0.3s ease-out;
    }

    .icon-container::before {
      content: '';
      position: absolute;
      top: -3px;
      left: -3px;
      right: -3px;
      bottom: -3px;
      background: linear-gradient(135deg, #FFEB3B, #FDD835);
      border-radius: 50%;
      z-index: -1;
      opacity: 0;
      transition: opacity 0.3s ease-out;
    }

    .layanan-card:hover .icon-container {
      transform: scale(1.1);

    }

    .layanan-card:hover .icon-container::before {
      opacity: 0.7;
    }

    .icon-container iconify-icon {
      font-size: 36px;
      color: #0466C8;
      transition: all 0.3s ease-out;
    }

    .layanan-card:hover .icon-container iconify-icon {
      transform: scale(1.1);
      color: #034078;
    }

    .layanan-card h5 {
      font-size: 1.3rem;
      font-weight: 700;
      margin-bottom: 15px;
      color: #2C5282;
      transition: color 0.3s ease-out;
    }

    .layanan-card:hover h5 {
      color: #1A365D;
    }

    .layanan-card p {
      font-size: 0.95rem;
      line-height: 1.6;
      color: #666;
      margin: 0;
      transition: color 0.3s ease-out;
    }

    .layanan-card:hover p {
      color: #555;
    }

    .spacer-footer {
      height: 80px;
      background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
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

    @keyframes slideIn {
      from {
        width: 0;
        opacity: 0;
      }

      to {
        width: 80px;
        opacity: 1;
      }
    }

    @keyframes cardFadeInUp {
      from {
        opacity: 0;
        transform: translateY(50px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes pulse {

      0%,
      100% {
        box-shadow:
          0 8px 25px rgba(255, 235, 59, 0.4),
          inset 0 2px 4px rgba(255, 255, 255, 0.3);
      }

      50% {
        box-shadow:
          0 12px 35px rgba(255, 235, 59, 0.6),
          inset 0 2px 4px rgba(255, 255, 255, 0.3);
      }
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-10px);
      }
    }

    /* Scroll animations */
    @media (prefers-reduced-motion: no-preference) {
      .layanan-card {
        animation: cardFadeInUp 0.8s ease-out forwards;
      }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .layanan-section {
        padding: 60px 15px 100px 15px;
      }

      .layanan-section h2 {
        font-size: 2rem;
        margin-bottom: 20px;
      }

      .layanan-card {
        width: 100%;
        max-width: 320px;
        padding: 25px 20px;
      }

      .icon-container {
        width: 70px;
        height: 70px;
      }

      .icon-container iconify-icon {
        font-size: 32px;
      }

      .spacer-top {
        height: 60px;
      }

      .spacer-footer {
        height: 60px;
      }

      .layanan-container {
        gap: 25px;
      }

      .layanan-row {
        gap: 20px;
      }
    }

    @media (max-width: 480px) {
      .layanan-section {
        padding: 40px 10px 80px 10px;
      }

      .layanan-section h2 {
        font-size: 1.8rem;
        margin-bottom: 20px;
      }

      .layanan-card {
        padding: 20px 15px;
      }

      .spacer-top {
        height: 50px;
      }
    }

    /* Accessibility improvements */
    @media (prefers-reduced-motion: reduce) {
      * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
    }

    /* Focus states for accessibility */
    .layanan-card:focus-within {
      outline: 3px solid #FFEB3B;
      outline-offset: 2px;
    }


    .section-title {
      font-size: 2rem;
      font-weight: 700;
      text-align: center;
      color: #FFF56C;
      margin-bottom: 40px;
    }

    .wisata-section {
      padding: 80px 0;
      background-color: #fff;
      overflow: hidden;
      /* Mencegah overflow horizontal */
    }

    .judul-wisata {
      font-size: 32px;
      font-weight: bold;
      color: #0052A0;
    }

    .subjudul-wisata {
      font-size: 24px;
      font-weight: bold;
      color: #F7C200;
      margin-top: 10px;
    }

    /* Styling untuk garis dekoratif */
    .garis-destinasi {
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 30px 0 50px;
    }

    .garis {
      height: 2px;
      width: 80px;
      background-color: #007BBD;
    }

    .titik {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background-color: #F7C200;
      margin: 0 15px;
    }

    /* Perbaikan untuk carousel container */
    #wisataCarousel {
      margin: 0 auto;
      max-width: 1200px;
      padding: 0 40px;
      /* Tambah padding untuk ruang carousel controls */
    }

    .carousel-inner {
      padding: 20px 0;
      /* Tambah padding vertikal */
    }

    /* Perbaikan untuk row dan kolom */
    .carousel-item .row {
      margin: 0 -10px;
      /* Negatif margin untuk mengkompensasi padding kolom */
    }

    .carousel-item [class*="col-"] {
      padding: 0 10px;
      /* Padding horizontal untuk spacing antar card */
    }

    .card-wrapper {
      position: relative;
      height: 100%;
      max-width: 300px;
      /* Sedikit lebih besar */
      margin: 0 auto;
    }

    .card-back {
      position: absolute;
      top: 12px;
      left: 12px;
      width: calc(100% - 12px);
      /* Perbaikan width agar tidak overflow */
      height: 100%;
      border-radius: 20px;
      background-color: #007BBD;
      z-index: 0;
    }

    .wisata-card {
      background-color: #FEF16C;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      height: 100%;
      position: relative;
      z-index: 1;
      transition: transform 0.3s ease;
      min-height: 450px;
      /* Minimum height untuk konsistensi */
    }

    .wisata-card:hover {
      transform: translateY(-6px);
    }

    .wisata-card img {
      width: 100%;
      height: 160px;
      /* Sedikit lebih tinggi */
      object-fit: cover;
    }

    .wisata-card-body {
      padding: 18px;
      /* Sedikit lebih besar */
      background-color: #FEF16C;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .wisata-card-body h5 {
      font-size: 16px;
      /* Sedikit lebih besar */
      margin-bottom: 8px;
      color: #000;
      font-weight: 600;
      line-height: 1.3;
    }

    .wisata-card-body p {
      color: #222;
      font-size: 14px;
      /* Sedikit lebih besar */
      margin-bottom: 12px;
      flex-grow: 1;
      line-height: 1.5;
    }

    .lokasi {
      font-size: 12px;
      color: #333;
      margin-top: auto;
      padding-top: 12px;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .lokasi i {
      margin-right: 6px;
      color: #000;
    }

    .lokasi a {
      color: #000;
      text-decoration: none;
      line-height: 1.4;
    }

    .blog-meta {
      font-size: 11px;
      color: #666;
      margin-top: 8px;
      padding-top: 8px;
      border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .blog-meta i {
      margin-right: 4px;
      color: #888;
    }

    .lokasi a:hover {
      text-decoration: underline;
    }

    /* Perbaikan carousel controls - posisi berdasarkan area gambar */
    .carousel-control-prev,
    .carousel-control-next {
      width: 50px;
      height: 50px;
      top: 160px;
      /* Sesuaikan dengan tinggi gambar (160px) + padding atas card */
      transform: translateY(-50%);
      background-color: #fff;
      border-radius: 50%;
      opacity: 0.8;
      transition: all 0.3s ease;
      border: none;
    }

    .carousel-control-prev {
      left: -10px;
      /* Posisi di dalam padding area */
    }

    .carousel-control-next {
      right: -10px;
      /* Posisi di dalam padding area */
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
      opacity: 1;
      background-color: #fff;
    }

    .carousel-control-prev:focus,
    .carousel-control-next:focus {
      opacity: 1;
      background-color: #fff;
    }

    /* Custom icons untuk carousel controls */
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      display: none;
    }

    .carousel-custom-icon {
      color: white;
      font-size: 18px;
      font-weight: bold;
    }

    /* Media queries untuk responsivitas */
    @media (max-width: 1200px) {
      #wisataCarousel {
        padding: 0 30px;
      }

      .card-wrapper {
        max-width: 280px;
      }

      .carousel-control-prev,
      .carousel-control-next {
        top: 150px;
        /* Adjust untuk mobile */
      }
    }

    @media (max-width: 992px) {
      #wisataCarousel {
        padding: 0 20px;
      }

      .wisata-card {
        min-height: 420px;
      }

      .wisata-card img {
        height: 140px;
      }

      .wisata-card-body {
        padding: 16px;
      }

      .wisata-card-body h5 {
        font-size: 16px;
      }

      .wisata-card-body p {
        font-size: 13px;
      }

      .carousel-control-prev,
      .carousel-control-next {
        top: 140px;
        /* Sesuaikan dengan tinggi gambar di tablet */
      }
    }

    @media (max-width: 768px) {
      #wisataCarousel {
        padding: 0 15px;
      }

      .carousel-control-prev,
      .carousel-control-next {
        width: 40px;
        height: 40px;
        top: 130px;
        /* Sesuaikan dengan tinggi gambar di mobile */
      }

      .carousel-custom-icon {
        font-size: 16px;
      }

      .carousel-control-prev {
        left: -5px;
      }

      .carousel-control-next {
        right: -5px;
      }

      .card-wrapper {
        max-width: 250px;
      }

      .wisata-card {
        min-height: 400px;
      }

      .judul-wisata {
        font-size: 28px;
      }

      .subjudul-wisata {
        font-size: 20px;
      }

      .blog-meta {
        font-size: 10px;
      }
    }

    @media (max-width: 576px) {
      #wisataCarousel {
        padding: 0 10px;
      }

      .carousel-control-prev,
      .carousel-control-next {
        display: none;
        /* Sembunyikan di mobile kecil */
      }

      .card-wrapper {
        max-width: 280px;
      }

      .carousel-item [class*="col-"] {
        padding: 0 8px;
      }

      .carousel-item .row {
        margin: 0 -8px;
      }

      .wisata-card {
        min-height: 380px;
      }

      .wisata-card-body {
        padding: 14px;
      }

      .judul-wisata {
        font-size: 24px;
      }

      .subjudul-wisata {
        font-size: 18px;
      }

      .blog-meta {
        font-size: 9px;
      }
    }

    /* Tambahan untuk memastikan tidak ada overflow */
    .container {
      overflow: hidden;
    }

    .row {
      overflow: visible;
    }

     .testimoni-section {
            padding: 80px 0 120px 0;
            background: #fff;
            position: relative;
            overflow: hidden;
            color: #333;
            margin: 60px 0 0 0;
            border-radius: 0;
            width: 100%;
        }

        .testimoni-section .container {
            position: relative;
            z-index: 2;
            max-width: 1200px;
        }

        .testimoni-title {
            color: #0466C8;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .testimoni-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            font-weight: 400;
            margin-bottom: 0;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }



        .testimoni-card {
            background: #ffffff;
            color: #333;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 2px solid #f8f9fa;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
            min-height: 300px;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .testimoni-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(4, 102, 200, 0.12), 0 8px 25px rgba(4, 102, 200, 0.08);
            border-color: #0466C8;
        }

        .user-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            margin-right: 15px;
            border: 3px solid #0466C8;
            transition: all 0.3s ease;
        }

        .testimoni-card:hover .user-avatar {
            transform: scale(1.05);
            border-color: #FFD700;
        }

        .user-info h3 {
            color: #0466C8;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-info .date {
            color: #6c757d;
            font-size: 14px;
        }

        .stars {
            margin-bottom: 20px;
            display: flex;
            gap: 4px;
            justify-content: flex-start;
        }

        .stars iconify-icon {
            font-size: 18px;
            color: #FFD700;
            filter: drop-shadow(0 2px 4px rgba(255, 215, 0, 0.3));
            transition: transform 0.2s ease;
        }

        .testimoni-card:hover .stars iconify-icon {
            transform: scale(1.1);
        }

        .testimonial-text {
            color: #475569;
            line-height: 1.6;
            font-size: 16px;
            font-style: italic;
            position: relative;
            padding-left: 20px;
            border-left: 4px solid #e2e8f0;
            margin-bottom: 0;
            text-align: justify;
        }

        .testimonial-text::before {
            content: '"';
            position: absolute;
            left: -10px;
            top: -10px;
            font-size: 40px;
            color: #3b82f6;
            opacity: 0.3;
        }

        @media (max-width: 992px) {
            .testimoni-section {
                padding: 60px 0 100px 0;
                margin: 50px 0 0 0;
            }
            .testimoni-title {
                font-size: 2.2rem;
                margin-bottom: 0.8rem;
            }
            .testimoni-subtitle {
                font-size: 1rem;
                margin-bottom: 3rem;
            }
            .testimoni-card {
                padding: 25px;
                min-height: 280px;
            }
        }

        @media (max-width: 768px) {
            .testimoni-section {
                padding: 50px 0 80px 0;
                margin: 40px 0 0 0;
            }
            .testimoni-title {
                font-size: 2rem;
                margin-bottom: 0.8rem;
            }
            .testimoni-subtitle {
                font-size: 0.95rem;
                margin-bottom: 2.5rem;
            }
            .testimoni-card {
                padding: 22px;
                min-height: 260px;
                margin-bottom: 20px;
            }
            .testimonial-text {
                font-size: 15px;
            }
            .user-avatar {
                width: 50px;
                height: 50px;
                font-size: 16px;
            }
        }

        @media (max-width: 576px) {
            .testimoni-section {
                padding: 40px 0 70px 0;
                margin: 30px 0 0 0;
            }
            .testimoni-title {
                font-size: 1.8rem;
                margin-bottom: 0.5rem;
            }
            .testimoni-subtitle {
                font-size: 0.9rem;
                margin-bottom: 2rem;
            }
            .testimoni-card {
                padding: 20px;
                min-height: 240px;
            }
            .testimonial-text {
                font-size: 14px;
                line-height: 1.5;
            }
            .user-avatar {
                width: 45px;
                height: 45px;
                font-size: 14px;
                border-width: 2px;
            }
            .user-info h3 {
                font-size: 16px;
            }
        }

    .avatar-img {
      width: 45px;
      height: 45px;
    }

    .avatar-img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #FFD700;
    }


    .btn-sewa {
      background: var(--secondary-blue);
      border: none;
      border-radius: 20px;
      /* Reduced from 25px */
      color: white;
      font-weight: bold;
      padding: 12px 30px;
      /* Reduced from 15px 40px */
      font-size: 16px;
      /* Reduced from 18px */
      transition: all 0.3s ease;
    }

    .btn-sewa:hover {
      background: #1873CC;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(30, 144, 255, 0.25);
      /* Reduced shadow */
    }

    .wisata-subtitle {
      color: var(--accent-orange);
      font-size: 1.6rem;
      /* Reduced from 1.8rem */
      font-weight: 600;
      margin-bottom: 30px;
      /* Reduced from 40px */
    }

    .motor-section {
      padding: 45px 0;
      /* Further reduced from 60px */
      background: #ffffff;
    }

    .motor-section .section-title {
      font-weight: bold;
      font-size: 2rem;
      color: #0466C8;
      margin-bottom: 20px;
    }

    .motor-grid-container {
      max-width: 1000px;
      /* Further reduced from 1200px */
      margin: 30px auto 0;
      padding: 0 15px;
      /* Reduced padding */
    }

    .motor-row {
      display: flex;
      justify-content: center;
      gap: 1.5rem;
      /* Further reduced from 2rem */
      margin-bottom: 1.5rem;
      /* Further reduced from 2rem */
    }

    .motor-card {
      background: white;
      border-radius: 14px;
      /* Further reduced from 16px */
      box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.08);
      /* Further reduced shadow */
      transition: transform 0.3s ease;
      overflow: hidden;
      width: 260px;
      /* Further reduced from 320px */
      flex-shrink: 0;
      position: relative;
    }

    .motor-card:hover {
      transform: translateY(-2px);
      /* Further reduced from -3px */
    }

    .motor-card img {
      width: 100%;
      height: auto;
      object-fit: contain;
      display: block;
      background: #f8f9fa;
      min-height: 220px;
      /* Further reduced from 280px */
    }

    .motor-info {
      padding: 15px;
      text-align: center;
      background: white;
      border-bottom-left-radius: 14px;
      border-bottom-right-radius: 14px;
    }

    .motor-info h5 {
      font-size: 1.1rem;
      font-weight: 600;
      color: #333;
      margin-bottom: 8px;
      margin-top: 0;
    }

    .motor-info p {
      font-size: 1rem;
      font-weight: 700;
      color: #0466C8;
      margin-bottom: 0;
    }

    .motor-price {
      background: #FF3D00;
      color: white;
      font-weight: bold;
      font-size: 12px;
      /* Further reduced from 13px */
      text-align: center;
      padding: 6px;
      /* Further reduced from 8px */
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      border-bottom-left-radius: 14px;
      /* Adjusted to match card radius */
      border-bottom-right-radius: 14px;
      /* Adjusted to match card radius */
    }

    .btn-sewa {
      background-color: #0074e0;
      color: white;
      border-radius: 25px;
      /* Reduced from 999px for more compact look */
      padding: 12px 32px;
      /* Reduced from 15px 40px */
      font-weight: bold;
      font-size: 16px;
      /* Reduced from 18px */
      border: none;
      box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.15);
      /* Reduced shadow */
      transition: all 0.3s ease;
    }

    .btn-sewa:hover {
      background-color: #005bb5;
      transform: translateY(-2px);
      /* Reduced from -3px */
      box-shadow: 0 6px 20px rgba(0, 116, 224, 0.25);
      /* Reduced shadow */
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .motor-card {
        width: 300px;
        /* Reduced from 350px */
      }

      .motor-row {
        gap: 1.8rem;
        /* Reduced from 2rem */
      }

      .motor-card img {
        min-height: 260px;
        /* Reduced from 300px */
      }
    }

    @media (max-width: 768px) {
      .motor-section {
        padding: 50px 0;
        /* Reduced from 60px */
      }

      .motor-row {
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
        /* Reduced from 2rem */
      }

      .motor-card {
        width: 85%;
        /* Reduced from 90% */
        max-width: 350px;
        /* Reduced from 400px */
      }

      .motor-card img {
        min-height: 240px;
        /* Reduced from 280px */
      }

      .motor-info {
        padding: 12px;
      }

      .motor-info h5 {
        font-size: 1rem;
      }

      .motor-info p {
        font-size: 0.9rem;
      }

      .btn-sewa {
        padding: 10px 28px;
        /* Further reduced for mobile */
        font-size: 15px;
        /* Reduced for mobile */
      }
    }

    @media (max-width: 576px) {
      .motor-section {
        padding: 40px 0;
        /* Further reduced */
      }

      .motor-card {
        width: 90%;
        /* Adjusted from 95% */
        max-width: 320px;
        /* Reduced from 380px */
      }

      .motor-card img {
        height: auto;
        min-height: 220px;
        /* Reduced from 260px */
      }

      .motor-info {
        padding: 10px;
      }

      .motor-info h5 {
        font-size: 0.95rem;
      }

      .motor-info p {
        font-size: 0.85rem;
      }

      .motor-price {
        font-size: 12px;
        /* Further reduced */
        padding: 6px;
        /* Further reduced */
      }

      .btn-sewa {
        padding: 10px 25px;
        /* Further reduced for small mobile */
        font-size: 14px;
        /* Further reduced */
      }
    }

    .garis-destinasi {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: 20px;
      margin-bottom: 40px;
    }

    .garis-destinasi .garis {
      width: 320px;
      /* Ubah nilai ini untuk mengatur panjang garis kiri & kanan */
      height: 1px;
      background-color: #2196f3;
    }

    .garis-destinasi .titik {
      width: 14px;
      height: 14px;
      background-color: #0d6efd;
      border-radius: 50%;
      margin: 0 12px;
      /* Jarak antara garis dan titik */
    }

   .carousel-control-prev,
.carousel-control-next {
  top: 50%; /* posisikan di tengah vertikal */
  transform: translateY(-50%);
  align-items: center;
  justify-content: center;
}

.carousel-control-prev {
  left: -30px; /* geser lebih ke dalam, bisa 10px, 20px, dll */
}

.carousel-control-next {
  right: -30px; /* geser lebih ke dalam */
}

.carousel-custom-icon {
  color: black;
  font-size: 2rem;
  font-weight: bold;
}


  </style>

  <!-- Tentang Kami -->
  <section class="about-section">
    <div class="container">
      <div class="text-center">
        <h2 class="section-title-tentangkami">Tentang Kami</h2>
        <div class="decorative-line">
          <div class="dot"></div>
        </div>
        <p class="section-description">
          Rental Motor Majestic adalah pilihan tepat untuk Anda yang ingin menyewa motor<br>
          dengan nyaman dan aman. Kami menyediakan motor yang selalu dirawat dengan baik, proses sewa yang mudah,
          serta fasilitas lengkap seperti helm <br> dan jas hujan. Dengan pelayanan yang ramah dan harga<br> yang
          terjangkau,
          kami siap mendukung setiap perjalanan Anda.
        </p>
      </div>

      <div class="tentangkami-carousel-wrapper">
        <div class="tentangkami-carousel" id="tentangKamiCarousel">
          <!-- Slide 1 -->
          <div class="carousel-slide">
            <div class="photo-card">
              <img src="{{ asset('assets/images/g1.jpg') }}" alt="Motor 1">
            </div>
            <div class="photo-card">
              <img src="{{ asset('assets/images/g2.jpg') }}" alt="Motor 2">
            </div>
            <div class="photo-card">
              <img src="{{ asset('assets/images/g3.jpg') }}" alt="Motor 3">
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="carousel-slide">
            <div class="photo-card">
              <img src="{{ asset('assets/images/g4.jpg') }}" alt="Motor 4">
            </div>
            <div class="photo-card">
              <img src="{{ asset('assets/images/g5.jpg') }}" alt="Motor 5">
            </div>
            <div class="photo-card">
              <img src="{{ asset('assets/images/g6.png') }}" alt="Motor 6">
            </div>
          </div>
        </div>

        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
          <div class="carousel-indicator active" onclick="goToSlide(0)"></div>
          <div class="carousel-indicator" onclick="goToSlide(1)"></div>
        </div>
      </div>
    </div>
  </section>

  <script>
    let currentSlide = 0;
    const totalSlides = 2; // Jumlah slide yang ada

    function showSlide(slideIndex) {
      const carousel = document.getElementById('tentangKamiCarousel');
      const indicators = document.querySelectorAll('.carousel-indicator');

      // Update slide position
      carousel.style.transform = `translateX(-${slideIndex * 100}%)`;

      // Update indicators
      indicators.forEach((indicator, index) => {
        indicator.classList.toggle('active', index === slideIndex);
      });

      currentSlide = slideIndex;
    }

    function nextSlide() {
      currentSlide = (currentSlide + 1) % totalSlides;
      showSlide(currentSlide);
      resetAutoPlay(); // Reset auto-play timer when manually navigating
    }

    function prevSlide() {
      currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
      showSlide(currentSlide);
      resetAutoPlay(); // Reset auto-play timer when manually navigating
    }

    function goToSlide(slideIndex) {
      showSlide(slideIndex);
      resetAutoPlay(); // Reset auto-play timer when manually navigating
    }

    // Auto-play carousel
    let autoPlayInterval;

    function startAutoPlay() {
      autoPlayInterval = setInterval(nextSlide, 2500); // Ganti slide setiap 2.5 detik (lebih cepat)
    }

    function stopAutoPlay() {
      clearInterval(autoPlayInterval);
    }

    function resetAutoPlay() {
      stopAutoPlay();
      startAutoPlay();
    }

    // Start auto-play when page loads
    startAutoPlay();

    // Stop auto-play when user interacts, then restart after delay
    document.querySelector('.tentangkami-carousel-wrapper').addEventListener('mouseenter', stopAutoPlay);
    document.querySelector('.tentangkami-carousel-wrapper').addEventListener('mouseleave', startAutoPlay);

    // Touch/swipe support for mobile
    let startX = 0;
    let endX = 0;

    document.getElementById('tentangKamiCarousel').addEventListener('touchstart', function (e) {
      startX = e.changedTouches[0].screenX;
    });

    document.getElementById('tentangKamiCarousel').addEventListener('touchend', function (e) {
      endX = e.changedTouches[0].screenX;
      handleSwipe();
    });

    function handleSwipe() {
      const threshold = 50; // Minimum swipe distance
      const diff = startX - endX;

      if (Math.abs(diff) > threshold) {
        if (diff > 0) {
          nextSlide(); // Swipe left - go to next slide
        } else {
          prevSlide(); // Swipe right - go to previous slide
        }
        resetAutoPlay(); // Reset auto-play timer after swipe
      }
    }
  </script>

  <!-- Section layanan -->
  <section class="layanan-section">
    <h2>Fasilitas Layanan Kami</h2>
    <div class="decorative-line">
      <div class="dot"></div>
    </div>
    <div class="layanan-container">
      <div class="layanan-row">
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:helmet"></iconify-icon>
          </div>
          <h5>Fasilitas 2 Helm</h5>
          <p>Setiap sewa motor dilengkapi 2 helm standar demi keselamatan berkendara yang optimal.</p>
        </div>
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="wi:rain"></iconify-icon>
          </div>
          <h5>Fasilitas 2 Jas Hujan</h5>
          <p>Kami sediakan jas hujan berkualitas untuk mendukung kenyamanan Anda di segala cuaca.</p>
        </div>
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:motorbike"></iconify-icon>
          </div>
          <h5>Motor Terjamin</h5>
          <p>Motor selalu dalam kondisi prima karena rutin dirawat, demi kenyamanan dan keamanan Anda.</p>
        </div>
      </div>

      <div class="layanan-row">
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:handshake"></iconify-icon>
          </div>
          <h5>Pelayanan Ramah</h5>
          <p>Kami melayani dengan sepenuh hati, ramah, profesional, dan dapat dipercaya sepenuhnya.</p>
        </div>
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:cash"></iconify-icon>
          </div>
          <h5>Harga Sewa Terjangkau</h5>
          <p>Nikmati tarif sewa yang ramah di kantong dengan pilihan motor sesuai kebutuhan Anda.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Sewa Motor Sekarang -->
  <section class="motor-section">
    <div class="container">
      <h2 class="section-title text-center">Sewa Motor Sekarang</h2>
      <div class="decorative-line">
        <div class="dot"></div>
      </div>
      <div class="motor-grid-container">
        <!-- Top row - 3 motorcycles -->
        <div class="motor-row motor-row-top">
          @if($motors->count() > 0)
            @foreach($motors->take(3) as $motor)
              <div class="motor-card" onclick="window.location.href='/motor/{{ $motor->id }}'" style="cursor: pointer;">
                @if($motor->foto)
                  <img src="{{ asset('storage/' . $motor->foto) }}" alt="{{ $motor->merk }} {{ $motor->model }}">
                @else
                  <img src="{{ asset('assets/images/motor1.jpg') }}" alt="{{ $motor->merk }} {{ $motor->model }}">
                @endif
                <div class="motor-info">
                  <h5>{{ $motor->merk }} {{ $motor->model }}</h5>
                  <p>Rp {{ number_format($motor->harga_per_hari, 0, ',', '.') }}/hari</p>
                </div>
              </div>
            @endforeach
          @else
            @for ($i = 1; $i <= 3; $i++)
              <div class="motor-card" style="cursor: pointer;">
                <img src="{{ asset("assets/images/motor{$i}.jpg") }}" alt="Motor {{ $i }}">
                <div class="motor-info">
                  <h5>Motor Sample {{ $i }}</h5>
                  <p>Rp 75.000/hari</p>
                </div>
              </div>
            @endfor
          @endif
        </div>


      </div>
      <div class="text-center mt-5">
        <button class="btn btn-sewa btn-lg" onclick="window.location.href='/harga_sewa'">NEXT</button>
      </div>
    </div>
  </section>

  <!-- Rekomendasi Destinasi Wisata -->
  <section class="wisata-section">
    <div class="container">
      <h2 class="text-center judul-wisata">Rekomendasi Destinasi Wisata</h2>
      <h3 class="text-center subjudul-wisata">Malang & Batu</h3>

      <!-- Garis dan Titik Dekoratif -->
      <div class="garis-destinasi">
        <div class="garis"></div>
        <div class="titik"></div>
        <div class="garis"></div>
      </div>

      <!-- CAROUSEL -->
      <div id="wisataCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

          @if($blogs->count() > 0)
            @php
              $blogsChunked = $blogs->chunk(3);
            @endphp
            
            @foreach($blogsChunked as $index => $blogChunk)
              <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <div class="row justify-content-center g-4">
                  @foreach($blogChunk as $blog)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                      <div class="card-wrapper">
                        <div class="card-back"></div>
                        <div class="wisata-card d-flex flex-column h-100">
                          @if($blog->gambar)
                            <img src="{{ asset('storage/' . $blog->gambar) }}" alt="{{ $blog->judul }}">
                          @else
                            <img src="{{ asset('assets/images/default-blog.jpg') }}" alt="{{ $blog->judul }}">
                          @endif
                          <div class="wisata-card-body">
                            <h5>{{ $blog->judul }}</h5>
                            <p>{{ Str::limit(strip_tags($blog->isi), 150) }}</p>
                            @if($blog->lokasi)
                              <p class="lokasi">
                                <i class="fa-solid fa-location-dot"></i>
                                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($blog->lokasi) }}" target="_blank">
                                  {{ $blog->lokasi }}
                                </a>
                              </p>
                            @endif
                            <div class="blog-meta mt-2">
                              <small class="text-muted">
                                <i class="fas fa-user"></i> {{ $blog->penulis ?? 'Admin' }} | 
                                <i class="fas fa-calendar"></i> {{ $blog->created_at->format('M d, Y') }}
                              </small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          @else
            <!-- Fallback jika tidak ada blog -->
            <div class="carousel-item active">
              <div class="row justify-content-center g-4">
                <div class="col-lg-6 col-md-8">
                  <div class="text-center py-5">
                    <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada artikel blog</h5>
                    <p class="text-muted">Artikel blog akan ditampilkan di sini setelah admin menambahkannya.</p>
                  </div>
                </div>
              </div>
            </div>
          @endif

        </div>
        <!-- tombol prev & next - hanya tampil jika ada lebih dari 1 slide -->
        @if($blogs->count() > 3)
          <button class="carousel-control-prev" type="button" data-bs-target="#wisataCarousel" data-bs-slide="prev">
            <span class="carousel-custom-icon">&#10094;</span> <!-- panah kiri -->
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#wisataCarousel" data-bs-slide="next">
            <span class="carousel-custom-icon">&#10095;</span> <!-- panah kanan -->
          </button>
        @endif

    
        <script>
          document.addEventListener('DOMContentLoaded', function () {
            // Add animation on scroll
            const observerOptions = {
              threshold: 0.1,
              rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
              entries.forEach(entry => {
                if (entry.isIntersecting) {
                  entry.target.style.opacity = '1';
                  entry.target.style.transform = 'translateY(0)';
                }
              });
            }, observerOptions);

            // Apply animation to cards
            document.querySelectorAll('.facility-card, .motor-card, .wisata-card, .testimoni-card').forEach(el => {
              el.style.opacity = '0';
              el.style.transform = 'translateY(30px)';
              el.style.transition = 'all 0.6s ease';
              observer.observe(el);
            });

            // Button SEWA click handler
            document.querySelector('.btn-sewa')?.addEventListener('click', function () {
              // Redirect ke halaman login atau register
              window.location.href = "{{ route('login') }}";
            });
          });
        </script>

@endsection