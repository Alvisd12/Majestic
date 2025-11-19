<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Majestic Transport</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Remove default margin and padding for hero section */
    body {
      margin: 0;
      padding: 0;
    }
    
    /* Ensure hero section touches edges */
    .hero-carousel {
      margin: 0 !important;
      padding: 0 !important;
    }
  </style>
</head>
<body>

  {{-- Header --}}
  @include('components.header')

  {{-- Hero Section --}}
  @include('components.hero')

  {{-- Konten Dinamis --}}
  <main>
    @yield('content')
  </main>

  {{-- Footer --}}
  @include('components.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Global AJAX setup for CSRF token
    if (document.querySelector('meta[name="csrf-token"]')) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Setup for fetch requests
        window.fetch = (function(originalFetch) {
            return function(...args) {
                if (args[1] && args[1].method && args[1].method.toUpperCase() !== 'GET') {
                    args[1].headers = args[1].headers || {};
                    args[1].headers['X-CSRF-TOKEN'] = token;
                }
                return originalFetch.apply(this, args)
                    .then(response => {
                        if (response.status === 401) {
                            window.location.href = '{{ route("session.expired") }}';
                            return Promise.reject('Session expired');
                        }
                        return response;
                    });
            };
        })(window.fetch);
    }
    
    // Prevent back button after logout for authenticated users
    document.addEventListener('DOMContentLoaded', function() {
        if (window.history && window.history.pushState) {
            window.history.pushState(null, null, window.location.href);
            window.addEventListener('popstate', function() {
                window.history.pushState(null, null, window.location.href);
            });
        }
    });
  </script>
  
  @stack('scripts')
</body>
</html>