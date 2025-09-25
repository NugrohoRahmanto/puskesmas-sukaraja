@extends('layouts.admin')
@section('title','Manajemen Saran')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-6xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Manajemen Saran
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

    {{-- TOOLBAR (opsional search) --}}
    @if(Route::has('admin.suggestions.search'))
      <div class="mb-4">
        <form method="GET" action="{{ route('admin.suggestions.search') }}" class="ml-auto">
          <div class="relative">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pengguna / kata kunci"
                   class="w-72 rounded-full bg-white border border-slate-200 px-4 py-2.5 pr-10
                          focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                          placeholder:text-slate-400 text-sm" />
            <button type="submit"
                    class="absolute -translate-y-1/2 right-3 top-1/2 text-slate-400 hover:text-brand-700">
              <x-heroicon-o-magnifying-glass class="w-5 h-5"/>
            </button>
          </div>
        </form>
      </div>
    @endif

    {{-- TABEL --}}
    <div class="overflow-x-auto bg-white border rounded-2xl border-slate-200">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
          <tr>
            <th class="px-4 py-3 text-left font-medium">No</th>
            <th class="px-4 py-3 text-left font-medium">Pengguna</th>
            <th class="px-4 py-3 text-left font-medium">Keterangan</th>
            <th class="px-4 py-3 text-left font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
          @forelse($suggestions as $index => $s)
            @php
              $rowNum = method_exists($suggestions,'firstItem') ? $suggestions->firstItem() + $index : $loop->iteration;
            @endphp
            <tr class="bg-white hover:bg-slate-50 align-top">
              <td class="px-4 py-3">{{ $rowNum }}</td>
              <td class="px-4 py-3">
                {{ $s->user->nama_lengkap ?? '—' }}
                @if($s->user?->email)
                  <div class="text-xs text-slate-500">{{ $s->user->email }}</div>
                @endif
              </td>
              <td class="px-4 py-3">
                <div class="max-w-xl text-slate-700">
                  {{ \Illuminate\Support\Str::limit($s->keterangan ?? '—', 140) }}
                </div>
              </td>
              <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                  <a href="{{ route('admin.suggestions.editAdmin', $s->id_saran) }}"
                     class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-100">
                    <x-heroicon-o-pencil-square class="w-4 h-4"/> Edit
                  </a>
                  <form action="{{ route('admin.suggestions.destroyAdmin', $s->id_saran) }}" method="POST"
                        class="inline-block"
                        onsubmit="return confirm('Yakin ingin menghapus saran ini?');">
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
              <td colspan="4" class="px-4 py-8 text-center text-slate-500">Belum ada saran.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- PAGINATION --}}
    @if ($suggestions instanceof \Illuminate\Pagination\AbstractPaginator)
      <div class="mt-4">
        {{ $suggestions->links() }}
      </div>
    @endif

  </div>
</div>
@endsection
