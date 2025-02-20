<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale = 1.0">
    <meta http-equiv="X-UA-Compatible" content = "ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite('resources/css/app.css')
</head>
<body class = "bg-slate-100 text-slate-900">
<header class = "bg-slate-800 shadow-lg text-xl">
    <nav>
        <a href="{{ route('files.index') }}" class = "nav-link text-xl">Home</a>
        <a href="{{ route('download') }}" class = "nav-link text-xl">Download file</a>
        <div class = "flex item-center gap-4">
                @auth
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</button>
                </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class = "nav-link text-xl">Login</a>
                    <a href="{{ route('register') }}" class = "nav-link text-xl">Register</a>
                    @endguest
        </div>
    </nav>
</header>
<main class = "py-8 px-4 mx-auto max-w-screen-lg">
    {{ $slot  }}
</main>
</body>
</html>
