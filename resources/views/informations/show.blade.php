@extends(auth()->check() ? 'layouts.user' : 'layouts.app')
@section('title', $info->judul ?? 'Detail Informasi')

@section('content')
<div class="px-4 pt-10 pb-12 min-h-[100svh] grid place-items-center bg-slate-50/30">
  <div class="relative w-full max-w-4xl bg-white rounded-[24px] border border-slate-200 shadow-sm p-6 md:p-10">
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow bg-brand-700 border-slate-200 md:text-lg whitespace-nowrap">
        Detail Informasi
      </div>
    </div>

    @php
      $coverUrl = $info->cover_url;
      $created  = optional($info->created_at)->translatedFormat('d F Y');
      $updated  = optional($info->updated_at)->translatedFormat('d F Y');
    @endphp

    <div class="flex flex-wrap items-center gap-3 text-xs tracking-wide uppercase text-slate-500">
      <span class="inline-flex items-center gap-1">
        <x-heroicon-o-calendar class="w-4 h-4" />
        {{ $updated ?? 'Tanggal tidak diketahui' }}
      </span>
      @if($info->jenis)
        <span class="inline-flex items-center gap-1 px-3 py-1 border rounded-full bg-brand-50 text-brand-700 border-brand-100">
          {{ $info->jenis }}
        </span>
      @endif
    </div>

    <h1 class="mt-4 text-2xl font-semibold leading-tight text-slate-900">
      {{ $info->judul }}
    </h1>

    @if($coverUrl)
      <div class="mt-6 overflow-hidden border rounded-3xl border-slate-200">
        <img src="{{ $coverUrl }}" alt="{{ $info->judul }}" class="object-cover w-full h-[360px]" loading="lazy" />
      </div>
    @endif

    <div class="mt-6 prose prose-slate max-w-none">
      {!! nl2br(e($info->isi)) !!}
    </div>

    <div class="flex flex-wrap gap-3 mt-10">
      <a href="{{ url()->previous() === url()->current() ? route('dashboard') : url()->previous() }}"
         class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-5 py-2.5 text-sm text-slate-700 hover:bg-slate-100">
        <x-heroicon-o-arrow-left class="w-5 h-5" />
        Kembali
      </a>
      <a href="{{ route('dashboard') }}"
         class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600 px-5 py-2.5 text-sm text-white">
        <x-heroicon-o-home-modern class="w-5 h-5" />
        Beranda
      </a>
    </div>
  </div>
</div>
@endsection
