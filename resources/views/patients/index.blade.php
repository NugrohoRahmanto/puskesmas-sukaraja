@extends('layouts.user')
@section('title', 'Status Pendaftaran')

@section('content')
    <div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
        <div class="relative bg-slate-100 rounded-[22px] p-6 md:p-8 w-full max-w-5xl">

            <div class="absolute -top-5 left-1/2 -translate-x-1/2">
                <div
                    class="px-6 py-2 bg-brand-700 text-white rounded-full shadow border border-slate-200
                  text-center text-base md:text-lg font-semibold whitespace-nowrap">
                    Status Pendaftaran
                </div>
            </div>

            @php
                $patient =
                    $lastPatient ??
                    (isset($patients) && $patients instanceof \Illuminate\Support\Collection
                        ? $patients->sortByDesc('created_at')->first()
                        : null);

                $queue =
                    optional($patient)->latestQueue ??
                    (optional($patient)->queues ? $patient->queues->sortByDesc('created_at')->first() : null);

                // Map label
                $jkMap = ['L' => 'Laki - Laki', 'P' => 'Perempuan'];
                $jk = $jkMap[strtoupper(optional($patient)->jenis_kelamin ?? '')] ?? '-';
                $usia = optional($patient)->usia;
                $usiaLabel = is_null($usia) ? '-' : ($usia < 18 ? 'Anak-anak' : ($usia < 60 ? 'Dewasa' : 'Lansia'));
                $jaminan = optional($patient)->jaminan_kesehatan ?? (optional($patient)->jaminan ?? '-');

                $status = strtolower(optional($queue)->status ?? (optional($patient)->status ?? 'menunggu'));
                $statusLabelMap = [
                    'diterima' => 'Diterima',
                    'menunggu' => 'Menunggu',
                    'dipanggil' => 'Dipanggil',
                    'dilayani' => 'Dilayani',
                    'selesai' => 'Selesai',
                    'batal' => 'Batal',
                ];
                $statusClassMap = [
                    'diterima' => 'bg-blue-600 text-white ring-2 ring-blue-300',
                    'menunggu' => 'bg-amber-500 text-white ring-2 ring-amber-300',
                    'dipanggil' => 'bg-sky-600 text-white ring-2 ring-sky-300',
                    'dilayani' => 'bg-emerald-600 text-white ring-2 ring-emerald-300',
                    'selesai' => 'bg-slate-600 text-white ring-2 ring-slate-300',
                    'batal' => 'bg-red-600 text-white ring-2 ring-red-300',
                ];
                $statusLabel = $statusLabelMap[$status] ?? ucfirst($status);
                $statusClass = $statusClassMap[$status] ?? $statusClassMap['menunggu'];
            @endphp

            @if (!$patient)
                <div class="text-center text-slate-600 py-12">
                    <p class="mb-4">Anda belum mendaftarkan pasien.</p>
                    <a href="{{ route('patients.createWithQueue') }}"
                        class="inline-flex rounded-full bg-brand-700 hover:bg-brand-600 text-white px-5 py-2.5">
                        Tambah Pasien
                    </a>
                </div>
            @else
                <div class="flex items-center gap-2 mb-6">

                    {{-- <span class="inline-flex rounded-full bg-emerald-600 text-white text-xs px-3 py-1">Status</span>
        <span class="inline-flex rounded-full text-xs px-3 py-1 {{ $statusClass }}">{{ $statusLabel }}</span>
        --}}
                    <span class="ml-auto text-sm text-slate-500">
                        No. Antrian:
                        <span class="font-semibold text-slate-800">{{ optional($queue)->no_antrian ?? '-' }}</span>
                    </span>
                </div>

                {{-- Detail pasien --}}
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="space-y-6">
                        <div>
                            <p class="text-sm text-slate-500">NIK</p>
                            <div class="mt-1 rounded-full bg-white border border-slate-200 px-4 py-2.5">
                                {{ $patient->nik ?? '-' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Nama Lengkap</p>
                            <div class="mt-1 rounded-full bg-white border border-slate-200 px-4 py-2.5">
                                {{ $patient->nama_lengkap ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <p class="text-sm text-slate-500">Jenis Kelamin</p>
                            <div class="mt-1 rounded-full bg-white border border-slate-200 px-4 py-2.5">{{ $jk }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Usia</p>
                            <div class="mt-1 rounded-full bg-white border border-slate-200 px-4 py-2.5">{{ $usiaLabel }}
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <p class="text-sm text-slate-500">Jaminan Kesehatan</p>
                            <div class="mt-1 rounded-full bg-white border border-slate-200 px-4 py-2.5">{{ $jaminan }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Tanggal Lahir</p>
                            <div class="mt-1 rounded-full bg-white border border-slate-200 px-4 py-2.5">
                                {{ optional($patient->tanggal_lahir)->translatedFormat('d F Y') ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <button type="button"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-slate-300 bg-brand-700 hover:bg-brand-600"
                        title="Aktifkan notifikasi">
                        <x-heroicon-o-bell class="w-5 h-5 text-white" />
                    </button>
                    <a href=""
                        class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600 text-white text-sm px-5 py-2.5">
                        <x-heroicon-o-printer class="w-5 h-5" />
                        Print
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
