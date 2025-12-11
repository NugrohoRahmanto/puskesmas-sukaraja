@extends('layouts.app')
@section('title', 'Daftar Antrian')

@section('content')
    <div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
        <div class="relative w-full max-w-4xl bg-slate-100 rounded-[22px] p-6 md:p-8">

            <div class="absolute -translate-x-1/2 -top-5 left-1/2">
                <div class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow bg-brand-700 border-slate-200 md:text-lg whitespace-nowrap">
                    Daftar Antrian Hari Ini
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="button" onclick="window.location.reload()"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-100">
                    <x-heroicon-o-arrow-path class="w-4 h-4" />
                    Refresh
                </button>
            </div>

            @if($queues->isEmpty())
                <div class="px-4 py-12 text-center text-slate-600 bg-white border border-slate-200 rounded-2xl">
                    Tidak ada pasien dalam antrian saat ini.
                </div>
            @else
                <div class="overflow-hidden bg-white border border-slate-200 rounded-2xl">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium w-32">No Urut</th>
                                <th class="px-4 py-3 text-left font-medium">Nama Pasien</th>
                                <th class="px-4 py-3 text-left font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($queues as $queue)
                                @php
                                    $name = $queue->patient->nama ?? $queue->patient->nama_lengkap ?? '—';
                                    $pernah = $queue->patient->pernah_berobat ?? null;
                                @endphp
                                <tr class="bg-white hover:bg-brand-50/40">
                                    <td class="px-4 py-3 font-semibold tabular-nums text-slate-900">{{ $queue->display_no ?? $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-slate-700">{{ $name }}</td>
                                    <td class="px-4 py-3">
                                        @if($pernah === 'Ya')
                                            <span class="inline-flex items-center rounded-full bg-emerald-600 text-white text-xs px-2.5 py-1">Pernah Berobat</span>
                                        @elseif($pernah === 'Tidak')
                                            <span class="inline-flex items-center rounded-full bg-slate-600 text-white text-xs px-2.5 py-1">Belum</span>
                                        @else
                                            <span class="text-slate-400 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <p class="mt-4 text-xs text-center text-slate-500">
                Tampilan nomor antrian selalu dimulai dari 1 setiap hari dan menyesuaikan dengan pasien yang belum dipanggil.
            </p>
        </div>
    </div>
@endsection
