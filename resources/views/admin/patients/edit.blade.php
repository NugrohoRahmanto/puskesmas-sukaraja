@extends('layouts.admin')
@section('title','Edit Pasien')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-3xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Edit Pasien
      </div>
    </div>

    @php
      $input  = 'mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5
                 focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                 placeholder:text-slate-400';
      $select = 'appearance-none pr-10 '.$input;
    @endphp

    {{-- ALERT ERROR --}}
    @if ($errors->any())
      <div class="px-4 py-2 mb-4 text-sm rounded-lg border border-red-200 bg-red-50 text-red-700">
        Terdapat kesalahan pada input. Silakan periksa kembali.
      </div>
    @endif

    <form action="{{ route('admin.patients.updateAdmin', $patient->id_pasien) }}" method="POST" class="mt-6 space-y-6">
      @csrf
      @method('PUT')

      {{-- NIK --}}
      <div>
        <label for="nik" class="block text-sm font-medium text-slate-700">NIK</label>
        <input type="text" id="nik" name="nik" required inputmode="numeric" maxlength="16" pattern="[0-9]{16}"
               value="{{ old('nik', $patient->nik) }}"
               oninput="this.value=this.value.replace(/\D/g,'').slice(0,16)"
               class="{{ $input }} @error('nik') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="16 digit NIK" @error('nik') aria-invalid="true" @enderror>
        @error('nik') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Nama Lengkap --}}
      <div>
        <label for="nama" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" required
               value="{{ old('nama', $patient->nama) }}"
               class="{{ $input }} @error('nama') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="Nama pasien" @error('nama') aria-invalid="true" @enderror>
        @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Pernah Berobat --}}
      <div>
        <label for="pernah_berobat" class="block text-sm font-medium text-slate-700">Pernah Berobat</label>
        <div class="relative">
          <select id="pernah_berobat" name="pernah_berobat" required
                  class="{{ $select }} @error('pernah_berobat') border-red-300 ring-1 ring-red-200 @enderror"
                  @error('pernah_berobat') aria-invalid="true" @enderror>
            <option value="" disabled {{ old('pernah_berobat', $patient->pernah_berobat) ? '' : 'selected' }}>Pilih</option>
            <option value="Ya" {{ old('pernah_berobat', $patient->pernah_berobat) === 'Ya' ? 'selected' : '' }}>Ya</option>
            <option value="Tidak" {{ old('pernah_berobat', $patient->pernah_berobat) === 'Tidak' ? 'selected' : '' }}>Tidak</option>
          </select>
        </div>
        @error('pernah_berobat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- AKSI --}}
      <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('admin.patients.indexAdmin') }}"
           class="inline-flex items-center gap-2 rounded-full border bg-white border-slate-300 text-slate-700
                  hover:bg-slate-100 px-5 py-2.5">
          <x-heroicon-o-arrow-left class="w-5 h-5" />
          Kembali
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600
                       text-white text-sm px-6 py-2.5">
          <x-heroicon-o-check class="w-5 h-5" />
          Update Pasien
        </button>
      </div>
    </form>

  </div>
</div>
@endsection
