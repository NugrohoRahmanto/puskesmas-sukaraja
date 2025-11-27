@extends('layouts.admin')
@section('title','Manajemen Pasien')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-6xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow md:text-lg border-slate-200 bg-brand-700 whitespace-nowrap">
        Manajemen Pasien
      </div>
    </div>

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

    {{-- TOOLBAR --}}
    <div class="flex flex-col w-full gap-3 mb-4 md:flex-row md:items-center md:justify-between">
      <div class="flex flex-wrap items-center gap-2">
        <button id="open-add-patient-modal"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm text-white rounded-full bg-brand-700 hover:bg-brand-600">
          <x-heroicon-o-user-plus class="w-5 h-5"/> Tambah Pasien
        </button>
      </div>

      <div class="md:ml-auto w-full md:w-auto">
        <form method="GET" action="{{ url()->current() }}"
              class="flex items-center gap-2 text-sm text-slate-600 w-full">
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
              @foreach($perPageOptions as $option)
                <option value="{{ $option }}" {{ $perPageValue === (string) $option ? 'selected' : '' }}>
                  {{ $option === 'all' ? 'Semua' : $option }} data
                </option>
              @endforeach
            </select>
            <span class="absolute inset-y-0 flex items-center pointer-events-none right-3 text-slate-400">
              <x-heroicon-o-chevron-down class="w-4 h-4" />
            </span>
          </div>
        </form>
      </div>
    </div>

    {{-- Tabel desktop --}}
    <div class="hidden md:block overflow-x-auto bg-white border rounded-2xl border-slate-200">
      <table class="min-w-full text-sm">
        <thead class="border-b bg-slate-50 text-slate-700 border-slate-200">
          <tr>
            <th class="px-4 py-3 font-medium text-left">NIK</th>
            <th class="px-4 py-3 font-medium text-left">Nama</th>
            <th class="px-4 py-3 font-medium text-left">Gender</th>
            <th class="px-4 py-3 font-medium text-left">Pernah Berobat</th>
            <th class="px-4 py-3 font-medium text-left">Aksi</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-slate-200">
          @forelse ($patients as $patient)
            <tr class="bg-white hover:bg-slate-50">
              <td class="px-4 py-3 font-medium text-slate-800">{{ $patient->nik ?? '—' }}</td>
              <td class="px-4 py-3">{{ $patient->nama ?? $patient->nama_lengkap ?? '—' }}</td>
              <td class="px-4 py-3 text-slate-600">{{ $patient->gender ?? '—' }}</td>
              <td class="px-4 py-3">
                @if(($patient->pernah_berobat ?? null) === 'Ya' || ($patient->pernah_berobat ?? null) === true)
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
              <td colspan="5" class="px-4 py-8 text-center text-slate-500">
                Belum ada data pasien.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Kartu mobile --}}
    <div class="space-y-3 md:hidden">
      @forelse ($patients as $patient)
        <article class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
          <div class="flex items-center justify-between text-xs text-slate-500">
            <span>NIK</span>
            <span class="font-semibold text-slate-900">{{ $patient->nik ?? '—' }}</span>
          </div>
          <div class="mt-3 space-y-1 text-sm">
            <p class="font-semibold text-slate-900">{{ $patient->nama ?? $patient->nama_lengkap ?? '—' }}</p>
            <p class="text-slate-600">Gender: {{ $patient->gender ?? '—' }}</p>
            <p class="text-slate-600">Pernah berobat: <span class="font-medium">{{ ($patient->pernah_berobat ?? null) === 'Ya' ? 'Ya' : 'Tidak' }}</span></p>
          </div>
          <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('admin.patients.editAdmin', $patient->id_pasien) }}"
               class="flex-1 min-w-[140px] inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-100">
              <x-heroicon-o-pencil-square class="w-4 h-4"/> Edit
            </a>
            <form action="{{ route('admin.patients.destroyAdmin', $patient->id_pasien) }}" method="POST"
                  class="flex-1 min-w-[140px]"
                  onsubmit="return confirm('Yakin ingin menghapus?');">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-red-600 hover:bg-red-500 text-white px-3 py-1.5 text-sm">
                <x-heroicon-o-trash class="w-4 h-4"/> Hapus
              </button>
            </form>
          </div>
        </article>
      @empty
        <p class="text-center text-slate-500">Belum ada data pasien.</p>
      @endforelse
    </div>

    {{-- PAGINATION (jika pakai paginate) --}}
    @if ($patients instanceof \Illuminate\Pagination\AbstractPaginator)
      <div class="mt-4">
        {{ $patients->links() }}
      </div>
    @endif

  </div>
