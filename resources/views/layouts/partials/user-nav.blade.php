<div class="flex-1 flex flex-col h-full">
    <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('dashboard') }}"
            aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
            <x-heroicon-s-home class="w-5 h-5 shrink-0" aria-hidden="true" />
            Dashboard
        </a>

        {{-- Pendaftaran Pasien --}}
        <a href="{{ route('patients.createWithQueue') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('patients.createWithQueue') }}"
            aria-current="{{ request()->routeIs('patients.createWithQueue') ? 'page' : 'false' }}">
            <x-heroicon-s-user-plus class="w-5 h-5 shrink-0" aria-hidden="true" />
            Pendaftaran Pasien
        </a>

        {{-- Status Pendaftaran --}}
        <a href="{{ route('patients.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('patients.index') }}"
            aria-current="{{ request()->routeIs('patients.index') ? 'page' : 'false' }}">
            <x-heroicon-s-clipboard-document-check class="w-5 h-5 shrink-0" aria-hidden="true" />
            Status Pendaftaran
        </a>

        {{-- Saran dan Masukan --}}
        <a href="{{ route('suggestions.create') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('suggestions.create') }}"
            aria-current="{{ request()->routeIs('suggestions.create') ? 'page' : 'false' }}">
            <x-heroicon-s-chat-bubble-left-right class="w-5 h-5 shrink-0" aria-hidden="true" />
            Saran dan Masukan
        </a>

        {{-- Profil / Akun --}}
        <a href="{{ route('user.me') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $active('user.me') }}"
            aria-current="{{ request()->routeIs('user.me') ? 'page' : 'false' }}">
            <x-heroicon-s-user-circle class="w-5 h-5 shrink-0" aria-hidden="true" />
            Profil Saya
        </a>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="pt-1">
            @csrf
            <button type="submit"
                class="flex items-center w-full gap-3 px-3 py-2 text-sm rounded-lg text-slate-600 hover:bg-red-600 hover:text-white">
                <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5 shrink-0" aria-hidden="true" />
                Logout
            </button>
        </form>
    </nav>

    <div class="p-3 border-t border-slate-200">
        <p class="text-xs font-medium text-slate-600">Copyright Hisyam</p>
        <p class="text-xs text-slate-600">mohammad.121140131@student.itera.ac.id</p>
    </div>
</div>
