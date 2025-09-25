@extends('layouts.admin')
@section('title','Daftar Antrian')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-6xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Daftar Antrian
      </div>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
      <div class="px-4 py-2 mb-4 text-sm rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800">
        {{ session('success') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="px-4 py-2 mb-4 text-sm rounded-lg border border-red-200 bg-red-50 text-red-700">
        Terjadi kesalahan. Silakan coba lagi.
      </div>
    @endif

    {{-- TABEL --}}
    @if($queues->isEmpty())
      <div class="px-4 py-10 text-center text-slate-600 bg-white border border-slate-200 rounded-2xl">
        Tidak ada antrian saat ini.
      </div>
    @else
      <div class="overflow-x-auto bg-white border rounded-2xl border-slate-200">
        <table class="min-w-full text-sm">
          <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
            <tr>
              <th class="px-4 py-3 text-left font-medium">No Antrian</th>
              <th class="px-4 py-3 text-left font-medium">NIK</th>
              <th class="px-4 py-3 text-left font-medium">Nama</th>
              <th class="px-4 py-3 text-left font-medium">Pernah Berobat</th>
              <th class="px-4 py-3 text-left font-medium">Aksi</th>
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
                <td class="px-4 py-3 font-semibold tabular-nums">{{ $q->no_antrian }}</td>
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
