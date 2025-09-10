@extends('layouts.user')
@section('title', 'Ganti Password')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-3xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- Pill Header --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow bg-brand-700 border-slate-200 md:text-lg whitespace-nowrap">
        Ganti Password
      </div>
    </div>

    @php
      $input = 'mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5
                focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                placeholder:text-slate-400';
    @endphp

    {{-- Notifikasi --}}
    @if (session('success'))
      <div class="px-4 py-2 mb-4 text-sm border rounded-lg border-emerald-200 bg-emerald-50 text-emerald-800">
        {{ session('success') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="px-4 py-2 mb-4 text-sm text-red-800 border border-red-200 rounded-lg bg-red-50">
        Terdapat kesalahan pada input. Silakan cek kembali.
      </div>
    @endif

    <form method="POST" action="{{ route('user.me.password.update') }}" class="mt-6">
      @csrf
      @method('PUT')

      <div class="grid gap-6">
        {{-- Password Saat Ini --}}
        <div>
          <label for="current_password" class="block text-sm font-medium text-slate-700">Password Saat Ini</label>
          <input type="password" id="current_password" name="current_password"
                 class="{{ $input }} @error('current_password') border-red-300 ring-1 ring-red-200 @enderror"
                 autocomplete="current-password" placeholder="Masukkan password saat ini">
          @error('current_password')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Password Baru --}}
        <div>
          <label for="new_password" class="block text-sm font-medium text-slate-700">Password Baru</label>
          <input type="password" id="new_password" name="new_password"
                 class="{{ $input }} @error('new_password') border-red-300 ring-1 ring-red-200 @enderror"
                 autocomplete="new-password" placeholder="Minimal 8 karakter">
          @error('new_password')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Konfirmasi Password Baru --}}
        <div>
          <label for="new_password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Password Baru</label>
          <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                 class="{{ $input }}" autocomplete="new-password" placeholder="Ulangi password baru">
        </div>
      </div>

      <div class="flex flex-wrap justify-end gap-3 mt-8">
        <a href="{{ route('user.me') }}"
           class="inline-flex items-center gap-2 rounded-full border border-slate-300 text-slate-700
                  hover:bg-slate-100 px-5 py-2.5">
          <x-heroicon-o-arrow-left class="w-5 h-5"/>
          Batal
        </a>

        <button type="submit"
                class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600
                       text-white px-6 py-2.5">
          <x-heroicon-o-key class="w-5 h-5"/>
          Perbarui Password
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
