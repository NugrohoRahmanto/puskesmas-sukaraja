@extends('layouts.user')

@section('title', 'Tambah Saran')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative bg-slate-100 rounded-[22px] p-6 md:p-8 w-full max-w-2xl">

    {{-- Pill judul --}}
    <div class="absolute -top-5 left-1/2 -translate-x-1/2">
      <div class="px-6 py-2 bg-brand-700 text-white rounded-full shadow border border-slate-200
                  text-center text-base md:text-lg font-semibold whitespace-nowrap">
        Form Saran & Masukan
      </div>
    </div>

    @php
      $input = 'mt-2 w-full rounded-2xl bg-white border border-slate-200 px-4 py-3
                focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                placeholder:text-slate-400';
    @endphp

    @if ($errors->any())
      <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('suggestions.store') }}" method="POST" class="mt-6 space-y-6">
      @csrf

      <div>
        <label for="keterangan" class="block text-sm font-medium text-slate-700">Keterangan Saran</label>
        <textarea id="keterangan" name="keterangan" rows="6" required
                  class="{{ $input }} @error('keterangan') border-red-300 ring-1 ring-red-200 @enderror"
                  placeholder="Tulis saran atau masukan Anda...">{{ old('keterangan') }}</textarea>
        @error('keterangan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      <div class="flex items-center justify-end gap-2">
        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-2 rounded-full bg-white hover:bg-red-600 hover:text-white
                       text-sm px-6 py-2.5">
          Batal
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600
                       text-white text-sm px-6 py-2.5">
          <x-heroicon-o-paper-airplane class="w-5 h-5" />
          Kirim
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
