<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer Sewa Motor Malang</title>
  <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
  <style>
    /* CSS sama seperti sebelumnya, tidak diubah */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fff;
      color: white;
      line-height: 1.5;
    }

    .footer {
      background-color: #000;
      padding: 35px 20px 25px;
      color: white;
      margin-bottom: -20px;
    }

    .footer-container {
      max-width: 1100px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.5fr 1fr 1fr 1fr;
      gap: 30px;
      align-items: start;
    }

    .footer-section {
      text-align: left;
    }

    .footer-section h3 {
      color: #FFC107;
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 18px;
      position: relative;
      letter-spacing: 0.3px;
    }

    .footer-section h3::after {
      content: '';
      position: absolute;
      bottom: -6px;
      left: 0;
      width: 40px;
      height: 2px;
      background-color: #FFC107;
    }

    .contact-item {
      display: flex;
      align-items: flex-start;
      margin-bottom: 14px;
      font-size: 13px;
    }

    .contact-icon {
      width: 28px;
      height: 28px;
      background-color: #FFC107;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 10px;
      flex-shrink: 0;
    }

    .contact-text {
      color: #e0e0e;
      font-size: 13px;
    }

    .footer-section ul {
      list-style: none;
      padding: 0;
    }

    .footer-section ul li {
      margin-bottom: 10px;
      font-size: 13px;
      display: flex;
      align-items: center;
    }

    .footer-section ul li::before {
      content: '▷';
      color: #FFC107;
      margin-right: 8px;
      font-size: 12px;
      font-weight: bold;
    }

    .footer-section ul li a {
      color: #e0e0e0;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .footer-section ul li a:hover {
      color: #FFC107;
    }

    .map-container {
      width: 100%;
      height: 160px;
      background: #1a1a1a;
      border-radius: 6px;
      position: relative;
      overflow: hidden;
      border: 1px solid #333;
      box-shadow: 0 2px 8px rgba(0,0,0,0.3);
      margin-top: 5px;
    }

    .map-pin {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: rotate(-45deg) translate(-50%, -50%);
      transform-origin: 0 0;
      width: 24px;
      height: 24px;
      background-color: #FF0000;
      border-radius: 50% 50% 50% 0;
      box-shadow: 0 2px 8px rgba(255, 0, 0, 0.4);
      animation: pulse 2s infinite;
    }

    .map-pin::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 8px;
      height: 8px;
      background-color: white;
      border-radius: 50%;
    }

    @keyframes pulse {
      0% { transform: rotate(-45deg) translate(-50%, -50%) scale(1); }
      50% { transform: rotate(-45deg) translate(-50%, -50%) scale(1.1); }
      100% { transform: rotate(-45deg) translate(-50%, -50%) scale(1); }
    }

    .follow-section {
      max-width: 1100px;
      margin: 0 auto;
      padding: 20px 20px 0;
      border-top: 1px solid #333;
    }

    .social-icons {
      display: flex;
      gap: 10px;
      margin-top: 15px;
    }

    .social-icon {
      width: 34px;
      height: 34px;
      background-color: #FFC107;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #000;
      font-size: 20px;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 2px 6px rgba(255, 193, 7, 0.3);
    }

    .social-icon:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(255, 193, 7, 0.4);
    }

    .copyright {
      background-color: #FFC107;
      color: #000;
      text-align: center;
      padding: 12px;
      font-size: 13px;
      font-weight: 600;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-section">
        <h3>Alamat Kami</h3>
        <div class="contact-item">
          <div class="contact-icon">
            <iconify-icon icon="mdi:map-marker" width="16" height="16" style="color: black;"></iconify-icon>
          </div>
          <div class="contact-text">Gg. Kaserin M U, Lesanpuro, Kec. Kedungkandang, Kota Malang, Jawa Timur 65138</div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">
            <iconify-icon icon="mdi:clock-outline" width="16" height="16" style="color: black;"></iconify-icon>
          </div>
          <div class="contact-text">07.00 - 21.00 WIB</div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">
            <iconify-icon icon="mdi:phone" width="16" height="16" style="color: black;"></iconify-icon>
          </div>
          <div class="contact-text">0851-0547-4050</div>
        </div>
        <div class="contact-item">
          <div class="contact-icon">
            <iconify-icon icon="mdi:email" width="16" height="16" style="color: black;"></iconify-icon>
          </div>
          <div class="contact-text">majestictransport@gmail.com</div>
        </div>
      </div>

      <div class="footer-section">
        <h3>Sewa Motor</h3>
        <ul>
          <li><a href="#">Beat Deluxe</a></li>
          <li><a href="#">Genio</a></li>
          <li><a href="#">Scoopy</a></li>
          <li><a href="#">Vario</a></li>
          <li><a href="#">Fazio</a></li>
          <li><a href="#">CRF</a></li>
        </ul>
      </div>

      <div class="footer-section">
        <h3>Quick Link</h3>
        <ul>
          <li><a href="#">Harga Sewa</a></li>
          <li><a href="#">Layanan</a></li>
          <li><a href="#">Tentang Kami</a></li>
          <li><a href="#">Testimonial</a></li>
        </ul>
      </div>

      <div class="footer-section">
  <div class="footer-section">
  <h3>Lokasi Kami</h3>
  <div class="map-container" style="position: relative; width: 100%; max-width: 400px;">
    <!-- Gambar lokal dari folder assets -->
    <img src="{{ asset('assets/images/maps.jpg') }}" 
         alt="Peta Lokasi Rental Motor Majestic"
         style="width: 100%; border-radius: 10px;">
    
    <!-- Ikon pin bisa diklik -->
    <a href="https://maps.app.goo.gl/6XwyE5pd6KzfGyxx8" target="_blank"
       style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
              background: white; border-radius: 50%; padding: 8px;
              box-shadow: 0 2px 6px rgba(0,0,0,0.3);">
      <iconify-icon icon="mdi:map-marker" style="color: red; font-size: 32px;"></iconify-icon>
    </a>
  </div>
</div>

<!-- Iconify -->
<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>


    <div class="follow-section">
      <div class="footer-section">
        <h3>Follow Us</h3>
        <div class="social-icons">
          <a href="https://www.instagram.com/sewamotormalang_id?igsh=MXM2amdyMnVreGhuaQ==" class="social-icon" title="Instagram">
            <iconify-icon icon="mdi:instagram"></iconify-icon>
          </a>
          <a href="https://www.tiktok.com/@sewamotormalang.batu?_t=ZS-8yRxw4ttgTg&_r=1" class="social-icon" title="TikTok">
            <iconify-icon icon="ic:baseline-tiktok"></iconify-icon>
          </a>
        </div>
      </div>
    </div>
  </footer>

  <div class="copyright">
    Copyright 2025 @sewamotormalang_id.
  </div>
</body>
</html>
