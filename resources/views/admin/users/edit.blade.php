@extends('layouts.admin')
@section('title','Edit Pengguna')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-3xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute left-1/2 -top-5 -translate-x-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Edit Pengguna
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

    <form action="{{ route('admin.users.updateAdmin', $user->id_pengguna) }}" method="POST" class="mt-6 space-y-6">
      @csrf
      @method('PUT')

      {{-- Nama Lengkap --}}
      <div>
        <label for="nama_lengkap" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" required
               value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
               class="{{ $input }} @error('nama_lengkap') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="Nama lengkap"
               @error('nama_lengkap') aria-invalid="true" @enderror>
        @error('nama_lengkap') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Nomor Telepon --}}
      <div>
        <label for="no_tel" class="block text-sm font-medium text-slate-700">Nomor Telepon</label>
        <input type="text" id="no_tel" name="no_tel" inputmode="tel" autocomplete="tel" required
               value="{{ old('no_tel', $user->no_tel) }}"
               class="{{ $input }} @error('no_tel') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="08xxxxxxxxxx"
               @error('no_tel') aria-invalid="true" @enderror>
        @error('no_tel') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Status --}}
      <div>
        <label for="status" class="block text-sm font-medium text-slate-700">Status</label>
        <div class="relative">
          <select id="status" name="status" required
                  class="{{ $select }} @error('status') border-red-300 ring-1 ring-red-200 @enderror"
                  @error('status') aria-invalid="true" @enderror>
            <option value="active"   {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
        @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Role --}}
      <div>
        <label for="role" class="block text-sm font-medium text-slate-700">Role</label>
        <div class="relative">
          <select id="role" name="role" required
                  class="{{ $select }} @error('role') border-red-300 ring-1 ring-red-200 @enderror"
                  @error('role') aria-invalid="true" @enderror>
            <option value="user"  {{ old('role', $user->role) === 'user'  ? 'selected' : '' }}>User</option>
            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
          </select>
        </div>
        @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- AKSI --}}
      <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('admin.users.indexAdmin') }}"
           class="inline-flex items-center gap-2 rounded-full border bg-white border-slate-300 text-slate-700
                  hover:bg-slate-100 px-5 py-2.5">
          <x-heroicon-o-arrow-left class="w-5 h-5" />
          Kembali
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600
                       text-white text-sm px-6 py-2.5">
          <x-heroicon-o-check class="w-5 h-5" />
          Update Pengguna
        </button>
      </div>
    </form>

  </div>
</div>
@endsection
