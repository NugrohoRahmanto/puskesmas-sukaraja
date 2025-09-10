@extends('layouts.user')
@section('title', 'Profil Saya')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-4xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- Pill Header --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow bg-brand-700 border-slate-200 md:text-lg whitespace-nowrap">
        Profil Saya
      </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
      <div class="px-4 py-2 mb-4 text-sm border rounded-lg border-emerald-200 bg-emerald-50 text-emerald-800">
        {{ session('success') }}
      </div>
    @endif

    {{-- Konten --}}
    <div class="grid gap-8 md:grid-cols-3">
      {{-- Kiri: Avatar / ringkas --}}
      <div class="md:col-span-1">
        <div class="flex flex-col items-center p-5 text-center bg-white border rounded-2xl border-slate-200">
          <div class="grid w-20 h-20 rounded-full bg-brand-100 place-items-center ring-2 ring-brand-300">
            <x-heroicon-s-user class="w-10 h-10 text-brand-700"/>
          </div>
          <p class="mt-3 font-semibold text-slate-800">{{ $user->nama_lengkap ?? $user->username }}</p>
          <p class="text-xs text-slate-500">{{ $user->email }}</p>
        </div>
      </div>

      {{-- Kanan: Detail --}}
      <div class="md:col-span-2">
        <div class="p-5 bg-white border rounded-2xl border-slate-200">
          <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
              <dt class="text-xs tracking-wide uppercase text-slate-500">Username</dt>
              <dd class="mt-1 rounded-full bg-slate-50 border border-slate-200 px-4 py-2.5">{{ $user->username }}</dd>
            </div>
            <div>
              <dt class="text-xs tracking-wide uppercase text-slate-500">Nama Lengkap</dt>
              <dd class="mt-1 rounded-full bg-slate-50 border border-slate-200 px-4 py-2.5">{{ $user->nama_lengkap }}</dd>
            </div>
            <div>
              <dt class="text-xs tracking-wide uppercase text-slate-500">Email</dt>
              <dd class="mt-1 rounded-full bg-slate-50 border border-slate-200 px-4 py-2.5">{{ $user->email }}</dd>
            </div>
            <div>
              <dt class="text-xs tracking-wide uppercase text-slate-500">No. Telp</dt>
              <dd class="mt-1 rounded-full bg-slate-50 border border-slate-200 px-4 py-2.5">{{ $user->no_tel ?? '-' }}</dd>
            </div>

            {{-- Status full row --}}
            <div class="md:col-span-2">
              <dt class="text-xs tracking-wide text-center uppercase text-slate-500" >Status</dt>
              <dd class="mt-1 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 px-4 py-2.5 font-semibold text-center">
                {{ $user->status ?? '-' }}
              </dd>
            </div>
          </dl>

          <div class="flex flex-wrap justify-end gap-3 mt-6">
            <a href="{{ route('user.me.edit') }}"
               class="inline-flex items-center gap-2 rounded-full border border-slate-300 text-slate-700
                      hover:bg-brand-700 hover:text-white px-5 py-2.5">
              <x-heroicon-o-pencil-square class="w-5 h-5"/>
              Edit Profil
            </a>
            <a href="{{ route('user.me.password.edit') }}"
               class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600 text-white px-5 py-2.5">
              <x-heroicon-o-key class="w-5 h-5"/>
              Ganti Password
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
