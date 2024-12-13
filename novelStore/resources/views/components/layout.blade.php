<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ url('css/estilos.css') }}">
        <meta name="description" content="Tienda de novelas">
        <meta name="keywords" content="novelas, libros, manwhas, rofan">
        <meta name="author" content="Elizabeth Guzman">
        <link rel="icon" href="img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

        <title>{{ $title }} :: NovelSunrise</title> 
    </head>
    <body>
        <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark mb-0" style="background-color: #480341;">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ url('img/logo.png') }}" alt="Logo" style="height: 30px; margin-right: 10px;">
                    NovelSunrise
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('novels.index') }}">Novelas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blogs.index') }}">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.show') }}">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login.form') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.register.form') }}">Registrarse</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.edit') }}">Perfil</a>
                        </li>
                    
                        @if(auth()->user()->role === 'Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.index') }}">Admin</a>
                        </li>
                        @endif                     
                        <li class="nav-item">
                            <form action="{{ route('auth.logout.process') }}" method="post">
                                @csrf
                                <button class="nav-link" type="submit">{{ auth()->user()->email }} (Logout)</button>
                            </form>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="container p-4">
            @if(session()->has('feedback.message'))
                <div class="alert alert-{{ session()->get('feedback.type', 'success') }} mb-4">{!! session()->get('feedback.message') !!}</div>
            @endif

            {{ $slot }}
        </main>
        <footer class="footer">
            <p>Copyright &copy; Elizabeth Guzmán 2024</p>
        </footer>
        </div>

        <script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>