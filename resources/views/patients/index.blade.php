@extends('layouts.user')
@section('title', 'Daftar Pasien')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-5xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- Pill Header --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow bg-brand-700 border-slate-200 md:text-lg whitespace-nowrap">
        Daftar Pasien
      </div>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
      <div class="px-4 py-2 mb-4 text-sm border rounded-lg border-emerald-200 bg-emerald-50 text-emerald-800">
        {{ session('success') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="px-4 py-2 mb-4 text-sm text-red-800 border border-red-200 rounded-lg bg-red-50">
        Terjadi kesalahan. Silakan cek input Anda.
      </div>
    @endif

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center gap-2 mb-4">
      <a href="{{ route('patients.createWithQueue') }}"
         class="inline-flex items-center gap-2 px-4 py-2 text-sm text-white rounded-full bg-brand-700 hover:bg-brand-600">
        <x-heroicon-o-plus class="w-5 h-5" />
        Tambah Pasien
      </a>

      {{-- (Opsional) Pencarian cepat --}}
      <form method="GET" action="{{ route('patients.search') }}" class="ml-auto">
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
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white border rounded-2xl border-slate-200">
      <table class="min-w-full text-sm">
        <thead class="border-b bg-slate-50 border-slate-200 text-slate-700">
          <tr>
            <th class="px-4 py-3 font-medium text-left">No Antrian</th>
            <th class="px-4 py-3 font-medium text-left">NIK</th>
            <th class="px-4 py-3 font-medium text-left">Nama</th>
            <th class="px-4 py-3 font-medium text-left">Pernah Berobat</th>
            <th class="px-4 py-3 font-medium text-left">Dibuat</th>
            <th class="px-4 py-3 font-medium text-left">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
          @forelse ($patients as $i => $p)
            <tr class="bg-white">
              <td class="px-4 py-3">{{ $p->id_antrian }}</td>
              <td class="px-4 py-3 font-medium text-slate-800">{{ $p->nik }}</td>
              <td class="px-4 py-3">{{ $p->nama }}</td>
              <td class="px-4 py-3">
                @if($p->pernah_berobat === 'Ya')
                  <span class="inline-flex items-center rounded-full bg-emerald-600 text-white text-xs px-2.5 py-1">
                    Ya
                  </span>
                @else
                  <span class="inline-flex items-center rounded-full bg-slate-600 text-white text-xs px-2.5 py-1">
                    Tidak
                  </span>
                @endif
              </td>
              <td class="px-4 py-3 text-slate-500">
                {{ optional($p->created_at)->translatedFormat('d M Y, H:i') }}
              </td>
              <td class="flex items-center gap-2 px-4 py-3">
                {{-- Tombol Edit --}}
                <a href="{{ route('patients.edit', $p->id_pasien) }}"
                class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-100">
                    <x-heroicon-o-pencil-square class="w-4 h-4"/>
                    Edit
                </a>

                {{-- Tombol Hapus --}}
                <form action="{{ route('patients.destroy', $p->id_pasien) }}" method="POST" onsubmit="return confirm('Yakin hapus pasien ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-red-600 hover:bg-red-500 text-white px-3 py-1.5 text-sm">
                        <x-heroicon-o-trash class="w-4 h-4"/>
                        Hapus
                    </button>
                </form>

                {{-- Tombol Cetak --}}
                @if($p->id_antrian)
                    <button type="button"
                            data-queue-id="{{ $p->id_antrian }}"
                            data-no="{{ $p->no_antrian }}"
                            data-nama="{{ $p->nama }}"
                            onclick="cetakAntrian(this)"
                            class="inline-flex items-center gap-2 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 text-sm">
                        <x-heroicon-o-printer class="w-4 h-4"/>
                        Cetak
                    </button>
                @endif
            </td>



            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                Belum ada data pasien.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination (jika pakai paginate di controller) --}}
    @if ($patients instanceof \Illuminate\Pagination\AbstractPaginator)
      <div class="mt-4">
        {{ $patients->links() }}
      </div>
    @endif

  </div>
</div>

<div id="print-card" class="w-[420px] rounded-2xl border border-slate-200 bg-white p-6 shadow-xl hidden">
  <div class="text-center">
    <p class="text-xs tracking-wide uppercase text-slate-500">Puskesmas Sukaraja</p>
    <p class="mt-1 text-lg font-semibold text-slate-900">Nomor Antrian</p>
    <div class="mt-3 text-5xl font-extrabold tabular-nums text-brand-700" id="pc-no">—</div>
    <div class="mt-2 text-sm text-slate-500">Atas nama</div>
    <div class="mt-1 text-xl font-semibold text-slate-800" id="pc-nama">—</div>
    <div class="mt-4 text-[11px] text-slate-400" id="pc-date">{{ now()->translatedFormat('d F Y') }}</div>
  </div>
</div>

{{-- html2canvas CDN --}}
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js" defer></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  window.cetakAntrian = async (btn) => {
    const no   = btn.getAttribute('data-no')   || '-';
    const nama = btn.getAttribute('data-nama') || '-';

    // Isi data ke template
    const card   = document.getElementById('print-card');
    const elNo   = document.getElementById('pc-no');
    const elNama = document.getElementById('pc-nama');

    elNo.textContent = no;
    elNama.textContent = nama;

    // Tampilkan sementara agar bisa dirender
    card.classList.remove('hidden');

    // Render ke canvas
    const canvas = await html2canvas(card, {
      backgroundColor: null, // tetap putih dari card
      scale: 2,              // kualitas lebih tajam
      useCORS: true,
    });

    // Sembunyikan kembali
    card.classList.add('hidden');

    // Buat file PNG & download otomatis
    const dataURL = canvas.toDataURL('image/png');
    const a = document.createElement('a');
    const safeNama = (nama || '-').toString().replace(/[^\w\-]+/g, '_');
    a.href = dataURL;
    a.download = `antrian-${no}-${safeNama}.png`;
    document.body.appendChild(a);
    a.click();
    a.remove();
  };
});
</script>

@endsection
