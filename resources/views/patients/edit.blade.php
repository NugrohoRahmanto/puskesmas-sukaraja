@extends('layouts.user')
@section('title', 'Edit Pasien')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative bg-slate-100 rounded-[22px] p-6 md:p-8 w-full max-w-5xl">

    {{-- Pill Header --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow bg-brand-700 border-slate-200 md:text-lg whitespace-nowrap">
        Edit Data Pasien
      </div>
    </div>

    @php
      $input = 'mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5
                focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                placeholder:text-slate-400';
      $select = 'appearance-none pr-10 ' . $input;
    @endphp

    {{-- Alert error validasi --}}
    @if ($errors->any())
      <div class="px-4 py-2 mb-4 text-sm text-red-800 border border-red-200 rounded-lg bg-red-50">
        Terdapat kesalahan pada input. Silakan periksa kembali.
      </div>
    @endif

    <form action="{{ route('patients.update', $patient->id_pasien) }}" method="POST" class="mt-6">
      @csrf
      @method('PUT')

      <div class="grid gap-8">
        {{-- NIK --}}
        <div>
          <label for="nik" class="block text-sm font-medium text-slate-700">NIK</label>
          <input type="text" id="nik" name="nik" required inputmode="numeric" pattern="[0-9]{16}"
                 value="{{ old('nik', $patient->nik) }}"
                 class="{{ $input }} @error('nik') border-red-300 ring-1 ring-red-200 @enderror"
                 placeholder="16 digit NIK">
          @error('nik')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Nama --}}
        <div>
          <label for="nama" class="block text-sm font-medium text-slate-700">Nama</label>
          <input type="text" id="nama" name="nama" required
                 value="{{ old('nama', $patient->nama) }}"
                 class="{{ $input }} @error('nama') border-red-300 ring-1 ring-red-200 @enderror"
                 placeholder="Nama pasien">
          @error('nama')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Pernah Berobat --}}
        <div>
          <label for="pernah_berobat" class="block text-sm font-medium text-slate-700">Sudah Pernah Berobat Sebelumnya?</label>
          <div class="relative">
            <select id="pernah_berobat" name="pernah_berobat" required
                    class="{{ $select }} @error('pernah_berobat') border-red-300 ring-1 ring-red-200 @enderror">
              <option value="" disabled {{ old('pernah_berobat', $patient->pernah_berobat) ? '' : 'selected' }}>Pilih</option>
              <option value="Ya" {{ old('pernah_berobat', $patient->pernah_berobat) === 'Ya' ? 'selected' : '' }}>Ya</option>
              <option value="Tidak" {{ old('pernah_berobat', $patient->pernah_berobat) === 'Tidak' ? 'selected' : '' }}>Tidak</option>
            </select>
          </div>
          @error('pernah_berobat')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="flex items-center justify-end gap-3 mt-8">
        <a href="{{ route('patients.index') }}"
           class="inline-flex items-center gap-2 rounded-full border bg-white border-slate-300 text-slate-700
                  hover:bg-slate-100 px-5 py-2.5">
          <x-heroicon-o-arrow-left class="w-5 h-5" />
          Kembali
        </a>

        <button type="submit"
                class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600
                       text-white text-sm px-6 py-2.5">
          <x-heroicon-o-check class="w-5 h-5" />
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
