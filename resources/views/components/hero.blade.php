<section class="hero-carousel">
    <div class="carousel-container">
        <div class="carousel-slides">
            <div class="carousel-slide active">
                <img src="{{ asset('assets/images/herooo.jpg') }}" alt="Hero 1">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('assets/images/herooo.jpg') }}" alt="Hero 2">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('assets/images/herooo.jpg') }}" alt="Hero 3">
            </div>
        </div>
        
        <!-- Navigation Arrows -->
        <button class="carousel-nav prev" onclick="moveSlide(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="carousel-nav next" onclick="moveSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <!-- Dots Indicator -->
        <div class="carousel-dots">
            <span class="dot active" onclick="currentSlide(0)"></span>
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
        </div>
    </div>
</section>

<style>
    .hero-carousel {
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;
        background: transparent;
        margin: 0;
        padding: 0;
    }

    .carousel-container {
        position: relative;
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .carousel-slides {
        position: relative;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .carousel-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
        z-index: 1;
    }

    .carousel-slide.active {
        opacity: 1;
        z-index: 2;
    }

    .carousel-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        margin: 0;
        padding: 0;
    }

    /* Navigation Arrows */
    .carousel-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .carousel-nav:hover {
        background: rgba(255, 255, 255, 0.4);
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .carousel-nav.prev {
        left: 30px;
    }

    .carousel-nav.next {
        right: 30px;
    }

    /* Dots Indicator */
    .carousel-dots {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 12px;
        z-index: 10;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(37, 99, 235, 0.6);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid rgba(37, 99, 235, 0.9);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .dot:hover {
        background: rgba(37, 99, 235, 0.9);
        transform: scale(1.2);
        box-shadow: 0 3px 12px rgba(37, 99, 235, 0.5);
    }

    .dot.active {
        background: #2563eb;
        width: 30px;
        border-radius: 6px;
        border-color: #1d4ed8;
        box-shadow: 0 3px 12px rgba(37, 99, 235, 0.6);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .carousel-nav {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .carousel-nav.prev {
            left: 15px;
        }

        .carousel-nav.next {
            right: 15px;
        }

        .carousel-dots {
            bottom: 20px;
        }

        .dot {
            width: 10px;
            height: 10px;
        }

        .dot.active {
            width: 24px;
        }
    }
</style>

<script>
    let currentSlideIndex = 0;
    let autoSlideInterval;

    function showSlide(index) {
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.dot');
        
        // Wrap around - urut dari kiri ke kanan (0, 1, 2, 0, 1, 2...)
        if (index >= slides.length) {
            currentSlideIndex = 0;
        } else if (index < 0) {
            currentSlideIndex = slides.length - 1;
        } else {
            currentSlideIndex = index;
        }
        
        // Update dots
        dots.forEach(dot => dot.classList.remove('active'));
        dots[currentSlideIndex].classList.add('active');
        
        // Add active to new slide first (cross-fade)
        slides[currentSlideIndex].classList.add('active');
        
        // Remove active from other slides after a brief moment
        slides.forEach((slide, idx) => {
            if (idx !== currentSlideIndex) {
                setTimeout(() => {
                    slide.classList.remove('active');
                }, 50);
            }
        });
    }

    function moveSlide(direction) {
        showSlide(currentSlideIndex + direction);
        resetAutoSlide();
    }

    function currentSlide(index) {
        showSlide(index);
        resetAutoSlide();
    }

    function autoSlide() {
        // Auto slide selalu maju (+1) untuk urut dari kiri ke kanan
        currentSlideIndex++;
        if (currentSlideIndex >= document.querySelectorAll('.carousel-slide').length) {
            currentSlideIndex = 0; // Kembali ke slide pertama
        }
        showSlide(currentSlideIndex);
    }

    function startAutoSlide() {
        autoSlideInterval = setInterval(autoSlide, 5000); // Ganti gambar setiap 5 detik
    }

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }

    // Preload images
    function preloadImages() {
        const slides = document.querySelectorAll('.carousel-slide img');
        slides.forEach(img => {
            const image = new Image();
            image.src = img.src;
        });
    }

    // Set background untuk hero carousel
    function setHeroBackground() {
        const heroCarousel = document.querySelector('.hero-carousel');
        if (heroCarousel) {
            heroCarousel.style.backgroundColor = 'transparent';
        }
    }

    // Start auto slide when page loads
    document.addEventListener('DOMContentLoaded', function() {
        setHeroBackground();
        preloadImages();
        startAutoSlide();
    });

    // Pause auto slide when user hovers over carousel
    const carouselContainer = document.querySelector('.carousel-container');
    if (carouselContainer) {
        carouselContainer.addEventListener('mouseenter', function() {
            clearInterval(autoSlideInterval);
        });

        carouselContainer.addEventListener('mouseleave', function() {
            startAutoSlide();
        });
    }
</script>