</div>

{{-- ADD PATIENT MODAL --}}
<div id="add-patient-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
  <div class="absolute inset-0 bg-slate-900/40" data-close-modal></div>
  <div class="relative z-10 w-full max-w-2xl p-6 mx-auto mt-16 bg-white shadow-2xl rounded-3xl">
    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
      <div>
        <p class="text-lg font-semibold text-slate-900">Tambah Pasien</p>
        <p class="text-sm text-slate-500">Form ini otomatis membuat antrian untuk hari ini.</p>
      </div>
      <button type="button" class="p-2 rounded-full text-slate-400 hover:bg-slate-100" data-close-modal>
        <x-heroicon-o-x-mark class="w-6 h-6" />
      </button>
    </div>

    <form action="{{ route('admin.patients.storeAdmin') }}" method="POST" class="mt-6 space-y-6">
      @csrf
      <input type="hidden" name="origin_form" value="adminAddPatient">

      <div>
        <label for="modal-nik" class="block text-sm font-medium text-slate-700">NIK</label>
         <input type="text" id="modal-nik" name="nik" required inputmode="numeric" maxlength="16" pattern="[0-9]{16}"
               value="{{ old('nik') }}"
           class="mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5 text-sm
             focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
             placeholder:text-slate-400 @error('nik') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="16 digit NIK">
        @error('nik') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="modal-nama" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
         <input type="text" id="modal-nama" name="nama" required
               value="{{ old('nama') }}"
           class="mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5 text-sm
             focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
             placeholder:text-slate-400 @error('nama') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="Nama pasien">
        @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="modal-gender" class="block text-sm font-medium text-slate-700">Jenis Kelamin</label>
        <div>
          <select id="modal-gender" name="gender" required
                  class="mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5 text-sm
                         focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400 @error('gender') border-red-300 ring-1 ring-red-200 @enderror">
            <option value="Laki-laki" {{ old('gender', 'Laki-laki') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
          </select>
        </div>
        @error('gender') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="modal-pernah" class="block text-sm font-medium text-slate-700">Sudah Pernah Berobat?</label>
        <div>
          <select id="modal-pernah" name="pernah_berobat" required
            class="mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5 text-sm
             focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400 @error('pernah_berobat') border-red-300 ring-1 ring-red-200 @enderror">
            <option value="" disabled {{ old('pernah_berobat') ? '' : 'selected' }}>Pilih</option>
            <option value="Ya" {{ old('pernah_berobat') === 'Ya' ? 'selected' : '' }}>Ya</option>
            <option value="Tidak" {{ old('pernah_berobat') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
          </select>
        </div>
        @error('pernah_berobat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:justify-center">
        <button type="button" class="rounded-full border border-slate-300 px-5 py-2.5 text-sm text-slate-700 hover:bg-slate-100"
                data-close-modal>
          Batal
        </button>
        <button type="submit"
                class="inline-flex w-full justify-center items-center gap-2 rounded-full bg-brand-700 px-6 py-2.5 text-sm font-semibold text-white hover:bg-brand-600">
            <x-heroicon-o-paper-airplane class="w-5 h-5" />
            Simpan dan Buat Antrian
        </button>

      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('add-patient-modal');
  if (!modal) return;

  const openers = [
    document.getElementById('open-add-patient-modal'),
  ].filter(Boolean);
  const closeables = modal.querySelectorAll('[data-close-modal]');
  const shouldOpenModal = @json(old('origin_form') === 'adminAddPatient');

  const toggleModal = (show) => {
    modal.classList.toggle('hidden', !show);
    document.body.classList.toggle('overflow-hidden', show);
  };

  openers.forEach(btn => btn.addEventListener('click', () => toggleModal(true)));
  closeables.forEach(btn => btn.addEventListener('click', () => toggleModal(false)));

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      toggleModal(false);
    }
  });

  if (shouldOpenModal) {
    toggleModal(true);
  }
});
</script>
@endsection
