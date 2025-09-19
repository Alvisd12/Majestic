@extends('index')

@section('title', $blog->judul . ' - Majestic Rental Motor')

@section('content')
                    <!-- Blog Header -->
                    <div class="blog-header text-center">
                        <h1 class="blog-title">{{ $blog->judul }}</h1>
                        <div class="blog-meta-info">
                            <span class="author">
                                <i class="fas fa-user"></i> {{ $blog->penulis ?? $blog->admin->nama ?? 'Admin' }}
                            </span>
                            <span class="date">
                                <i class="fas fa-calendar"></i> {{ $blog->created_at->format('d M Y') }}
                            </span>
                            @if($blog->lokasi)
                            <span class="location">
                                <i class="fas fa-map-marker-alt"></i> {{ $blog->lokasi }}
                            </span>
                            @endif
                        </div>
                    </div>
    <!-- Blog Content -->
    <div class="blog-content-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <!-- Featured Image -->
                    @if($blog->gambar)
                    <div class="blog-featured-image mb-4">
                        <img src="{{ asset('storage/' . $blog->gambar) }}" 
                             alt="{{ $blog->judul }}" 
                             class="img-fluid rounded shadow">
                    </div>
                    @endif

                    <!-- Blog Content -->
                    <div class="blog-content">
                        <div class="content-body">
                            {!! nl2br(e($blog->isi)) !!}
                        </div>
                    </div>

                    <!-- Blog Footer -->
                    <div class="blog-footer mt-5 pt-4 border-top">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="blog-tags">
                                    @if($blog->lokasi)
                                    <span class="badge bg-primary me-2">
                                        <i class="fas fa-map-marker-alt"></i> {{ $blog->lokasi }}
                                    </span>
                                    @endif
                                    <span class="badge bg-success">
                                        <i class="fas fa-blog"></i> Travel Blog
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <small class="text-muted">
                                    Terakhir diupdate: {{ $blog->updated_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>

    <!-- Related Blogs Section -->
    @if($relatedBlogs->count() > 0)
    <div class="related-blogs-section py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="section-title text-center mb-5">Blog Terkait</h3>
                </div>
            </div>
            <div class="row g-4">
                @foreach($relatedBlogs as $relatedBlog)
                <div class="col-lg-4 col-md-6">
                    <div class="card blog-card h-100 shadow-sm">
                        @if($relatedBlog->gambar)
                        <div class="card-img-wrapper">
                            <img src="{{ asset('storage/' . $relatedBlog->gambar) }}" 
                                 class="card-img-top" 
                                 alt="{{ $relatedBlog->judul }}">
                        </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $relatedBlog->judul }}</h5>
                            <p class="card-text flex-grow-1">
                                {{ Str::limit(strip_tags($relatedBlog->isi), 120) }}
                            </p>
                            @if($relatedBlog->lokasi)
                            <p class="card-location">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                                <small class="text-muted">{{ $relatedBlog->lokasi }}</small>
                            </p>
                            @endif
                            <div class="card-meta">
                                <small class="text-muted">
                                    <i class="fas fa-calendar"></i> {{ $relatedBlog->created_at->format('M d, Y') }}
                                </small>
                            </div>
                            <a href="{{ route('blog.detail', $relatedBlog->id) }}" 
                               class="btn btn-primary btn-sm mt-3">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Back to Home Button -->
    <div class="back-to-home py-4">
        <div class="container text-center">
            <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

<style>
/* Blog Detail Styles */
.blog-detail-container {
    min-height: 100vh;
}

.blog-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 80px 0 60px;
}

.blog-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.blog-meta-info {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
    font-size: 1rem;
    opacity: 0.9;
}

.blog-meta-info span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.blog-meta-info i {
    color: #ffd700;
}

.breadcrumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: white;
}

.breadcrumb-item.active {
    color: #ffd700;
}

.blog-content-section {
    padding: 60px 0;
}

.blog-featured-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-featured-image:hover img {
    transform: scale(1.02);
}

.blog-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.content-body {
    text-align: justify;
}

.blog-footer {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 10px;
    margin-top: 3rem;
}

.blog-tags .badge {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.related-blogs-section {
    background: #f8f9fa;
}

.section-title {
    font-size: 2rem;
    font-weight: 600;
    color: #333;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
}

.blog-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    overflow: hidden;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.card-img-wrapper {
    height: 200px;
    overflow: hidden;
}

.card-img-top {
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-card:hover .card-img-top {
    transform: scale(1.1);
}

.card-location {
    margin-bottom: 0.5rem;
}

.back-to-home {
    background: white;
    border-top: 1px solid #eee;
}

/* Responsive Design */
@media (max-width: 768px) {
    .blog-title {
        font-size: 2rem;
    }
    
    .blog-meta-info {
        gap: 1rem;
        font-size: 0.9rem;
    }
    
    .blog-hero {
        padding: 60px 0 40px;
    }
    
    .blog-content-section {
        padding: 40px 0;
    }
    
    .blog-featured-image img {
        height: 250px;
    }
}

@media (max-width: 576px) {
    .blog-meta-info {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .blog-title {
        font-size: 1.75rem;
    }
}
</style>
@endsection
