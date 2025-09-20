@extends('layouts.admin')
@section('title','Manajemen Pasien')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-6xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Manajemen Pasien
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

    {{-- TOOLBAR (opsional tambah pasien / cari) --}}
    <div class="flex flex-wrap items-center gap-2 mb-4">
      @if(Route::has('admin.patients.create'))
        <a href="{{ route('admin.patients.create') }}"
           class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600 text-white px-4 py-2 text-sm">
          <x-heroicon-o-user-plus class="w-5 h-5"/> Tambah Pasien
        </a>
      @endif

      @if(Route::has('admin.patients.search'))
        <form method="GET" action="{{ route('admin.patients.search') }}" class="ml-auto">
          <div class="relative">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari NIK / Nama"
                   class="w-64 rounded-full bg-white border border-slate-200 px-4 py-2.5 pr-10
                          focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                          placeholder:text-slate-400 text-sm" />
            <button type="submit"
                    class="absolute -translate-y-1/2 right-3 top-1/2 text-slate-400 hover:text-brand-700">
              <x-heroicon-o-magnifying-glass class="w-5 h-5"/>
            </button>
          </div>
        </form>
      @endif
    </div>

    {{-- TABEL --}}
    <div class="overflow-x-auto bg-white border rounded-2xl border-slate-200">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
          <tr>
            <th class="px-4 py-3 text-left font-medium">NIK</th>
            <th class="px-4 py-3 text-left font-medium">Nama</th>
            <th class="px-4 py-3 text-left font-medium">Pernah Berobat</th>
            <th class="px-4 py-3 text-left font-medium">Aksi</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-slate-200">
          @forelse ($patients as $patient)
            <tr class="bg-white hover:bg-slate-50">
              <td class="px-4 py-3 font-medium text-slate-800">{{ $patient->nik ?? '—' }}</td>
              <td class="px-4 py-3">{{ $patient->nama ?? $patient->nama_lengkap ?? '—' }}</td>
              <td class="px-4 py-3">
                @php $pb = $patient->pernah_berobat ?? null; @endphp
                @if($pb === 'Ya' || $pb === true)
                  <span class="inline-flex items-center rounded-full bg-emerald-600 text-white text-xs px-2.5 py-1">Ya</span>
                @else
                  <span class="inline-flex items-center rounded-full bg-slate-600 text-white text-xs px-2.5 py-1">Tidak</span>
                @endif
              </td>
              <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                  {{-- Edit --}}
                  <a href="{{ route('admin.patients.editAdmin', $patient->id_pasien) }}"
                     class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-100">
                    <x-heroicon-o-pencil-square class="w-4 h-4"/> Edit
                  </a>

                  {{-- Delete --}}
                  <form action="{{ route('admin.patients.destroyAdmin', $patient->id_pasien) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus?');" class="inline">
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
              <td colspan="4" class="px-4 py-8 text-center text-slate-500">
                Belum ada data pasien.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- PAGINATION (jika pakai paginate) --}}
    @if ($patients instanceof \Illuminate\Pagination\AbstractPaginator)
      <div class="mt-4">
        {{ $patients->links() }}
      </div>
    @endif

  </div>
</div>
@endsection
