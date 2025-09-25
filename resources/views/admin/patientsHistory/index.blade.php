@extends('layouts.admin')
@section('title','Riwayat Pasien')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-6xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- Pill Header --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Riwayat Pasien
      </div>
    </div>

    {{-- Flash --}}
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

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white border rounded-2xl border-slate-200">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
          <tr>
            <th class="px-4 py-3 text-left font-medium">No</th>
            <th class="px-4 py-3 text-left font-medium">NIK</th>
            <th class="px-4 py-3 text-left font-medium">Nama</th>
            <th class="px-4 py-3 text-left font-medium">Pernah Berobat</th>
            <th class="px-4 py-3 text-left font-medium">No Antrian</th>
            <th class="px-4 py-3 text-left font-medium">Tanggal</th>
            <th class="px-4 py-3 text-left font-medium">Aksi</th>
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
              <td colspan="7" class="px-4 py-8 text-center text-slate-500">Belum ada data riwayat.</td>
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
