<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Majestic Transport</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            gap: 40px;
        }

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

        .form-container {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            position: relative;
        }

        .form-title {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #666;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background-color: #f8f9fa;
        }

        .form-input:focus {
            outline: none;
            border-color: #2a5298;
            box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
            background-color: white;
        }

        .form-input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .form-input.error:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 1.1rem;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 25px;
        }

        .forgot-password a {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
            cursor: pointer;
        }

        .forgot-password a:hover {
            color: #2a5298;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #FFC107 0%, #FFB300 100%);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 25px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 193, 7, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .form-link {
            text-align: center;
            color: #666;
            font-size: 0.95rem;
        }

        .form-link a {
            color: #2a5298;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .form-link a:hover {
            color: #1e3c72;
            text-decoration: underline;
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

        /* Alert Error Message */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-error::before {
            content: '⚠';
            font-weight: bold;
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 30px 20px;
                margin: 20px;
            }

            .logo-image {
                width: 150px;
                height: 150px;
            }
        }

        /* Loading animation */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Majestic Transport" class="logo-image" 
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        </div>

        <div class="form-container">
            <h1 class="form-title">LOGIN</h1>

            <!-- Success Message -->
            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if ($errors->has('login'))
                <div class="alert-error">
                    {{ $errors->first('login') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf

                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username"
                        class="form-input @error('username') error @enderror" 
                        value="{{ old('username') }}"
                        placeholder="Masukkan username" 
                        required>
                    @error('username')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password"
                            class="form-input @error('password') error @enderror" 
                            placeholder="Masukkan password"
                            required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">👁</button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="forgot-password">
                    <a href="#" onclick="showForgotPassword()">Lupa password?</a>
                </div>

                <button type="submit" class="submit-btn" id="signInBtn">Sign In</button>
            </form>

            <div class="form-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </div>
        </div>
    </div>

    <script>
        // Password toggle function
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleBtn = passwordInput.parentNode.querySelector('.password-toggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '👁';
            }
        }

        function showForgotPassword() {
            alert('Fitur lupa password akan segera tersedia. Silakan hubungi administrator untuk reset password.');
        }

        // Add loading state on form submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const signInBtn = document.getElementById('signInBtn');
            signInBtn.classList.add('loading');
            signInBtn.textContent = '';
        });

        // Add enter key support
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const form = document.getElementById('loginForm');
                if (form) {
                    form.submit();
                }
            }
        });

        // Auto hide success/error messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.success-message, .alert-error');
            messages.forEach(function(message) {
                message.style.transition = 'opacity 0.5s ease';
                message.style.opacity = '0';
                setTimeout(function() {
                    message.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>

</html>