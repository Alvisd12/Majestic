<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Majestic Transport</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-gradient: linear-gradient(135deg, #1565c0 0%, #1e88e5 100%);
            --secondary-gradient: linear-gradient(135deg, #FFB300 0%, #FFC107 100%);
            --accent-color: #1565c0;
            --accent-yellow: #FFC107;
            --text-primary: #1a237e;
            --text-secondary: #424242;
            --border-color: #e3f2fd;
            --success-color: #2e7d32;
            --error-color: #d32f2f;
            --shadow-light: 0 4px 20px rgba(21, 101, 192, 0.08);
            --shadow-medium: 0 8px 32px rgba(21, 101, 192, 0.12);
            --shadow-heavy: 0 16px 64px rgba(21, 101, 192, 0.16);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #1565c0 0%, #1e88e5 50%, #42a5f5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
        }

        /* Animated background elements */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 193, 7, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(21, 101, 192, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255, 179, 0, 0.1) 0%, transparent 50%);
            animation: backgroundShift 20s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes backgroundShift {
            0%, 100% { transform: translateX(0) translateY(0); }
            33% { transform: translateX(-20px) translateY(-10px); }
            66% { transform: translateX(20px) translateY(10px); }
        }

        .container {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: var(--shadow-heavy);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--secondary-gradient);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            max-width: 200px;
            max-height: 80px;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: var(--primary-gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-medium);
            position: relative;
            overflow: hidden;
        }

        .logo-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.2) 50%, transparent 70%);
            animation: logoShine 3s infinite;
        }

        @keyframes logoShine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .logo-icon {
            font-size: 2rem;
            color: white;
            z-index: 1;
        }

        .brand-name {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .brand-tagline {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 400;
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            font-weight: 400;
        }

        .input-group {
            margin-bottom: 24px;
            position: relative;
        }

        .input-label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .input-container {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .form-input {
            width: 100%;
            padding: 16px 16px 16px 48px;
            border: 2px solid var(--border-color);
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 400;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--text-primary);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent-color);
            background: white;
            box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.1);
            transform: translateY(-1px);
        }

        .form-input:focus + .input-icon {
            color: var(--accent-color);
        }

        .form-input.error {
            border-color: var(--error-color);
            background: rgba(211, 47, 47, 0.05);
        }

        .form-input.error:focus {
            border-color: var(--error-color);
            box-shadow: 0 0 0 4px rgba(211, 47, 47, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: var(--accent-color);
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 32px;
        }

        .forgot-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-link:hover {
            color: var(--accent-color);
        }

        .forgot-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }

        .forgot-link:hover::after {
            width: 100%;
        }

        .submit-btn {
            width: 100%;
            background: var(--secondary-gradient);
            color: #1a237e;
            border: none;
            padding: 18px 24px;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-medium);
            text-shadow: none;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-heavy);
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .submit-btn.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid rgba(26, 35, 126, 0.3);
            border-top-color: #1a237e;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .form-footer {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .signup-link {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .signup-link:hover {
            color: #0d47a1;
            text-decoration: underline;
        }

        /* Message Styles */
        .message {
            padding: 16px 20px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .message.success {
            background: rgba(46, 125, 50, 0.1);
            border: 1px solid rgba(46, 125, 50, 0.2);
            color: #2e7d32;
        }

        .message.error {
            background: rgba(211, 47, 47, 0.1);
            border: 1px solid rgba(211, 47, 47, 0.2);
            color: #d32f2f;
        }

        .error-message {
            font-size: 0.85rem;
            color: var(--error-color);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            animation: slideInLeft 0.3s ease;
        }

        @keyframes slideInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-10px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                max-width: 100%;
                padding: 0 16px;
            }

            .login-card {
                padding: 32px 24px;
                border-radius: 20px;
            }

            .logo-container {
                width: 70px;
                height: 70px;
            }

            .logo-icon {
                font-size: 1.8rem;
            }

            .brand-name {
                font-size: 1.3rem;
            }

            .form-title {
                font-size: 1.5rem;
            }

            .logo {
                max-width: 180px;
                max-height: 70px;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .login-card {
                background: rgba(30, 30, 30, 0.95);
                border-color: rgba(255, 255, 255, 0.1);
            }

            .form-input {
                background: rgba(50, 50, 50, 0.8);
                color: #e0e0e0;
                border-color: #404040;
            }

            .form-input:focus {
                background: rgba(60, 60, 60, 0.95);
            }

            .form-title, .input-label {
                color: #e0e0e0;
            }

            .form-subtitle, .brand-tagline {
                color: #a0a0a0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-card">
            <div class="logo-section">
                <img src="{{ asset('assets/images/logoputih.png') }}" alt="Logo" class="logo">
            </div>

            <div class="form-header">
                <h2 class="form-title">Selamat Datang Kembali</h2>
                <p class="form-subtitle">Silakan masuk ke akun Anda</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="message success" id="successMessage">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Message -->
            @if ($errors->has('username') || $errors->has('password') || $errors->any())
                <div class="message error" id="errorMessage">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>
                        @if($errors->has('username'))
                            {{ $errors->first('username') }}
                        @elseif($errors->has('password'))
                            {{ $errors->first('password') }}
                        @else
                            {{ $errors->first() }}
                        @endif
                    </span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf
                <div class="input-group">
                    <label for="username" class="input-label">Nama Pengguna</label>
                    <div class="input-container">
                        <input type="text" id="username" name="username" class="form-input @error('username') error @enderror" 
                               placeholder="Masukkan nama pengguna" value="{{ old('username') }}" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                    <div class="error-message" style="display: none;" id="usernameError">
                        <i class="fas fa-times-circle"></i>
                        <span>Silakan masukkan nama pengguna yang valid</span>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password" class="input-label">Kata Sandi</label>
                    <div class="input-container">
                        <input type="password" id="password" name="password" class="form-input @error('password') error @enderror" 
                               placeholder="Masukkan kata sandi" required>
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    <div class="error-message" style="display: none;" id="passwordError">
                        <i class="fas fa-times-circle"></i>
                        <span>Silakan masukkan kata sandi Anda</span>
                    </div>
                </div>

                <div class="forgot-password">
                    <a href="#" class="forgot-link" onclick="showForgotPassword()">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    <span id="btnText">Masuk</span>
                </button>
            </form>

            <div class="form-footer">
                Belum punya akun? <a href="{{ route('register') }}" class="signup-link">Daftar di sini</a>
            </div>
        </div>
    </div>

    <script>
        // Password toggle function
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Show forgot password alert
        function showForgotPassword() {
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5); display: flex; align-items: center;
                justify-content: center; z-index: 1000; backdrop-filter: blur(5px);
            `;
            
            modal.innerHTML = `
                <div style="background: white; padding: 32px; border-radius: 16px; max-width: 400px; margin: 20px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                    <i class="fas fa-info-circle" style="font-size: 3rem; color: var(--accent-color); margin-bottom: 16px;"></i>
                    <h3 style="margin-bottom: 16px; color: var(--text-primary);">Lupa Kata Sandi</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 24px;">Fitur ini akan segera tersedia. Silakan hubungi administrator untuk reset kata sandi.</p>
                    <button onclick="this.closest('div').parentNode.remove()" style="background: linear-gradient(135deg, #FFB300 0%, #FFC107 100%); color: #1a237e; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                        Mengerti
                    </button>
                </div>
            `;
            
            document.body.appendChild(modal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) modal.remove();
            });
        }

        // Form validation and submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            
            // Basic validation
            if (!username || !password) {
                e.preventDefault();
                return;
            }
            
            // Show loading state
            submitBtn.classList.add('loading');
            btnText.textContent = '';
        });

        // Add floating label effect
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentNode.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentNode.classList.remove('focused');
                }
            });
        });

        // Smooth scroll and entrance animation
        window.addEventListener('load', function() {
            document.querySelector('.login-card').style.animation = 'slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        });

        // Add entrance animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInUp {
                0% {
                    opacity: 0;
                    transform: translateY(30px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);

        // Add ripple effect to button
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(26, 35, 126, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: rippleEffect 0.6s linear;
                pointer-events: none;
            `;
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });

        // Add ripple animation
        style.textContent += `
            @keyframes rippleEffect {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
    </script>
</body>

</html>