<footer class="footer">
    <div class="footer-container">
        <div class="footer-column">
            <h4>Alamat Kami</h4>
            <div class="footer-info">
                <div class="info-item">
                    <i class="icon-location">📍</i>
                    <span>Gg. Kaserin M U, Lesanpuro, Kec. Kedungkandang, Kota Malang, Jawa Timur 65138, Indonesia</span>
                </div>
                <div class="info-item">
                    <i class="icon-time">🕐</i>
                    <span>07.00 s/d 21.00 WIB</span>
                </div>
                <div class="info-item">
                    <i class="icon-phone">📞</i>
                    <span>0851-0547-4050</span>
                </div>
                <div class="info-item">
                    <i class="icon-email">✉️</i>
                    <span>majessticttransport@gmailm.com</span>
                </div>
            </div>
            
            <div class="social-section">
                <h5>Follow Us</h5>
                <div class="social-icons">
                    <a href="#" class="social-link instagram">📷</a>
                    <a href="#" class="social-link tiktok">🎵</a>
                </div>
            </div>
        </div>

        <div class="footer-column">
            <h4>Sewa Motor</h4>
            <ul class="footer-links">
                <li><a href="#">▶ Beat Deluxe</a></li>
                <li><a href="#">▶ Scoppy 2020</a></li>
                <li><a href="#">▶ Genio</a></li>
                <li><a href="#">▶ Vario</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Quick Link</h4>
            <ul class="footer-links">
                <li><a href="#">▶ Harga Sewa</a></li>
                <li><a href="#">▶ Layanan</a></li>
                <li><a href="#">▶ Tentang Kami</a></li>
                <li><a href="#">▶ Testimonial</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Lokasi Kami</h4>
            <div class="map-container">
                <img src="{{ asset('assets/images/maps.jpg') }}" alt="Peta Lokasi" class="map-image">
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>Copyright 2025 @sewamotormalang_id.</p>
    </div>
</footer>

<style>
.footer {
    background-color: #1a1a1a;
    color: #ffffff;
    padding: 60px 0 0;
    font-family: Arial, sans-serif;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 40px;
    padding: 0 20px;
    margin-bottom: 40px;
}

.footer-column h4 {
    color: #FFD700;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 20px;
    position: relative;
}

.footer-column h4::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 40px;
    height: 2px;
    background-color: #FFD700;
}

.footer-info {
    margin-bottom: 30px;
}

.info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
    font-size: 14px;
    line-height: 1.5;
}

.info-item i {
    margin-right: 10px;
    font-size: 16px;
    width: 20px;
    flex-shrink: 0;
}

.info-item span {
    color: #cccccc;
}

.social-section h5 {
    color: #FFD700;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 15px;
}

.social-icons {
    display: flex;
    gap: 15px;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background-color: #FFD700;
    color: #1a1a1a;
    border-radius: 50%;
    text-decoration: none;
    font-size: 18px;
    transition: all 0.3s ease;
}

.social-link:hover {
    background-color: #FFA500;
    transform: scale(1.1);
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: #cccccc;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
}

.footer-links a:hover {
    color: #FFD700;
}

.footer-links a::before {
    content: '▶';
    color: #FFD700;
    margin-right: 8px;
    font-size: 12px;
}

.map-container {
    margin-top: 15px;
}

.map-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #333;
}

.footer-bottom {
    background-color: #FFD700;
    color: #1a1a1a;
    text-align: center;
    padding: 20px 0;
    margin: 0;
}

.footer-bottom p {
    margin: 0;
    font-size: 14px;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 992px) {
    .footer-container {
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }
}

@media (max-width: 768px) {
    .footer-container {
        grid-template-columns: 1fr;
        gap: 30px;
        text-align: center;
    }
    
    .info-item {
        justify-content: center;
        text-align: left;
    }
    
    .social-icons {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .footer {
        padding: 40px 0 0;
    }
    
    .footer-container {
        padding: 0 15px;
    }
    
    .info-item span {
        font-size: 13px;
    }
    
    .map-image {
        height: 150px;
    }
}
</style>