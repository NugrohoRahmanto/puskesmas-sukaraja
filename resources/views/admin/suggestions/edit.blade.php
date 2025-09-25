@extends('layouts.admin')
@section('title','Edit Saran')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-3xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Edit Saran
      </div>
    </div>

    @php
      $input    = 'mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5
                   focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                   placeholder:text-slate-400';
      $textarea = 'mt-2 w-full rounded-2xl bg-white border border-slate-200 px-4 py-3
                   focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                   placeholder:text-slate-400';
    @endphp

    {{-- ALERT ERROR --}}
    @if ($errors->any())
      <div class="px-4 py-2 mb-4 text-sm rounded-lg border border-red-200 bg-red-50 text-red-700">
        Terdapat kesalahan pada input. Silakan periksa kembali.
      </div>
    @endif

    <form action="{{ route('admin.suggestions.updateAdmin', $suggestion->id_saran) }}" method="POST" class="mt-6 space-y-6">
      @csrf
      @method('PUT')

      {{-- Keterangan --}}
      <div>
        <label for="keterangan" class="block text-sm font-medium text-slate-700">Keterangan</label>
        <textarea name="keterangan" id="keterangan" rows="8" required
                  class="{{ $textarea }} @error('keterangan') border-red-300 ring-1 ring-red-200 @enderror"
                  placeholder="Tulis saran di sini...">{{ old('keterangan', $suggestion->keterangan) }}</textarea>
        @error('keterangan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Aksi --}}
      <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('admin.suggestions.indexAdmin') }}"
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
