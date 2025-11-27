<div class="flex-1 flex flex-col h-full">
    <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
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
</div>
