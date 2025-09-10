@extends('layouts.user')

@section('title', 'Tambah Pasien & Antrian')

@section('content')
    <div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
        <div class="relative bg-slate-100 rounded-[22px] p-6 md:p-8 w-full max-w-5xl">

            <div class="absolute -top-5 left-1/2 -translate-x-1/2">
                <div
                    class="px-6 py-2 bg-brand-700 text-white rounded-full shadow border border-slate-200
                  text-center text-base md:text-lg font-semibold whitespace-nowrap">
                    Form Pendaftaran Pasien
                </div>
            </div>

            @php
                $input =
                    'mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400 placeholder:text-slate-400';
                $select = 'appearance-none pr-10 ' . $input;
            @endphp

            <form action="{{ route('patients.storeWithQueue') }}" method="POST" class="mt-6">
                @csrf

                <div class="grid gap-8 lg:grid-cols-2">
                    {{-- KOLOM KIRI --}}
                    <div class="lg:rows-span-2 grid sm:grid-rows-2 gap-8">
                        {{-- Nama Lengkap --}}
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" required autofocus
                                value="{{ old('nama_lengkap') }}"
                                class="{{ $input }} @error('nama_lengkap') border-red-300 ring-1 ring-red-200 @enderror"
                                placeholder="Nama lengkap pasien" />
                            @error('nama_lengkap')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700">Jenis
                                Kelamin</label>
                            <div class="relative">
                                <select name="jenis_kelamin" id="jenis_kelamin" required
                                    class="{{ $select }} @error('jenis_kelamin') border-red-300 ring-1 ring-red-200 @enderror">
                                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih
                                    </option>
                                    <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki - Laki
                                    </option>
                                    <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="lg:rows-span-2 grid sm:grid-rows-2 gap-8">
                        {{-- Usia --}}
                        <div>
                            <label for="usia" class="block text-sm font-medium text-slate-700">Usia</label>
                            <input type="number" name="usia" id="usia" min="0" max="120"
                                inputmode="numeric" value="{{ old('usia') }}"
                                class="{{ $input }} @error('usia') border-red-300 ring-1 ring-red-200 @enderror"
                                placeholder="cth. 32" />
                            @error('usia')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor Telepon --}}
                        <div>
                            <label for="no_tel" class="block text-sm font-medium text-slate-700">Nomor Telepon</label>
                            <input type="text" name="no_tel" id="no_tel" inputmode="tel" value="{{ old('no_tel') }}"
                                class="{{ $input }} @error('no_tel') border-red-300 ring-1 ring-red-200 @enderror"
                                placeholder="08xxxxxxxxxx">
                            @error('no_tel')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600
                       text-white text-sm px-6 py-2.5">
                        <x-heroicon-o-paper-airplane class="w-5 h-5" />
                        Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
