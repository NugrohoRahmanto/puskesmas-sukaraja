@extends('layouts.user')
@section('title', 'Edit Profil')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-4xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- Pill Header --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow bg-brand-700 border-slate-200 md:text-lg whitespace-nowrap">
        Edit Profil
      </div>
    </div>

    @php
      $input = 'mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5
                focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                placeholder:text-slate-400';
    @endphp

    {{-- Notifikasi umum --}}
    @if ($errors->any())
      <div class="px-4 py-2 mb-4 text-sm text-red-800 border border-red-200 rounded-lg bg-red-50">
        Terdapat kesalahan pada input. Silakan periksa kembali.
      </div>
    @endif
    @if (session('success'))
      <div class="px-4 py-2 mb-4 text-sm border rounded-lg border-emerald-200 bg-emerald-50 text-emerald-800">
        {{ session('success') }}
      </div>
    @endif

    <form method="POST" action="{{ route('user.me.update') }}" class="mt-6">
      @csrf
      @method('PUT')

      <div class="grid gap-6 md:grid-cols-2">
        {{-- Username --}}
        <div>
          <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
          <input type="text" id="username" name="username"
                 value="{{ old('username', $user->username) }}"
                 class="{{ $input }} @error('username') border-red-300 ring-1 ring-red-200 @enderror"
                 placeholder="nama_pengguna">
          @error('username')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Nama Lengkap --}}
        <div>
          <label for="nama_lengkap" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
          <input type="text" id="nama_lengkap" name="nama_lengkap"
                 value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                 class="{{ $input }} @error('nama_lengkap') border-red-300 ring-1 ring-red-200 @enderror"
                 placeholder="Nama lengkap">
          @error('nama_lengkap')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Email (full width di mobile tetap 1 kolom) --}}
        <div class="md:col-span-2">
          <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
          <input type="email" id="email" name="email"
                 value="{{ old('email', $user->email) }}"
                 class="{{ $input }} @error('email') border-red-300 ring-1 ring-red-200 @enderror"
                 placeholder="nama@domain.com">
          @error('email')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- No. Telp --}}
        <div class="md:col-span-2">
          <label for="no_tel" class="block text-sm font-medium text-slate-700">No. Telp</label>
          <input type="text" id="no_tel" name="no_tel" inputmode="tel"
                 value="{{ old('no_tel', $user->no_tel) }}"
                 class="{{ $input }} @error('no_tel') border-red-300 ring-1 ring-red-200 @enderror"
                 placeholder="08xxxxxxxxxx">
          @error('no_tel')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
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
          <x-heroicon-o-check class="w-5 h-5"/>
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
