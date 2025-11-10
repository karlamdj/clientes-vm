<!DOCTYPE html>
<html lang="es" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/') }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title', 'Login') - VM Tech</title>
    
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
    
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-image: url('{{ asset("assets/img/login/fondo.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Public Sans', sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 950px;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: rgba(23, 42, 82, 0.85);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(100, 200, 255, 0.3);
            border-radius: 20px;
            padding: 40px 50px;
            display: flex;
            align-items: center;
            gap: 60px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #00d4ff, #0099ff, #00d4ff);
            border-radius: 20px;
            z-index: -1;
            opacity: 0.5;
            filter: blur(10px);
        }

        .lemur-container {
            flex-shrink: 0;
            display: flex;
            align-items: center;
        }

        .lemur-image {
            width: auto;
            height: 420px;
            max-width: 100%;
            filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.3));
        }

        .login-form-container {
            flex: 1;
            color: white;
        }

        .login-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 30px;
            text-align: left;
            text-shadow: 0 0 20px rgba(0, 212, 255, 0.5);
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.5rem;
            color: #00d4ff;
            z-index: 1;
        }

        .form-control-custom {
            width: 100%;
            padding: 15px 50px 15px 20px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(0, 212, 255, 0.3);
            border-radius: 50px;
            font-size: 1rem;
            color: #1a2332;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control-custom::placeholder {
            color: rgba(26, 35, 50, 0.5);
        }

        .form-control-custom:focus {
            border-color: #00d4ff;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.4);
            background: rgba(255, 255, 255, 1);
        }

        .form-control-custom.is-invalid {
            border-color: #ff4444;
        }

        .invalid-feedback {
            color: #ff6b6b;
            font-size: 0.875rem;
            margin-top: 5px;
            margin-left: 20px;
        }

        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ffffff;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #00d4ff;
        }

        .forgot-password {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #00d4ff;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #00d4ff, #0099ff);
            border: none;
            border-radius: 50px;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #00e5ff, #00aaff);
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.6);
            transform: translateY(-2px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                padding: 30px 25px;
                gap: 30px;
            }

            .lemur-image {
                width: auto;
                height: 280px;
            }

            .login-title {
                font-size: 2rem;
                text-align: center;
            }

            .login-options {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 15px;
            }

            .login-card {
                padding: 25px 20px;
            }

            .lemur-image {
                width: auto;
                height: 200px;
            }

            .login-title {
                font-size: 1.75rem;
            }

            .form-control-custom {
                padding: 12px 45px 12px 15px;
                font-size: 0.9rem;
            }

            .input-icon {
                font-size: 1.25rem;
                right: 15px;
            }
        }
    </style>
</head>

<body>
    @yield('content')
        </div>
    </div>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <script>
        // Toggle password visibility
        document.querySelectorAll('.form-password-toggle').forEach(function(element) {
            element.querySelector('.input-group-text').addEventListener('click', function() {
                const input = element.querySelector('input');
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bx-hide');
                    icon.classList.add('bx-show');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bx-show');
                    icon.classList.add('bx-hide');
                }
            });
        });
    </script>
</body>
</html>
