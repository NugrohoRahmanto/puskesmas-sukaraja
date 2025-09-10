@extends(auth()->check() ? 'layouts.user' : 'layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="p-4">
        @if (Auth::check())
            <section aria-labelledby="news-title" class="max-w-6xl mx-auto">
                <h2 class="text-xl md:text-2xl font-semibold text-center">
                    Informasi Terbaru Puskesmas Sukaraja
                </h2>
                <div class="mx-auto mt-3 h-[2px] w-1/2 bg-brand-700"></div>

                <div class="mt-8 grid md:grid-cols-2 gap-x-6 gap-y-6">
                    @forelse ($latestInfo as $info)
                        @php
                            $detailUrl = Route::has('infos.show') ? route('infos.show', $info->id) : '#';
                        @endphp

                        <article class="flex gap-6 bg-white rounded-lg p-6">
                            {{-- Gambar --}}
                            @if ($info->cover)
                                <a href="{{ $detailUrl }}" class="block shrink-0">
                                    <img src="{{ asset('storage/covers/' . $info->cover) }}" alt="{{ $info->judul }}"
                                        loading="lazy" width="300" height="200"
                                        class="w-[200px] h-[100px] object-cover rounded" />
                                </a>
                            @else
                                <a href="{{ $detailUrl }}" class="block shrink-0">
                                    <div
                                        class="w-[300px] h-[200px] rounded bg-slate-200 grid place-items-center text-slate-500 text-sm">
                                        No Image
                                    </div>
                                </a>
                            @endif

                            {{-- Teks --}}
                            <div class="min-w-0">
                                <h3 class="text-lg md:text-xl font-semibold leading-tight">
                                    <a href="{{ $detailUrl }}" class="text-brand-700 hover:underline">
                                        {{ $info->judul }}
                                    </a>
                                </h3>
                                <p class="mt-2 text-[12px] tracking-wide uppercase text-slate-400">
                                    {{ optional($info->created_at)->translatedFormat('d F Y') }}
                                </p>
                                <p class="mt-2 text-slate-600 text-sm line-clamp-3">
                                    {{ Str::limit($info->isi, 200) }}
                                </p>
                            </div>
                        </article>
                    @empty
                        <p class="text-slate-500 text-sm md:col-span-2">Tidak ada informasi terbaru.</p>
                    @endforelse
                </div>
            </section>

            <section role="region" aria-labelledby="urutan-antrian" class="relative mt-16">
                <div class="bg-slate-100 rounded-[22px] overflow-hidden">
                    {{-- header sticky --}}
                    <div class="sticky top-0 bg-brand-700 backdrop-blur px-4 py-3 border-b border-slate-200">
                        <h2 id="urutan-antrian"
                            class="text-lg font-semibold tracking-wide uppercase text-white text-center">
                            Antrian Masuk
                        </h2>
                    </div>

                    @if ($queues->isEmpty())
                        <div class="px-4 py-10 text-center text-lg font-medium text-slate-600">
                            Tidak ada antrian saat ini.
                        </div>
                    @else
                        <div class="overflow-y-auto h-[480px] max-h-[480px] rounded-b-[22px]">
                            <table class="min-w-full text-md border border-slate-200 border-separate border-spacing-0">
                                <thead class="bg-white sticky top-0 z-10 border-b border-slate-200">
                                    <tr>
                                        <th class="px-4 py-2 text-left font-medium">No</th>
                                        <th class="px-4 py-2 text-left font-medium">Pasien</th>
                                        <th class="px-4 py-2 text-left font-medium">Umur</th>
                                        <th class="px-4 py-2 text-left font-medium">Jenis Kelamin</th>
                                        <th class="px-4 py-2 text-left font-medium">Daftar</th>
                                    </tr>
                                </thead>

                                <tbody class="bg-brand-100 divide-y divide-slate-200">
                                    @foreach ($queues as $q)
                                        <tr class="divide-y divide-slate-200">
                                            <td class="px-4 py-3 font-semibold">{{ $q->no_antrian }}</td>
                                            <td class="px-4 py-3">{{ $q->patient->nama_lengkap ?? '-' }}</td>
                                            <td class="px-4 py-3">{{ $q->patient->usia ?? '-' }} Tahun</td>
                                            <td class="px-4 py-3">
                                                @php
                                                    $map = ['L' => 'Laki-laki', 'P' => 'Perempuan'];
                                                    $jk = strtoupper($q->patient->jenis_kelamin ?? '');
                                                @endphp
                                                {{ $map[$jk] ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ optional($q->created_at)->translatedFormat('d M Y, H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </section>

            <div class="mt-8 flex flex-wrap gap-2">
                @if (Auth::check())
                    <a href="{{ route('patients.index') }}"
                        class="inline-flex items-center rounded-xl bg-brand-700 hover:bg-brand-600 text-white text-sm px-4 py-2">
                        Lihat Daftar Pasien
                    </a>
                    <a href="{{ route('suggestions.create') }}"
                        class="inline-flex items-center rounded-xl bg-brand-700 hover:bg-brand-600 text-white text-sm px-4 py-2">
                        Beri Saran/Masukan
                    </a>
                    <a href="{{ route('user.me') }}"
                        class="inline-flex items-center rounded-xl bg-brand-700 hover:bg-brand-600 text-white text-sm px-4 py-2">
                        Lihat Akun
                    </a>
                @else
                    <p class="text-slate-600">Silakan login untuk melihat daftar pasien Anda.</p>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                <section aria-labelledby="panel-informasi">
                    <div class="relative bg-white rounded-[22px] overflow-visible pb-4">
                        <div class="bg-brand-700 backdrop-blur px-4 py-3 border-b border-slate-200">
                            <h2 class="text-lg font-semibold tracking-wide uppercase text-white text-center">
                                Informasi Terbaru Puskesmas Sukaraja
                            </h2>
                        </div>
                        <div class="min-h-[320px] grid place-items-center p-4 text-slate-700">
                            @forelse ($latestInfo as $info)
                                @php
                                    $detailUrl = Route::has('infos.show') ? route('infos.show', $info->id) : '#';
                                @endphp

                                <article class="flex gap-4 p-4">
                                    {{-- Gambar --}}
                                    @if ($info->cover)
                                        <a href="{{ $detailUrl }}" class="block shrink-0">
                                            <img src="{{ asset('storage/covers/' . $info->cover) }}"
                                                alt="{{ $info->judul }}" loading="lazy" width="300" height="200"
                                                class="w-[200px] h-[100px] object-cover rounded" />
                                        </a>
                                    @else
                                        <a href="{{ $detailUrl }}" class="block shrink-0">
                                            <div
                                                class="w-[300px] h-[200px] rounded bg-slate-200 grid place-items-center text-slate-500 text-sm">
                                                No Image
                                            </div>
                                        </a>
                                    @endif

                                    {{-- Teks --}}
                                    <div class="min-w-0">
                                        <h3 class="text-lg md:text-xl font-semibold leading-tight">
                                            <a href="{{ $detailUrl }}" class="text-brand-700 hover:underline">
                                                {{ $info->judul }}
                                            </a>
                                        </h3>
                                        <p class="mt-2 text-[12px] tracking-wide uppercase text-slate-400">
                                            {{ optional($info->created_at)->translatedFormat('d F Y') }}
                                        </p>
                                        <p class="mt-2 text-slate-600 text-sm line-clamp-3">
                                            {{ Str::limit($info->isi, 200) }}
                                        </p>
                                    </div>
                                </article>
                            @empty
                                <p class="text-slate-500 text-sm md:col-span-2">Tidak ada informasi terbaru.</p>
                            @endforelse
                        </div>

                        <div class="absolute left-1/2 bottom-0 -translate-x-1/2 translate-y-1/2 w-full
                            px-5 py-1.5 bg-brand-700 border border-slate-200 rounded-full
                            text-xs sm:text-sm tracking-wide text-white shadow-sm text-center z-10 mx-2">
                            Informasi Kontak Puskesmas • WA: 0812-3456-7890
                        </div>
                    </div>
                </section>

                <section role="region" aria-labelledby="urutan-antrian" class="relative h-full">
                    <div class="bg-slate-100 overflow-hidden">
                        {{-- header sticky --}}
                        <div class="sticky top-0 bg-brand-700 backdrop-blur px-4 py-3 border-b border-slate-200">
                            <h2 id="urutan-antrian"
                                class="text-lg font-semibold tracking-wide uppercase text-white text-center">
                                Antrian Masuk
                            </h2>
                        </div>

                        @if ($queues->isEmpty())
                            <div class="px-4 py-10 text-center text-lg font-medium text-slate-600">
                                Tidak ada antrian saat ini.
                            </div>
                        @else
                            <div class="overflow-y-auto h-[480px] max-h-[480px] rounded-b-[22px]">
                                <table class="min-w-full text-md border border-slate-200 border-separate border-spacing-0">
                                    <thead class="bg-white sticky top-0 z-10 border-b border-slate-200">
                                        <tr>
                                            <th class="px-4 py-2 text-left font-medium">No</th>
                                            <th class="px-4 py-2 text-left font-medium">Pasien</th>
                                            <th class="px-4 py-2 text-left font-medium">Umur</th>
                                            <th class="px-4 py-2 text-left font-medium">Jenis Kelamin</th>
                                            <th class="px-4 py-2 text-left font-medium">Daftar</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-brand-100 divide-y divide-slate-200">
                                        @foreach ($queues as $q)
                                            <tr class="divide-y divide-slate-200">
                                                <td class="px-4 py-3 font-semibold">{{ $q->no_antrian }}</td>
                                                <td class="px-4 py-3">{{ $q->patient->nama_lengkap ?? '-' }}</td>
                                                <td class="px-4 py-3">{{ $q->patient->usia ?? '-' }} Tahun</td>
                                                <td class="px-4 py-3">
                                                    @php
                                                        $map = ['L' => 'Laki-laki', 'P' => 'Perempuan'];
                                                        $jk = strtoupper($q->patient->jenis_kelamin ?? '');
                                                    @endphp
                                                    {{ $map[$jk] ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ optional($q->created_at)->translatedFormat('d M Y, H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </section>

            </div>
        @endif
    </div>
@endsection
