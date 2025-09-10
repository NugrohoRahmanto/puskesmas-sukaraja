@extends(auth()->check() ? 'layouts.user' : 'layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="p-4">
        @if (Auth::check())
           {{-- GRID 2 KOLOM: KIRI = ANTRIAN, KANAN = INFORMASI --}}
            <div class="grid items-start grid-cols-1 gap-8 md:grid-cols-2">

                {{-- KIRI: Urutan Antrian (list sederhana: No + Nama) --}}
                <section role="region" aria-labelledby="urutan-antrian" class="relative">
                <div class="bg-slate-100 rounded-[22px] overflow-hidden">
                    {{-- Header --}}
                    <div class="sticky top-0 px-4 py-3 border-b bg-brand-700 border-slate-200">
                    <h2 id="urutan-antrian"
                        class="text-lg font-semibold tracking-wide text-center text-white uppercase">
                        Antrian Masuk
                    </h2>
                    </div>

                    @if ($queues->isEmpty())
                    <div class="px-4 py-10 text-lg font-medium text-center text-slate-600">
                        Tidak ada antrian saat ini.
                    </div>
                    @else
                    {{-- Area scroll --}}
                    <div class="h-[420px] overflow-y-auto rounded-b-[22px]">
                        <table class="min-w-full text-sm border border-separate border-slate-200 border-spacing-0">
                        {{-- Sticky header tabel --}}
                        <thead class="sticky top-0 z-10">
                            <tr class="bg-white">
                            <th class="px-4 py-2 text-left font-medium border-b border-slate-200 w-[90px]">No</th>
                            <th class="px-4 py-2 font-medium text-left border-b border-slate-200">Pasien</th>
                            </tr>
                        </thead>

                        <tbody class="bg-brand-100">
                            @foreach ($queues as $q)
                            <tr class="border-b odd:bg-white even:bg-brand-50 border-slate-200">
                                <td class="px-4 py-3 font-semibold tabular-nums">{{ $q->no_antrian }}</td>
                                <td class="px-4 py-3">
                                {{ $q->patient->nama ?? '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                </section>



                {{-- KANAN: Informasi Terbaru --}}
                <section aria-labelledby="news-title" class="w-full max-w-3xl mx-auto">
                    <h2 id="news-title" class="text-xl font-semibold text-center md:text-2xl">
                        Informasi Terbaru Puskesmas Sukaraja
                    </h2>
                    <div class="mx-auto mt-3 h-[2px] w-1/2 bg-brand-700"></div>

                    <div class="grid gap-6 mt-8">
                        @forelse ($latestInfo as $info)
                            @php
                                $detailUrl = Route::has('infos.show') ? route('infos.show', $info->id) : '#';
                            @endphp

                            <article class="flex gap-4 p-4 bg-white border rounded-lg border-slate-200">
                                {{-- Gambar --}}
                                @if ($info->cover)
                                    <a href="{{ $detailUrl }}" class="block shrink-0">
                                        <img src="{{ asset('storage/covers/' . $info->cover) }}" alt="{{ $info->judul }}"
                                            loading="lazy" width="220" height="140"
                                            class="w-[200px] h-[110px] object-cover rounded" />
                                    </a>
                                @else
                                    <a href="{{ $detailUrl }}" class="block shrink-0">
                                        <div class="w-[200px] h-[110px] rounded bg-slate-200 grid place-items-center text-slate-500 text-sm">
                                            No Image
                                        </div>
                                    </a>
                                @endif

                                {{-- Teks --}}
                                <div class="min-w-0">
                                    <h3 class="text-lg font-semibold leading-tight">
                                        <a href="{{ $detailUrl }}" class="text-brand-700 hover:underline">
                                            {{ $info->judul }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-[12px] tracking-wide uppercase text-slate-400">
                                        {{ optional($info->created_at)->translatedFormat('d F Y') }}
                                    </p>
                                    <p class="mt-2 text-sm text-slate-600 line-clamp-3">
                                        {{ Str::limit($info->isi, 200) }}
                                    </p>
                                </div>
                            </article>
                        @empty
                            <p class="text-sm text-slate-500">Tidak ada informasi terbaru.</p>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- CTA --}}
            <div class="flex flex-wrap gap-2 mt-8">
                <a href="{{ route('patients.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm text-white rounded-xl bg-brand-700 hover:bg-brand-600">
                    Lihat Daftar Pasien
                </a>
                <a href="{{ route('suggestions.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm text-white rounded-xl bg-brand-700 hover:bg-brand-600">
                    Beri Saran/Masukan
                </a>
                <a href="{{ route('user.me') }}"
                class="inline-flex items-center px-4 py-2 text-sm text-white rounded-xl bg-brand-700 hover:bg-brand-600">
                    Lihat Akun
                </a>
            </div>

        @else
            <div class="grid items-start grid-cols-1 gap-8 lg:grid-cols-2">

            {{-- KIRI: Antrian Masuk (list sederhana) --}}
            <section role="region" aria-labelledby="urutan-antrian" class="relative">
            <div class="bg-slate-100 rounded-[22px] overflow-hidden">
                {{-- Header --}}
                <div class="sticky top-0 px-4 py-3 border-b bg-brand-700 border-slate-200">
                <h2 id="urutan-antrian"
                    class="text-lg font-semibold tracking-wide text-center text-white uppercase">
                    Antrian Masuk
                </h2>
                </div>

                @if ($queues->isEmpty())
                <div class="px-4 py-10 text-lg font-medium text-center text-slate-600">
                    Tidak ada antrian saat ini.
                </div>
                @else
                {{-- Area scroll --}}
                <div class="h-[420px] overflow-y-auto rounded-b-[22px]">
                    <table class="min-w-full text-sm border border-separate border-slate-200 border-spacing-0">
                    {{-- Sticky header tabel --}}
                    <thead class="sticky top-0 z-10">
                        <tr class="bg-white">
                        <th class="px-4 py-2 text-left font-medium border-b border-slate-200 w-[90px]">No</th>
                        <th class="px-4 py-2 font-medium text-left border-b border-slate-200">Pasien</th>
                        </tr>
                    </thead>

                    <tbody class="bg-brand-100">
                        @foreach ($queues as $q)
                        <tr class="border-b odd:bg-white even:bg-brand-50 border-slate-200">
                            <td class="px-4 py-3 font-semibold tabular-nums">{{ $q->no_antrian }}</td>
                            <td class="px-4 py-3">
                            {{ $q->patient->nama ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                @endif
            </div>
            </section>


            {{-- KANAN: Panel Informasi --}}
            <section aria-labelledby="panel-informasi">
                <div class="relative bg-white rounded-[22px] overflow-visible pb-4 border border-slate-200">
                    <div class="px-4 py-3 border-b bg-brand-700 backdrop-blur border-slate-200">
                        <h2 class="text-lg font-semibold tracking-wide text-center text-white uppercase">
                            Informasi Terbaru Puskesmas Sukaraja
                        </h2>
                    </div>

                    <div class="min-h-[320px] p-4 text-slate-700">
                        @forelse ($latestInfo as $info)
                            @php
                                $detailUrl = Route::has('infos.show') ? route('infos.show', $info->id) : '#';
                            @endphp

                            <article class="flex gap-4 p-4">
                                {{-- Gambar --}}
                                @if ($info->cover)
                                    <a href="{{ $detailUrl }}" class="block shrink-0">
                                        <img src="{{ asset('storage/covers/' . $info->cover) }}"
                                            alt="{{ $info->judul }}" loading="lazy" width="220" height="140"
                                            class="w-[200px] h-[110px] object-cover rounded" />
                                    </a>
                                @else
                                    <a href="{{ $detailUrl }}" class="block shrink-0">
                                        <div class="w-[200px] h-[110px] rounded bg-slate-200 grid place-items-center text-slate-500 text-sm">
                                            No Image
                                        </div>
                                    </a>
                                @endif

                                {{-- Teks --}}
                                <div class="min-w-0">
                                    <h3 class="text-lg font-semibold leading-tight">
                                        <a href="{{ $detailUrl }}" class="text-brand-700 hover:underline">
                                            {{ $info->judul }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-[12px] tracking-wide uppercase text-slate-400">
                                        {{ optional($info->created_at)->translatedFormat('d F Y') }}
                                    </p>
                                    <p class="mt-2 text-sm text-slate-600 line-clamp-3">
                                        {{ Str::limit($info->isi, 200) }}
                                    </p>
                                </div>
                            </article>
                        @empty
                            <p class="text-sm text-slate-500">Tidak ada informasi terbaru.</p>
                        @endforelse
                    </div>

                    <div class="absolute left-1/2 bottom-0 -translate-x-1/2 translate-y-1/2 w-full
                        px-5 py-1.5 bg-brand-700 border border-slate-200 rounded-full
                        text-xs sm:text-sm tracking-wide text-white shadow-sm text-center z-10 mx-2">
                        Informasi Kontak Puskesmas • WA: 0812-3456-7890
                    </div>
                </div>
            </section>

        </div>

        @endif
    </div>
@endsection
