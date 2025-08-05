<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Majestic Transport</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
        }

        /* Logo Styles */
        .logo {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-image {
            height: 80px;
            width: auto;
            object-fit: contain;
        }

        /* Register Card Styles */
        .register-card {
            background: white;
            border-radius: 20px;
            padding: 40px 32px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 32px;
            letter-spacing: 1px;
        }

        /* Form Styles */
        .register-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 500;
            color: #666;
            margin-left: 4px;
        }

        .form-input {
            padding: 14px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            color: #1a1a1a;
            background: #fafafa;
            transition: all 0.3s ease;
            outline: none;
            width: 100%;
        }

        .form-input:focus {
            border-color: #1e88e5;
            background: white;
            box-shadow: 0 0 0 2px rgba(30, 136, 229, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .form-input.error:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        /* Password Input Styles */
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: #6b7280;
        }

        /* Error Message Styles */
        .error-message {
            font-size: 14px;
            color: #ef4444;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Success Message */
        .success-message {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .success-message::before {
            content: '✓';
            font-weight: bold;
        }

        /* Button Styles */
        .register-btn {
            background: linear-gradient(135deg, #ffd700 0%, #ffb700 100%);
            color: #1a1a1a;
            border: none;
            padding: 16px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 16px;
            box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
        }

        .register-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, #ffdb00 0%, #ffc107 100%);
        }

        .register-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
        }

        /* Login Link Styles */
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .login-link a {
            color: #1e88e5;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .login-link a:hover {
            color: #1565c0;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                padding: 16px;
                gap: 24px;
                max-width: 360px;
            }
            
            .register-card {
                padding: 32px 24px;
            }
            
            .title {
                font-size: 22px;
                margin-bottom: 28px;
            }
            
            .form-input {
                padding: 12px 14px;
                font-size: 16px; /* Prevent zoom on iOS */
            }
            
            .register-btn {
                padding: 14px 20px;
            }
        }

        /* Loading State */
        .register-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .register-btn.loading {
            position: relative;
            color: transparent;
        }

        .register-btn.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid #1a1a1a;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Focus visible for accessibility */
        .form-input:focus-visible,
        .register-btn:focus-visible,
        .toggle-password:focus-visible {
            outline: 2px solid #1e88e5;
            outline-offset: 2px;
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .form-input {
                border-width: 2px;
            }
            
            .register-btn {
                border: 2px solid #000;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-card">
            <div class="logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Majestic Transport" class="logo-image" 
                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            </div>
            <h2 class="title">REGISTER</h2>
            
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="register-form" id="registerForm">
                @csrf
                
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        class="form-input @error('nama') error @enderror"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
                        maxlength="255"
                        required
                    >
                    @error('nama')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-input @error('username') error @enderror"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        maxlength="50"
                        required
                    >
                    @error('username')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input @error('password') error @enderror"
                            placeholder="Masukkan password (minimal 6 karakter)"
                            minlength="6"
                            required
                        >
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" fill="none"/>
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">No. HP</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        class="form-input @error('phone') error @enderror"
                        value="{{ old('phone') }}"
                        placeholder="Masukkan nomor HP"
                        pattern="[0-9]{10,15}"
                        maxlength="20"
                        required
                    >
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="register-btn" id="registerBtn">Register</button>
            </form>

            <p class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path d="m1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="m9 9 3 3 3-3M15 15l-3-3-3 3" stroke="currentColor" stroke-width="2" fill="none"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" fill="none"/>
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                `;
            }
        }

        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            // Remove non-numeric characters
            let value = e.target.value.replace(/\D/g, '');
            
            // Add Indonesian format if starts with 08
            if (value.startsWith('08')) {
                value = value;
            } else if (value.startsWith('8')) {
                value = '0' + value;
            }
            
            e.target.value = value;
        });

        // Add loading state on form submit
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const registerBtn = document.getElementById('registerBtn');
            registerBtn.classList.add('loading');
            registerBtn.disabled = true;
        });

        // Add enter key support
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const form = document.getElementById('registerForm');
                if (form) {
                    form.submit();
                }
            }
        });

        // Auto hide success messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.success-message');
            messages.forEach(function(message) {
                message.style.transition = 'opacity 0.5s ease';
                message.style.opacity = '0';
                setTimeout(function() {
                    message.remove();
                }, 500);
            });
        }, 5000);

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const phone = document.getElementById('phone').value.trim();

            // Basic validation
            if (nama.length < 2) {
                alert('Nama harus minimal 2 karakter');
                e.preventDefault();
                return;
            }

            if (username.length < 3) {
                alert('Username harus minimal 3 karakter');
                e.preventDefault();
                return;
            }

            if (password.length < 6) {
                alert('Password harus minimal 6 karakter');
                e.preventDefault();
                return;
            }

            if (phone.length < 10) {
                alert('Nomor HP harus minimal 10 digit');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>