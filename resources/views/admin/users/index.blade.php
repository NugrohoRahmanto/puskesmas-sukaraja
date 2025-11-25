@extends('layouts.admin')
@section('title','Manajemen Pengguna')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-6xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Manajemen Pengguna
      </div>
    </div>

    @php
      $perPageValue = (string) ($perPage ?? 10);
      $perPageOptionsList = $perPageOptions ?? [10,25,50,'all'];
      $queryParams = request()->except('per_page','page');
    @endphp

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

    {{-- TOOLBAR (opsional tambah & cari) --}}
    <div class="flex flex-col w-full gap-3 mb-4 md:flex-row md:items-center md:justify-between">
      <div class="flex flex-col gap-3 md:flex-row md:items-center md:flex-wrap md:gap-3">
        @if (Route::has('admin.users.create'))
          <a href="{{ route('admin.users.create') }}"
             class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600 text-white px-4 py-2 text-sm">
            <x-heroicon-o-user-plus class="w-5 h-5"/> Tambah Pengguna
          </a>
        @endif

        @if (Route::has('admin.users.search'))
          <form method="GET" action="{{ route('admin.users.search') }}" class="md:w-72">
            <div class="relative">
              <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama/username/email"
                     class="w-full rounded-full bg-white border border-slate-200 px-4 py-2.5 pr-10
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

      <div class="md:ml-auto">
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
    </div>

    {{-- TABEL --}}
    <div class="overflow-x-auto bg-white border rounded-2xl border-slate-200">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
          <tr>
            <th class="px-4 py-3 text-left font-medium">Nama Lengkap</th>
            <th class="px-4 py-3 text-left font-medium">Username</th>
            <th class="px-4 py-3 text-left font-medium">Email</th>
            <th class="px-4 py-3 text-left font-medium">No Telepon</th>
            <th class="px-4 py-3 text-left font-medium">Status</th>
            <th class="px-4 py-3 text-left font-medium">Role</th>
            <th class="px-4 py-3 text-left font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
          @forelse ($users as $u)
            <tr class="bg-white hover:bg-slate-50">
              <td class="px-4 py-3 font-medium text-slate-900">{{ $u->nama_lengkap ?? '—' }}</td>
              <td class="px-4 py-3">{{ $u->username ?? '—' }}</td>
              <td class="px-4 py-3">{{ $u->email ?? '—' }}</td>
              <td class="px-4 py-3">{{ $u->no_tel ?? '—' }}</td>
              <td class="px-4 py-3">
                @php $active = ($u->status ?? '') === 'active'; @endphp
                <span class="inline-flex items-center rounded-full {{ $active ? 'bg-emerald-600' : 'bg-slate-600' }} text-white text-xs px-2.5 py-1">
                  {{ ucfirst($u->status ?? 'unknown') }}
                </span>
              </td>
              <td class="px-4 py-3 capitalize">{{ $u->role ?? '—' }}</td>
              <td class="px-4 py-3">
                <div class="flex flex-wrap items-center gap-2">
                  {{-- Edit --}}
                  <a href="{{ route('admin.users.editAdmin', $u->id_pengguna) }}"
                     class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-100">
                    <x-heroicon-o-pencil-square class="w-4 h-4"/> Edit
                  </a>

                  {{-- Hapus --}}
                  <form action="{{ route('admin.users.destroyAdmin', $u->id_pengguna) }}" method="POST"
                        class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                    @csrf @method('DELETE')
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
              <td colspan="7" class="px-4 py-8 text-center text-slate-500">Belum ada pengguna.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- PAGINATION (jika pakai paginate) --}}
    @if ($users instanceof \Illuminate\Pagination\AbstractPaginator)
      <div class="mt-4">
        {{ $users->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
