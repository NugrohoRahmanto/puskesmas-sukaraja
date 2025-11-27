<!doctype html>
<html lang="id" class="h-full" x-data="{ mobileNav: false }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'User • Puskesmas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full antialiased bg-slate-50 text-slate-900" @keydown.window.escape="mobileNav = false">

    {{-- Mobile header --}}
    <header class="lg:hidden sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-slate-200">
        <div class="flex items-center justify-between h-16 px-4">
            <div class="flex items-center gap-3">
                <button type="button" @click="mobileNav = true" class="p-2 text-slate-600 hover:text-brand-700"
                    aria-label="Buka navigasi">
                    <x-heroicon-o-bars-3 class="w-6 h-6" />
                </button>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpeg') }}" class="rounded-lg w-9 h-9" alt="Logo Puskesmas">
                    <span class="font-semibold hover:text-brand-700">Puskesmas Sukaraja</span>
                </div>
            </div>
            <a href="{{ route('user.me') }}" class="text-sm font-medium text-brand-700">Profil</a>
        </div>
    </header>

    {{-- Mobile drawer --}}
    <div x-cloak x-show="mobileNav" class="lg:hidden fixed inset-0 z-50" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-slate-900/60" @click="mobileNav = false"></div>
        <div class="absolute inset-y-0 left-0 w-72 max-w-[80%] bg-white border-r border-slate-200 shadow-xl flex flex-col"
            x-transition:enter="transition transform ease-out duration-200"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform ease-in duration-150"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
            <div class="flex items-center justify-between h-16 px-4 border-b border-slate-200">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpeg') }}" class="rounded-lg w-9 h-9" alt="Logo Puskesmas">
                    <span class="font-semibold">Puskesmas Sukaraja</span>
                </div>
                <button type="button" @click="mobileNav = false" class="p-2 text-slate-500 hover:text-slate-900"
                    aria-label="Tutup navigasi">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>
            <div class="flex-1 flex flex-col overflow-y-auto">
                @php
                    $active = fn($pattern) => request()->routeIs($pattern)
                        ? 'bg-brand-100 text-brand-700'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900';
                @endphp
                @include('layouts.partials.user-nav')
            </div>
        </div>
    </div>

    {{-- Sidebar desktop --}}
    <aside class="fixed inset-y-0 hidden bg-white border-r lg:flex lg:flex-col lg:w-64 border-slate-200">
        <div class="flex items-center h-16 gap-3 px-4 border-b border-slate-200">
            <img src="{{ asset('images/logo.jpeg') }}" class="rounded-lg w-9 h-9" alt="">
            <span class="font-semibold hover:text-brand-700">Puskesmas Sukaraja</span>
        </div>
        @php
            $active = fn($pattern) => request()->routeIs($pattern)
                ? 'bg-brand-100 text-brand-700'
                : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900';
        @endphp
        @include('layouts.partials.user-nav')
    </aside>

    {{-- Main --}}
    <div class="lg:pl-64">
        <main class="px-4 py-6 md:px-6 w-full overflow-x-hidden">
            @yield('content')
        </main>
    </div>
</body>

</html>
