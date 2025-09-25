@extends('layouts.admin')
@section('title', 'Tambah Informasi')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-3xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Tambah Informasi
      </div>
    </div>

    @php
      $input    = 'mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5
                   focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                   placeholder:text-slate-400';
      $textarea = 'mt-2 w-full rounded-2xl bg-white border border-slate-200 px-4 py-3
                   focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                   placeholder:text-slate-400';
    @endphp

    {{-- ALERT ERROR --}}
    @if ($errors->any())
      <div class="px-4 py-2 mb-4 text-sm rounded-lg border border-red-200 bg-red-50 text-red-700">
        Terdapat kesalahan pada input. Silakan periksa kembali.
      </div>
    @endif

    <form action="{{ route('admin.informations.storeAdmin') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
      @csrf

      {{-- Jenis --}}
      <div>
        <label for="jenis" class="block text-sm font-medium text-slate-700">Jenis</label>
        <input type="text" name="jenis" id="jenis" required
               value="{{ old('jenis') }}"
               class="{{ $input }} @error('jenis') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="Mis. Pengumuman / Artikel / Kegiatan"
               @error('jenis') aria-invalid="true" @enderror>
        @error('jenis') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Judul --}}
      <div>
        <label for="judul" class="block text-sm font-medium text-slate-700">Judul</label>
        <input type="text" name="judul" id="judul" required
               value="{{ old('judul') }}"
               class="{{ $input }} @error('judul') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="Judul informasi"
               @error('judul') aria-invalid="true" @enderror>
        @error('judul') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Isi --}}
      <div>
        <label for="isi" class="block text-sm font-medium text-slate-700">Isi</label>
        <textarea name="isi" id="isi" rows="8" required
                  class="{{ $textarea }} @error('isi') border-red-300 ring-1 ring-red-200 @enderror"
                  placeholder="Tulis konten informasi di sini...">{{ old('isi') }}</textarea>
        @error('isi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Cover (besar + preview + zoom) --}}
      <div>
        <label class="block text-sm font-medium text-slate-700">Cover</label>

        <div class="mt-3 grid gap-4 md:grid-cols-2">
          {{-- PREVIEW BESAR --}}
          <div>
            <div class="relative w-full overflow-hidden rounded-xl border border-slate-200 bg-white">
              {{-- Placeholder awal --}}
              <div id="cover-empty" class="h-64 md:h-72 grid place-items-center text-slate-500 text-sm">
                Belum ada cover
              </div>

              {{-- Preview file baru (disembunyikan sampai ada pilihan) --}}
              <img id="cover-preview-img"
                   alt="Preview cover baru"
                   class="hidden w-full h-64 md:h-72 object-cover cursor-zoom-in"
                   onclick="openCoverModal(this.src)" />
            </div>
            <p class="mt-2 text-xs text-slate-500">Klik gambar untuk memperbesar.</p>
          </div>

          {{-- INPUT FILE + Keterangan --}}
          <div class="space-y-3">
            <div>
              <label for="cover" class="sr-only">Pilih file cover</label>
              <input type="file" name="cover" id="cover" accept="image/jpeg,image/png"
                     class="block w-full text-sm
                            file:mr-3 file:rounded-full file:border-0 file:bg-brand-700 file:px-4 file:py-2 file:text-white
                            file:hover:bg-brand-600 file:cursor-pointer
                            border border-slate-200 rounded-full bg-white px-3 py-2.5" />
              <p class="mt-1 text-xs text-slate-500">Format JPG/PNG, maks 2MB. Pratinjau muncul otomatis.</p>
              @error('cover') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="button" id="btn-reset-cover"
                    class="hidden inline-flex items-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-sm hover:bg-slate-100">
              <x-heroicon-o-arrow-path class="w-4 h-4" /> Batalkan Pilihan
            </button>
          </div>
        </div>
      </div>

      {{-- Aksi --}}
      <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('admin.informations.indexAdmin') }}"
           class="inline-flex items-center gap-2 rounded-full border bg-white border-slate-300 text-slate-700
                  hover:bg-slate-100 px-5 py-2.5">
          <x-heroicon-o-arrow-left class="w-5 h-5" />
          Batal
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-full bg-brand-700 hover:bg-brand-600
                       text-white text-sm px-6 py-2.5">
          <x-heroicon-o-check class="w-5 h-5" />
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>

{{-- Modal zoom cover --}}
<div id="cover-modal"
     class="fixed inset-0 z-[9999] hidden bg-black/70 p-4 md:p-8">
  <button type="button"
          class="absolute right-4 top-4 inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/90 hover:bg-white"
          onclick="closeCoverModal()">
    <x-heroicon-o-x-mark class="w-6 h-6 text-slate-800" />
  </button>
  <div class="h-full grid place-items-center">
    <img id="cover-modal-img"
         src=""
         alt="Preview cover"
         class="max-h-[80vh] w-auto rounded-xl shadow-2xl border border-white/20 object-contain" />
  </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
  function bindCoverPreview() {
    const input   = document.getElementById('cover');
    const prevImg = document.getElementById('cover-preview-img');   // <img> untuk preview
    const empty   = document.getElementById('cover-empty');         // placeholder "Belum ada cover"
    const btnReset= document.getElementById('btn-reset-cover');     // tombol batal (jika ada)

    if (!input || !prevImg) return;

    let blobUrl = null;

    input.addEventListener('change', function () {
      const file = this.files && this.files[0];
      if (!file) return;

      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = URL.createObjectURL(file);

      prevImg.src = blobUrl;
      prevImg.classList.remove('hidden');
      empty && empty.classList.add('hidden');
      btnReset && btnReset.classList.remove('hidden');
    });

    btnReset && btnReset.addEventListener('click', function () {
      if (blobUrl) URL.revokeObjectURL(blobUrl);
      blobUrl = null;
      input.value = '';
      prevImg.src = '';
      prevImg.classList.add('hidden');
      empty && empty.classList.remove('hidden');
      this.classList.add('hidden');
    });
  }

  // Pastikan DOM siap (dan juga kompatibel dengan Turbo/Livewire jika dipakai)
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bindCoverPreview);
  } else {
    bindCoverPreview();
  }
  document.addEventListener('turbo:load', bindCoverPreview);     // jika pakai Turbo
  window.Livewire && window.Livewire.hook && window.Livewire.hook('element.initialized', bindCoverPreview); // jika Livewire
})();
</script>
@endpush


