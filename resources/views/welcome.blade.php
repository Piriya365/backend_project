<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Coffee & Friend</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            background-image: url('imgs/test.png');
            background-size: cover;
        }

        .login-register-links {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            z-index: 10;
        }

        .login-register-links a {
            font-weight: 600;
            color: white;
            text-decoration: none;
            margin-right: 10px;
            position: relative;
        }

        .login-register-links a:hover::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px; /* Adjust the position of the underline */
            width: 100%;
            height: 2px; /* Adjust the thickness of the underline */
            background-color: white; /* Change the color of the underline */
        }
    </style>
</head>

<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
        <div class="login-register-links">
            @auth
            <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
            <a href="{{ route('login') }}">Log in</a>

            @if (Route::has('register'))
            <span>|</span> <!-- Add a separator -->
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif
    </div>
</body>

</html>
