@extends('layouts.app')

@section('title', 'Registrasi')
@section('fullbleed', true)
@section('hide_header', true)

@section('content')
    <div class="grid lg:grid-cols-2 min-h-screen">

        <section class="hidden lg:block relative bg-brand-500 text-white">

            <img src="{{ asset('images/patient-img.jpg') }}" alt="Ilustrasi Puskesmas"
                class="absolute inset-0 w-full h-full object-cover opacity-70">
        </section>


        <section class="bg-white flex items-center justify-center py-10">
            <div class="w-full max-w-md px-6">

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold">Registrasi</h2>
                    <p class="text-sm text-slate-600">Isi data berikut untuk membuat akun</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" novalidate class="space-y-4">
                    @csrf

                    {{-- Username --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-slate-800">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                            autocomplete="off" autocapitalize="none" spellcheck="false" autofocus
                            aria-invalid="{{ $errors->has('username') ? 'true' : 'false' }}"
                            aria-describedby="{{ $errors->has('username') ? 'username-error' : '' }}"
                            class="mt-1 block w-full rounded-xl border-line focus:border-brand-400 focus:ring-brand-300 text-sm" />
                        @error('username')
                            <p id="username-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-800">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            autocomplete="off" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                            aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                            class="mt-1 block w-full rounded-xl border-line focus:border-brand-400 focus:ring-brand-300 text-sm" />
                        @error('email')
                            <p id="email-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-slate-800">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            required autocomplete="off"
                            aria-invalid="{{ $errors->has('nama_lengkap') ? 'true' : 'false' }}"
                            aria-describedby="{{ $errors->has('nama_lengkap') ? 'nama-error' : '' }}"
                            class="mt-1 block w-full rounded-xl border-line focus:border-brand-400 focus:ring-brand-300 text-sm" />
                        @error('nama_lengkap')
                            <p id="nama-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor Telepon --}}
                    <div>
                        <label for="no_tel" class="block text-sm font-medium text-slate-800">Nomor Telepon</label>
                        <input type="text" name="no_tel" id="no_tel" value="{{ old('no_tel') }}" required
                            inputmode="tel" autocomplete="off"
                            aria-invalid="{{ $errors->has('no_tel') ? 'true' : 'false' }}"
                            aria-describedby="{{ $errors->has('no_tel') ? 'tel-error' : '' }}"
                            class="mt-1 block w-full rounded-xl border-line focus:border-brand-400 focus:ring-brand-300 text-sm" />
                        @error('no_tel')
                            <p id="tel-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-800">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required minlength="8" autocomplete="off"
                                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                aria-describedby="{{ $errors->has('password') ? 'password-error' : '' }}"
                                class="mt-1 block w-full rounded-xl border-line focus:border-brand-400 focus:ring-brand-300 text-sm pr-12" />
                            <button type="button"
                                class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex items-center justify-center p-2 rounded-lg text-slate-500 focus:outline-none focus:ring-0 focus-visible:outline-none focus-visible:ring-0"
                                aria-label="Tampilkan password" aria-controls="password" aria-pressed="false"
                                title="Tampilkan password" data-toggle-password="#password">
                                {{-- eye --}}
                                <svg data-eye xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                    <circle cx="12" cy="12" r="3" stroke-width="2" />
                                </svg>
                                {{-- eye-off --}}
                                <svg data-eye-off xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2"
                                        d="M3 3l18 18M10.58 10.58A3 3 0 0115 12M9.88 4.24A10.94 10.94 0 0122 12s-3.5 7-10 7a10.94 10.94 0 01-6.12-1.88M6.53 6.53A10.94 10.94 0 002 12s3.5 7 10 7c1.71 0 3.32-.32 4.78-.9" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p id="password-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-800">Konfirmasi
                            Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                autocomplete="off" minlength="8"
                                class="mt-1 block w-full rounded-xl border-line focus:border-brand-400 focus:ring-brand-300 text-sm pr-12" />
                            <button type="button"
                                class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex items-center justify-center p-2 rounded-lg text-slate-500 focus:outline-none focus:ring-0 focus-visible:outline-none focus-visible:ring-0"
                                aria-label="Tampilkan konfirmasi password" aria-controls="password_confirmation"
                                aria-pressed="false" title="Tampilkan konfirmasi password"
                                data-toggle-password="#password_confirmation">
                                {{-- eye --}}
                                <svg data-eye xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                    <circle cx="12" cy="12" r="3" stroke-width="2" />
                                </svg>
                                {{-- eye-off --}}
                                <svg data-eye-off xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2"
                                        d="M3 3l18 18M10.58 10.58A3 3 0 0115 12M9.88 4.24A10.94 10.94 0 0122 12s-3.5 7-10 7a10.94 10.94 0 01-6.12-1.88M6.53 6.53A10.94 10.94 0 002 12s3.5 7 10 7c1.71 0 3.32-.32 4.78-.9" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-xl bg-brand-700 hover:bg-brand-600 text-white text-sm px-4 py-2.5 disabled:opacity-60 disabled:cursor-not-allowed">
                        Register
                    </button>
                </form>

                <div class="mt-4 text-center text-sm">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-brand-700 hover:underline">Login Sekarang</a>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-toggle-password]').forEach(function(btn) {
                const selector = btn.getAttribute('data-toggle-password');
                const input = document.querySelector(selector);
                if (!input) return;

                const eye = btn.querySelector('[data-eye]');
                const eyeOff = btn.querySelector('[data-eye-off]');

                btn.addEventListener('click', function() {
                    const isHidden = input.type === 'password';
                    input.type = isHidden ? 'text' : 'password';

                    btn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
                    btn.setAttribute('title', isHidden ? 'Sembunyikan password' :
                        'Tampilkan password');
                    btn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' :
                        'Tampilkan password');

                    if (eye && eyeOff) {
                        eye.classList.toggle('hidden', isHidden);
                        eyeOff.classList.toggle('hidden', !isHidden);
                    }
                });
            });
        });
    </script>
@endpush
