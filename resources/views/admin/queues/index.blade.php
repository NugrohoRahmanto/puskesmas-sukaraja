@extends('layouts.admin')
@section('title','Daftar Antrian')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-6xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow md:text-lg border-slate-200 bg-brand-700 whitespace-nowrap">
        Daftar Antrian
      </div>
    </div>

    @php
      $perPageValue = (string) ($perPage ?? 10);
      $perPageOptionsList = $perPageOptions ?? [10,25,50,'all'];
      $queryParams = request()->except('per_page','page');
    @endphp

    {{-- FLASH --}}
    @if(session('success'))
      <div class="px-4 py-2 mb-4 text-sm border rounded-lg border-emerald-200 bg-emerald-50 text-emerald-800">
        {{ session('success') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="px-4 py-2 mb-4 text-sm text-red-700 border border-red-200 rounded-lg bg-red-50">
        Terjadi kesalahan. Silakan coba lagi.
      </div>
    @endif

    <div class="flex flex-col w-full gap-3 mb-4 md:flex-row md:items-center md:justify-between">
      <div class="text-sm font-semibold text-slate-600">Antrian Hari Ini</div>

      <form method="GET" action="{{ url()->current() }}"
            class="flex items-center gap-2 text-sm text-slate-600">
        @foreach($queryParams as $name => $value)
          @if(is_array($value))
            @foreach($value as $item)
              <input type="hidden" name="{{ $name }}[]" value="{{ $item }}">
            @endforeach
          @else
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
          @endif
        @endforeach
        <span class="text-slate-500">Tampilkan</span>
        <div class="relative">
          <select name="per_page" onchange="this.form.submit()"
                  class="rounded-full border border-slate-200 bg-white px-3 py-1.5 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-brand-200">
            @foreach($perPageOptionsList as $option)
              @php $label = $option === 'all' ? 'Semua' : $option; @endphp
              <option value="{{ $option }}" {{ $perPageValue === (string) $option ? 'selected' : '' }}>
                {{ $label }} data
              </option>
            @endforeach
          </select>
          <span class="absolute inset-y-0 flex items-center pointer-events-none right-3 text-slate-400">
            <x-heroicon-o-chevron-down class="w-4 h-4" />
          </span>
        </div>
      </form>
    </div>

    {{-- TABEL --}}
    @if($queues->isEmpty())
      <div class="px-4 py-10 text-center bg-white border text-slate-600 border-slate-200 rounded-2xl">
        Tidak ada antrian saat ini.
      </div>
    @else
      <div class="hidden md:block overflow-x-auto bg-white border rounded-2xl border-slate-200">
        <table class="min-w-full text-sm">
          <thead class="border-b bg-slate-50 text-slate-700 border-slate-200">
            <tr>
              <th class="px-4 py-3 font-medium text-left">No Antrian</th>
              <th class="px-4 py-3 font-medium text-left">NIK</th>
              <th class="px-4 py-3 font-medium text-left">Nama</th>
              <th class="px-4 py-3 font-medium text-left">Pernah Berobat</th>
              <th class="px-4 py-3 font-medium text-left">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            @foreach($queues as $q)
              @php
                $pb = $q->patient->pernah_berobat ?? null;
                $nama = $q->patient->nama ?? $q->patient->nama_lengkap ?? '—';
                $nik  = $q->patient->nik ?? '—';
              @endphp
              <tr class="bg-white hover:bg-slate-50">
                <td class="px-4 py-3">
                  <div class="font-semibold text-slate-900 tabular-nums">{{ $q->display_no ?? $loop->iteration }}</div>
                  <p class="text-xs text-slate-400">DB: {{ $q->no_antrian ?? '—' }}</p>
                </td>
                <td class="px-4 py-3">{{ $nik }}</td>
                <td class="px-4 py-3">{{ $nama }}</td>
                <td class="px-4 py-3">
                  @if($pb === 'Ya' || $pb === true)
                    <span class="inline-flex items-center rounded-full bg-emerald-600 text-white text-xs px-2.5 py-1">Ya</span>
                  @else
                    <span class="inline-flex items-center rounded-full bg-slate-600 text-white text-xs px-2.5 py-1">Tidak</span>
                  @endif
                </td>
                <td class="px-4 py-3">
                  <div class="flex flex-wrap items-center gap-2">
                    {{-- Edit --}}
                    <a href="{{ route('admin.queues.editAdmin', $q->id_antrian ?? $q->id) }}"
                       class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-100">
                      <x-heroicon-o-pencil-square class="w-4 h-4"/> Edit
                    </a>

                    {{-- Hapus --}}
                    <form action="{{ route('admin.queues.destroyAdmin', $q->id_antrian ?? $q->id) }}" method="POST"
                          class="inline" onsubmit="return confirm('Hapus antrian ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center gap-2 rounded-full bg-red-600 hover:bg-red-500 text-white px-3 py-1.5 text-sm">
                        <x-heroicon-o-trash class="w-4 h-4"/> Hapus
                      </button>
                    </form>

                    {{-- Panggil --}}
                    <form action="{{ route('admin.queues.callAdmin', $q->id_antrian ?? $q->id) }}" method="POST"
                          class="inline" onsubmit="return confirm('Panggil pasien ini?')">
                      @csrf
                      <button type="submit"
                              class="inline-flex items-center gap-2 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 text-sm">
                        <x-heroicon-o-phone class="w-4 h-4"/> Panggil
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="space-y-3 md:hidden">
        @foreach($queues as $q)
          @php
            $pb = $q->patient->pernah_berobat ?? null;
            $nama = $q->patient->nama ?? $q->patient->nama_lengkap ?? '—';
            $nik  = $q->patient->nik ?? '—';
          @endphp
          <article class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center justify-between text-xs text-slate-500">
              <span>No. Antrian</span>
              <span class="font-semibold text-slate-900">{{ $q->display_no ?? $loop->iteration }}</span>
            </div>
            <div class="mt-3 space-y-1 text-sm">
              <p class="font-semibold text-slate-900">{{ $nama }}</p>
              <p class="text-slate-600">NIK: {{ $nik }}</p>
              <p class="text-slate-600">Pernah berobat: <span class="font-medium">{{ ($pb === 'Ya' || $pb === true) ? 'Ya' : 'Tidak' }}</span></p>
            </div>
            <div class="mt-4 grid gap-2">
              <a href="{{ route('admin.queues.editAdmin', $q->id_antrian ?? $q->id) }}"
                 class="w-full inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-100">
                <x-heroicon-o-pencil-square class="w-4 h-4"/> Edit
              </a>
              <form action="{{ route('admin.queues.destroyAdmin', $q->id_antrian ?? $q->id) }}" method="POST"
                    onsubmit="return confirm('Hapus antrian ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-red-600 hover:bg-red-500 text-white px-3 py-1.5 text-sm">
                  <x-heroicon-o-trash class="w-4 h-4"/> Hapus
                </button>
              </form>
              <form action="{{ route('admin.queues.callAdmin', $q->id_antrian ?? $q->id) }}" method="POST"
                    onsubmit="return confirm('Panggil pasien ini?')">
                @csrf
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 text-sm">
                  <x-heroicon-o-phone class="w-4 h-4"/> Panggil
                </button>
              </form>
            </div>
          </article>
        @endforeach
      </div>

      {{-- PAGINATION (jika menggunakan paginate di controller) --}}
      @if ($queues instanceof \Illuminate\Pagination\AbstractPaginator)
        <div class="mt-4">
          {{ $queues->links() }}
        </div>
      @endif
    @endif

  </div>
</div>
@endsection
