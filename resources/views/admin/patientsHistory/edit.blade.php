@extends('layouts.admin')
@section('title','Edit Riwayat Pasien')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-3xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Edit Riwayat Pasien
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

    <form action="{{ route('admin.patientsHistory.updateAdmin', $history->id_history) }}" method="POST" class="mt-6 space-y-6">
      @csrf
      @method('PUT')

      {{-- NIK --}}
      <div>
        <label for="nik" class="block text-sm font-medium text-slate-700">NIK</label>
        <input type="text" id="nik" name="nik" required inputmode="numeric" maxlength="16" pattern="[0-9]{16}"
               value="{{ old('nik', $history->nik) }}"
               oninput="this.value=this.value.replace(/\D/g,'').slice(0,16)"
               class="{{ $input }} @error('nik') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="16 digit NIK" @error('nik') aria-invalid="true" @enderror>
        @error('nik') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Nama Lengkap --}}
      <div>
        <label for="nama" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" required
               value="{{ old('nama', $history->nama) }}"
               class="{{ $input }} @error('nama') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="Nama pasien" @error('nama') aria-invalid="true" @enderror>
        @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Gender --}}
      <div>
        <span class="block text-sm font-medium text-slate-700">Jenis Kelamin</span>
        @php $genderValue = old('gender', $history->gender ?? 'Laki-laki'); @endphp
        <div class="flex flex-wrap gap-3 mt-2">
          <label class="cursor-pointer">
            <input type="radio" name="gender" value="Laki-laki" class="sr-only peer"
                   {{ $genderValue === 'Laki-laki' ? 'checked' : '' }}>
            <span class="inline-flex items-center rounded-full border px-4 py-2 text-sm transition
                         border-slate-200 bg-white text-slate-600 peer-checked:border-brand-400 peer-checked:bg-brand-50 peer-checked:text-brand-700">
              Laki-laki
            </span>
          </label>
          <label class="cursor-pointer">
            <input type="radio" name="gender" value="Perempuan" class="sr-only peer"
                   {{ $genderValue === 'Perempuan' ? 'checked' : '' }}>
            <span class="inline-flex items-center rounded-full border px-4 py-2 text-sm transition
                         border-slate-200 bg-white text-slate-600 peer-checked:border-brand-400 peer-checked:bg-brand-50 peer-checked:text-brand-700">
              Perempuan
            </span>
          </label>
        </div>
        @error('gender') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Pernah Berobat --}}
      <div>
        <label for="pernah_berobat" class="block text-sm font-medium text-slate-700">Pernah Berobat</label>
        <div class="relative">
          <select id="pernah_berobat" name="pernah_berobat" required
                  class="{{ $select }} @error('pernah_berobat') border-red-300 ring-1 ring-red-200 @enderror"
                  @error('pernah_berobat') aria-invalid="true" @enderror>
            <option value="" disabled {{ old('pernah_berobat', $history->pernah_berobat) ? '' : 'selected' }}>Pilih</option>
            <option value="Ya" {{ old('pernah_berobat', $history->pernah_berobat) === 'Ya' ? 'selected' : '' }}>Ya</option>
            <option value="Tidak" {{ old('pernah_berobat', $history->pernah_berobat) === 'Tidak' ? 'selected' : '' }}>Tidak</option>
          </select>
        </div>
        @error('pernah_berobat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- No Antrian & Tanggal --}}
      <div class="grid gap-6 sm:grid-cols-2">
        <div>
          <label for="no_antrian" class="block text-sm font-medium text-slate-700">No Antrian</label>
          <input type="number" id="no_antrian" name="no_antrian" min="1" step="1" required
                 value="{{ old('no_antrian', $history->no_antrian) }}"
                 class="{{ $input }} @error('no_antrian') border-red-300 ring-1 ring-red-200 @enderror"
                 placeholder="mis. 12" @error('no_antrian') aria-invalid="true" @enderror>
          @error('no_antrian') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="tanggal" class="block text-sm font-medium text-slate-700">Tanggal</label>
          <input type="date" id="tanggal" name="tanggal"
                 value="{{ old('tanggal', $history->tanggal) }}"
                 class="{{ $input }} @error('tanggal') border-red-300 ring-1 ring-red-200 @enderror"
                 @error('tanggal') aria-invalid="true" @enderror>
          @error('tanggal') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- Aksi --}}
      <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('admin.patientsHistory.indexAdmin') }}"
           class="inline-flex items-center gap-2 rounded-full border bg-white border-slate-300 text-slate-700
                  hover:bg-slate-100 px-5 py-2.5">
          <x-heroicon-o-arrow-left class="w-5 h-5" />
          Kembali
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600
                       text-white text-sm px-6 py-2.5">
          <x-heroicon-o-check class="w-5 h-5" />
          Update
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
