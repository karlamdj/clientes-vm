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
        .authentication-wrapper {
            display: flex;
            flex-basis: 100%;
            min-height: 100vh;
            width: 100%;
        }
        .authentication-inner {
            width: 100%;
            max-width: 400px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                @yield('content')
            </div>
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
