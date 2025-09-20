<!doctype html>
<html lang="id" class="h-full" x-data="{ open: false }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Admin • Puskesmas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@stack('scripts')

<body class="min-h-full bg-slate-50 text-slate-900 antialiased">

    {{-- Sidebar desktop --}}
    <aside class="hidden lg:flex lg:flex-col lg:w-64 fixed inset-y-0 border-r border-slate-200 bg-white">
        <div class="h-16 px-4 flex items-center gap-3 border-b border-slate-200">
            <img src="{{ asset('images/logo.jpeg') }}" class="w-9 h-9 rounded-lg" alt="">
            <span class="font-semibold">Admin Puskesmas</span>
        </div>
        @php
            $active = fn($pattern) => request()->routeIs($pattern)
                ? 'bg-brand-100 text-brand-700'
                : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900';

            $is = fn($pattern) => request()->routeIs($pattern);
        @endphp

        <nav class="flex-1 p-3 space-y-1">
            {{-- Beranda --}}
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('admin.dashboard') }}"
                aria-current="{{ $is('admin.dashboard') ? 'page' : 'false' }}">
                @if ($is('admin.dashboard'))
                    <x-heroicon-s-home class="w-5 h-5 shrink-0" aria-hidden="true" />
                @else
                    <x-heroicon-o-home class="w-5 h-5 shrink-0" aria-hidden="true" />
                @endif
                Beranda
            </a>

            {{-- Riwayat Pasien --}}
            <a href="{{ route('admin.patientsHistory.indexAdmin') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('admin.patientsHistory.indexAdmin*') }}"
                aria-current="{{ $is('admin.patientsHistory.indexAdmin*') ? 'page' : 'false' }}">
                @if ($is('admin.patientsHistory.indexAdmin*'))
                    <x-heroicon-s-clipboard-document-list class="w-5 h-5 shrink-0" aria-hidden="true" />
                @else
                    <x-heroicon-o-clipboard-document-list class="w-5 h-5 shrink-0" aria-hidden="true" />
                @endif
                Riwayat Pasien
            </a>

            {{-- Manajemen Pasien --}}
            <a href="{{ route('admin.patients.indexAdmin') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('admin.patients.indexAdmin*') }}"
                aria-current="{{ $is('admin.patients.indexAdmin*') ? 'page' : 'false' }}">
                @if ($is('admin.patients.indexAdmin*'))
                    <x-heroicon-s-user-group class="w-5 h-5 shrink-0" aria-hidden="true" />
                @else
                    <x-heroicon-o-user-group class="w-5 h-5 shrink-0" aria-hidden="true" />
                @endif
                Manajemen Pasien
            </a>

            {{-- Manajemen Informasi --}}
            <a href="{{ route('admin.informations.indexAdmin') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('admin.informations.indexAdmin*') }}"
                aria-current="{{ $is('admin.informations.indexAdmin*') ? 'page' : 'false' }}">
                @if ($is('admin.informations.indexAdmin*'))
                    <x-heroicon-s-megaphone class="w-5 h-5 shrink-0" aria-hidden="true" />
                @else
                    <x-heroicon-o-megaphone class="w-5 h-5 shrink-0" aria-hidden="true" />
                @endif
                Manajemen Informasi
            </a>

            {{-- Manajemen Saran & Masukan --}}
            <a href="{{ route('admin.suggestions.indexAdmin') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('admin.suggestions.indexAdmin') }}"
                aria-current="{{ $is('admin.suggestions.indexAdmin') ? 'page' : 'false' }}">
                @if ($is('admin.suggestions.indexAdmin'))
                    <x-heroicon-s-chat-bubble-left-right class="w-5 h-5 shrink-0" aria-hidden="true" />
                @else
                    <x-heroicon-o-chat-bubble-left-right class="w-5 h-5 shrink-0" aria-hidden="true" />
                @endif
                Manajemen Saran dan Masukan
            </a>

            {{-- Manajemen Antrian --}}
            <a href="{{ route('admin.queues.indexAdmin') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('admin.queues.indexAdmin') }}"
                aria-current="{{ $is('admin.queues.indexAdmin') ? 'page' : 'false' }}">
                @if ($is('admin.queues.indexAdmin'))
                    <x-heroicon-s-queue-list class="w-5 h-5 shrink-0" aria-hidden="true" />
                @else
                    <x-heroicon-o-queue-list class="w-5 h-5 shrink-0" aria-hidden="true" />
                @endif
                Manajemen Antrian
            </a>

            {{-- Manajemen Pengguna --}}
            <a href="{{ route('admin.users.indexAdmin') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('admin.users.indexAdmin') }}"
                aria-current="{{ $is('admin.users.indexAdmin') ? 'page' : 'false' }}">
                @if ($is('admin.users.indexAdmin'))
                    <x-heroicon-s-users class="w-5 h-5 shrink-0" aria-hidden="true" />
                @else
                    <x-heroicon-o-users class="w-5 h-5 shrink-0" aria-hidden="true" />
                @endif
                Manajemen Pengguna
            </a>

            {{-- Logout --}}
            <form action="{{ route('logout') }}" method="POST" class="pt-1">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-red-600 hover:text-white">
                    <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5 shrink-0" aria-hidden="true" />
                    Logout
                </button>
            </form>
        </nav>

        <div class="p-3 border-t border-slate-200">
            <p class="text-xs font-medium text-slate-600">Copyright Hisyam</p>
            <p class="text-xs text-slate-600">mohammad.121140131@student.itera.ac.id</p>
        </div>
    </aside>

    {{-- Main --}}
    <div class="lg:pl-64">
        <main class="px-4 md:px-6 py-6">
            @yield('content')
        </main>
    </div>

</body>

</html>
