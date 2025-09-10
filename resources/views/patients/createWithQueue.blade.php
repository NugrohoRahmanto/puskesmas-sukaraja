@extends('layouts.user')

@section('title', 'Tambah Pasien & Antrian')

@section('content')
    <div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
        <div class="relative bg-slate-100 rounded-[22px] p-6 md:p-8 w-full max-w-5xl">

            <div class="absolute -translate-x-1/2 -top-5 left-1/2">
                <div
                    class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow bg-brand-700 border-slate-200 md:text-lg whitespace-nowrap">
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

            @php
                $input =
                    'mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400 placeholder:text-slate-400';
                $select = 'appearance-none pr-10 ' . $input;
            @endphp

            <div class="grid gap-8">
                {{-- NIK --}}
                <div>
                    <label for="nik" class="block text-sm font-medium text-slate-700">NIK</label>
                    <input type="text" name="nik" id="nik" required inputmode="numeric" pattern="[0-9]{16}"
                        value="{{ old('nik') }}"
                        class="{{ $input }} @error('nik') border-red-300 ring-1 ring-red-200 @enderror"
                        placeholder="16 digit NIK" />
                    @error('nik')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama --}}
                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700">Nama</label>
                    <input type="text" name="nama" id="nama" required
                        value="{{ old('nama') }}"
                        class="{{ $input }} @error('nama') border-red-300 ring-1 ring-red-200 @enderror"
                        placeholder="Nama pasien" />
                    @error('nama')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pernah Berobat --}}
                <div>
                    <label for="pernah_berobat" class="block text-sm font-medium text-slate-700">Sudah Pernah Berobat Sebelumnya?</label>
                    <div class="relative">
                        <select name="pernah_berobat" id="pernah_berobat" required
                                class="{{ $select }} @error('pernah_berobat') border-red-300 ring-1 ring-red-200 @enderror">
                            <option value="" disabled {{ old('pernah_berobat') ? '' : 'selected' }}>Pilih</option>
                            <option value="Ya" {{ old('pernah_berobat') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('pernah_berobat') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    @error('pernah_berobat')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-8">
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
