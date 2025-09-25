@extends('layouts.admin')
@section('title', 'Daftar Informasi')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-6xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Daftar Informasi
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

    {{-- TOOLBAR --}}
    <div class="mb-4">
      <a href="{{ route('admin.informations.createAdmin') }}"
         class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600 text-white px-4 py-2 text-sm">
        <x-heroicon-o-plus class="w-5 h-5"/> Tambah Informasi
      </a>
    </div>

    {{-- TABEL --}}
    <div class="overflow-x-auto bg-white border rounded-2xl border-slate-200">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
          <tr>
            <th class="px-4 py-3 text-left font-medium">No</th>
            <th class="px-4 py-3 text-left font-medium">Jenis</th>
            <th class="px-4 py-3 text-left font-medium">Judul</th>
            <th class="px-4 py-3 text-left font-medium">Isi</th>
            <th class="px-4 py-3 text-left font-medium">Cover</th>
            <th class="px-4 py-3 text-left font-medium">Aksi</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-slate-200">
          @forelse($infos as $index => $info)
            @php
              $rowNum = method_exists($infos,'firstItem') ? $infos->firstItem() + $index : $loop->iteration;
              $jenis = \Illuminate\Support\Str::of($info->jenis ?? '')->lower();
              $chip = 'bg-slate-600 text-white';
              if ($jenis->contains('pengumuman')) $chip = 'bg-sky-600 text-white';
              elseif ($jenis->contains('artikel')) $chip = 'bg-emerald-600 text-white';
              elseif ($jenis->contains('kegiatan')) $chip = 'bg-amber-600 text-white';
            @endphp
            <tr class="bg-white hover:bg-slate-50">
              <td class="px-4 py-3">{{ $rowNum }}</td>
              <td class="px-4 py-3">
                @if($info->jenis)
                  <span class="inline-flex items-center rounded-full {{ $chip }} text-xs px-2.5 py-1">
                    {{ $info->jenis }}
                  </span>
                @else
                  —
                @endif
              </td>
              <td class="px-4 py-3 font-medium text-slate-800">
                {{ $info->judul ?? '—' }}
              </td>
              <td class="px-4 py-3 text-slate-600">
                {{ \Illuminate\Support\Str::limit($info->isi ?? '', 80) ?: '—' }}
              </td>
              <td class="px-4 py-3">
                @if($info->cover)
                  <img src="{{ asset('storage/covers/' . $info->cover) }}" alt="{{ $info->judul }}"
                       class="w-16 h-12 rounded object-cover border border-slate-200">
                @else
                  —
                @endif
              </td>
              <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                  <a href="{{ route('admin.informations.editAdmin', $info->id_informasi) }}"
                     class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-100">
                    <x-heroicon-o-pencil-square class="w-4 h-4"/> Edit
                  </a>
                  <form action="{{ route('admin.informations.destroyAdmin', $info->id_informasi) }}" method="POST"
                        class="inline-block"
                        onsubmit="return confirm('Yakin ingin menghapus informasi ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-red-600 hover:bg-red-500 text-white px-3 py-1.5 text-sm">
                      <x-heroicon-o-trash class="w-4 h-4"/> Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada informasi.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- PAGINATION --}}
    @if ($infos instanceof \Illuminate\Pagination\AbstractPaginator)
      <div class="mt-4">
        {{ $infos->links() }}
      </div>
    @endif

  </div>
</div>
@endsection
