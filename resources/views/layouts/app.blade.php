<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terra Adventure</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<nav>
    <div class="nav-container">
        <a href="{{ route('home') }}" class="nav-logo">Terra Adventure</a>

        <div class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'nav-link-active' : '' }}">О нас</a>
            <a href="{{ route('catalog') }}" class="{{ request()->routeIs('catalog') ? 'nav-link-active' : '' }}">Каталог</a>
            <a href="{{ route('payment') }}" class="{{ request()->routeIs('payment') ? 'nav-link-active' : '' }}">Условия оплаты</a>
            <a href="{{ route('location') }}" class="{{ request()->routeIs('location') ? 'nav-link-active' : '' }}">Где нас найти</a>
        </div>

        <div class="nav-auth">
            @auth
                <a href="{{ route('cabinet.index') }}" class="nav-link {{ request()->routeIs('cabinet.*') ? 'nav-link-active' : '' }}">Мои заявки</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-ghost">Выйти</button>
                </form>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.index') }}" class="btn-primary">Админ</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="nav-link">Войти</a>
                <a href="{{ route('register') }}" class="btn-primary">Регистрация</a>
            @endauth
        </div>
    </div>
</nav>

<main>
    @if(session('success'))
        <div class="flash-success">{{ session('success') }}</div>
    @endif
    @yield('content')
</main>

</body>
</html>
