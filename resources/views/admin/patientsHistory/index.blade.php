@extends('layouts.admin')
@section('title','Riwayat Pasien')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-6xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- Pill Header --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow md:text-lg border-slate-200 bg-brand-700 whitespace-nowrap">
        Riwayat Pasien
      </div>
    </div>

    @php
      $filterStart = $filters['start_date'] ?? null;
      $filterEnd   = $filters['end_date'] ?? null;
      $hasFilter   = $filterStart || $filterEnd;
      $inputDate   = 'mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm
                      focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400';
      $perPageValue = (string) ($perPage ?? 10);
      $perPageOptionsList = $perPageOptions ?? [10,25,50,'all'];
      $queryParams = request()->except('per_page','page');
    @endphp

    {{-- Flash --}}
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

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('admin.patientsHistory.indexAdmin') }}"
        class="px-6 py-4 mb-6 border rounded-2xl border-slate-200 bg-white/80">

        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <label for="start_date" class="block text-sm font-medium text-slate-700">Mulai Tanggal</label>
                <input type="date" id="start_date" name="start_date"
                    value="{{ $filterStart }}" class="{{ $inputDate }}">
                @error('start_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-slate-700">Sampai Tanggal</label>
                <input type="date" id="end_date" name="end_date"
                    value="{{ $filterEnd }}" class="{{ $inputDate }}">
                @error('end_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Tombol diapungkan ke kolom ke-3 -->
            <div class="flex items-center justify-start gap-3 md:justify-end md:pt-6">
                <a href="{{ route('admin.patientsHistory.indexAdmin') }}"
                class="px-5 py-2 text-sm border rounded-full border-slate-300 text-slate-600 hover:bg-slate-100">
                    Reset
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white rounded-full bg-brand-700 hover:bg-brand-600">
                    <x-heroicon-o-adjustments-horizontal class="w-4 h-4"/> Terapkan
                </button>
            </div>

        </div>

    </form>

    <div class="flex flex-col w-full gap-3 mb-4 md:flex-row md:items-center md:justify-between">
      <div class="text-sm font-semibold text-slate-600">
        {{ $hasFilter ? 'Hasil Riwayat Terfilter' : 'Semua Riwayat Pasien' }}
      </div>

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
          <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
            <x-heroicon-o-chevron-down class="w-4 h-4" />
          </span>
        </div>
      </form>
    </div>


    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white border rounded-2xl border-slate-200">
      <table class="min-w-full text-sm">
        <thead class="border-b bg-slate-50 text-slate-700 border-slate-200">
          <tr>
            <th class="px-4 py-3 font-medium text-left">No</th>
            <th class="px-4 py-3 font-medium text-left">NIK</th>
            <th class="px-4 py-3 font-medium text-left">Nama</th>
            <th class="px-4 py-3 font-medium text-left">Gender</th>
            <th class="px-4 py-3 font-medium text-left">Pernah Berobat</th>
            <th class="px-4 py-3 font-medium text-left">No Antrian</th>
            <th class="px-4 py-3 font-medium text-left">Tanggal</th>
            <th class="px-4 py-3 font-medium text-left">Aksi</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-slate-200">
          @forelse ($histories as $history)
            @php
              $isYes = ($history->pernah_berobat === 'Ya' || $history->pernah_berobat === true);
              $tgl = $history->tanggal ? \Carbon\Carbon::parse($history->tanggal)->translatedFormat('d M Y') : '-';
              $rowNum = method_exists($histories,'firstItem') ? $histories->firstItem() + $loop->index : $loop->iteration;
            @endphp
            <tr class="bg-white hover:bg-slate-50">
              <td class="px-4 py-3">{{ $rowNum }}</td>
              <td class="px-4 py-3 font-medium text-slate-800">{{ $history->nik ?? '—' }}</td>
              <td class="px-4 py-3">{{ $history->nama ?? '—' }}</td>
              <td class="px-4 py-3">
                @if($history->gender)
                  <span class="inline-flex items-center px-3 py-1 text-xs font-semibold border rounded-full border-slate-200 bg-slate-50 text-slate-700">
                    {{ $history->gender }}
                  </span>
                @else
                  <span class="text-slate-400">—</span>
                @endif
              </td>
              <td class="px-4 py-3">
                @if($isYes)
                  <span class="inline-flex items-center rounded-full bg-emerald-600 text-white text-xs px-2.5 py-1">Ya</span>
                @else
                  <span class="inline-flex items-center rounded-full bg-slate-600 text-white text-xs px-2.5 py-1">Tidak</span>
                @endif
              </td>
              <td class="px-4 py-3">{{ $history->no_antrian ?? '—' }}</td>
              <td class="px-4 py-3 text-slate-500">{{ $tgl }}</td>
              <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                  <a href="{{ route('admin.patientsHistory.editAdmin', $history->id_history) }}"
                     class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-100">
                    <x-heroicon-o-pencil-square class="w-4 h-4"/>
                    Edit
                  </a>

                  <form action="{{ route('admin.patientsHistory.destroyAdmin', $history->id_history) }}"
                        method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-red-600 hover:bg-red-500 text-white px-3 py-1.5 text-sm">
                      <x-heroicon-o-trash class="w-4 h-4"/>
                      Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="px-4 py-8 text-center text-slate-500">
                {{ $hasFilter ? 'Tidak ada data pada rentang tanggal tersebut.' : 'Belum ada data riwayat.' }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if ($histories instanceof \Illuminate\Pagination\AbstractPaginator)
      <div class="mt-4">
        {{ $histories->links() }}
      </div>
    @endif

  </div>
</div>
@endsection
