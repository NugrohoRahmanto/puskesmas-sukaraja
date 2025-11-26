@extends('layouts.admin')
@section('title','Tambah Admin')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-3xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base font-semibold text-center text-white border rounded-full shadow md:text-lg border-slate-200 bg-brand-700 whitespace-nowrap">
        Buat Admin Baru
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
        Terjadi kesalahan. Silakan periksa kembali input Anda.
      </div>
    @endif

    <form method="POST" action="{{ route('admin.users.storeAdmin') }}" class="mt-6 space-y-6">
      @csrf

      <div>
        <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" required
               class="mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5 text-sm
                      focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                      placeholder:text-slate-400 @error('username') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="username_admin"/>
        @error('username') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required
               class="mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5 text-sm
                      focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                      placeholder:text-slate-400 @error('email') border-red-300 ring-1 ring-red-200 @enderror"
               placeholder="admin@example.com"/>
        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
        <div class="relative">
          <input type="password" id="password" name="password" required
                 class="mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5 pr-12 text-sm
                        focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                        placeholder:text-slate-400 @error('password') border-red-300 ring-1 ring-red-200 @enderror"
                 placeholder="Minimal 8 karakter"/>
              <button type="button"
                class="absolute inline-flex items-center justify-center p-2 -translate-y-1/2 rounded-lg right-2 top-1/2 text-slate-500 focus:outline-none focus:ring-0 focus-visible:outline-none focus-visible:ring-0"
                  aria-label="Tampilkan password" aria-controls="password" aria-pressed="false" title="Tampilkan password"
                  data-toggle-password="#password">
            <svg data-eye xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-width="2" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
              <circle cx="12" cy="12" r="3" stroke-width="2" />
            </svg>
            <svg data-eye-off xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-width="2" d="M3 3l18 18M10.58 10.58A3 3 0 0115 12M9.88 4.24A10.94 10.94 0 0122 12s-3.5 7-10 7a10.94 10.94 0 01-6.12-1.88M6.53 6.53A10.94 10.94 0 002 12s3.5 7 10 7c1.71 0 3.32-.32 4.78-.9" />
            </svg>
          </button>
        </div>
        @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Password</label>
        <div class="relative">
          <input type="password" id="password_confirmation" name="password_confirmation" required
                 class="mt-2 w-full rounded-full bg-white border border-slate-200 px-4 py-2.5 pr-12 text-sm
                        focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-400
                        placeholder:text-slate-400"/>
              <button type="button"
                class="absolute inline-flex items-center justify-center p-2 -translate-y-1/2 rounded-lg right-2 top-1/2 text-slate-500 focus:outline-none focus:ring-0 focus-visible:outline-none focus-visible:ring-0"
                  aria-label="Tampilkan konfirmasi password" aria-controls="password_confirmation" aria-pressed="false"
                  title="Tampilkan konfirmasi password" data-toggle-password="#password_confirmation">
            <svg data-eye xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-width="2" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
              <circle cx="12" cy="12" r="3" stroke-width="2" />
            </svg>
            <svg data-eye-off xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-width="2" d="M3 3l18 18M10.58 10.58A3 3 0 0115 12M9.88 4.24A10.94 10.94 0 0122 12s-3.5 7-10 7a10.94 10.94 0 01-6.12-1.88M6.53 6.53A10.94 10.94 0 002 12s3.5 7 10 7c1.71 0 3.32-.32 4.78-.9" />
            </svg>
          </button>
        </div>
      </div>

      <div class="flex flex-col gap-3 pt-4 sm:flex-row sm:justify-end">
        <a href="{{ route('admin.users.indexAdmin') }}"
           class="rounded-full border border-slate-300 px-5 py-2.5 text-sm text-slate-700 hover:bg-slate-100 text-center">
          Batal
        </a>
        <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-full bg-brand-700 px-6 py-2.5 text-sm font-semibold text-white hover:bg-brand-600">
          <x-heroicon-o-user-plus class="w-5 h-5"/>
          Simpan Admin
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
          var selector = btn.getAttribute('data-toggle-password');
          var input = document.querySelector(selector);
          if (!input) return;

          var eye = btn.querySelector('[data-eye]');
          var eyeOff = btn.querySelector('[data-eye-off]');

          btn.addEventListener('click', function () {
            var isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';

            btn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
            btn.setAttribute('title', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
            btn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');

            if (eye && eyeOff) {
              eye.classList.toggle('hidden', isHidden);
              eyeOff.classList.toggle('hidden', !isHidden);
            }
          });
        });
      });
    </script>
  @endpush
