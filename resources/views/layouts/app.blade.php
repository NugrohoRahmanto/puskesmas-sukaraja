<!doctype html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Puskesmas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

@stack('scripts')

<body class="min-h-full bg-slate-50 text-slate-900 antialiased">
    <header class="sticky top-0 z-[9999] bg-white/95 backdrop-blur border-b border-slate-200">
        <div class="max-w-full mx-auto px-4 md:px-6">
            <nav class="flex items-center justify-between py-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo"
                            class="w-10 h-10 rounded-lg object-cover">
                        <span class="text-lg font-semibold hover:text-brand-700 mr-2">Puskesmas Sukaraja</span>
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="hidden sm:inline-flex text-sm px-3 py-2 rounded-lg text-slate-600 hover:text-brand-700 hover:bg-brand-100">Beranda</a>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}"
                        class="text-sm px-3 py-2 rounded-lg text-slate-700 hover:text-brand-700 hover:bg-brand-100">Login</a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center rounded-lg bg-brand-700 hover:opacity-90 text-white text-sm px-4 py-2">Register</a>
                </div>
            </nav>
        </div>
    </header>

    <main class="{{ View::hasSection('fullbleed') ? '' : 'max-w-full mx-auto px-4 md:px-6 py-6' }}">
        @yield('content')
    </main>

</body>

</html>
