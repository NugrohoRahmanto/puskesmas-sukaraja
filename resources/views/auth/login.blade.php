@extends('layouts.app')

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

@section('title', 'Login')
@section('fullbleed', true)
@section('content')

    <div>
        <div class="grid lg:grid-cols-2 min-h-screen">

            <section class="hidden lg:block relative bg-brand-500 text-white">
                <img src="{{ asset('images/patient-img.jpg') }}" alt="Ilustrasi Puskesmas"
                    class="absolute inset-0 w-full h-full object-cover opacity-70">
            </section>


            <section class="bg-white flex items-center justify-center py-10">
                <div class="w-full max-w-md px-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold">Login</h2>
                        <p class="text-sm text-slate-600">Gunakan akun terdaftar untuk melanjutkan</p>
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

                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="username" class="block text-sm font-medium text-slate-800">Username</label>
                            <input type="text" name="username" id="username" value="{{ old('username') }}" required
                                autofocus autocomplete="off"
                                class="mt-1 block w-full rounded-xl border-line focus:border-brand-400 focus:ring-brand-300 text-sm" />
                            @error('username')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-800">Password</label>

                            <div class="relative">
                                <input type="password" name="password" id="password" required autocomplete="off"
                                    class="mt-1 block w-full rounded-xl border-line focus:border-brand-400 focus:ring-brand-300 text-sm pr-12" />

                                <button type="button"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex items-center justify-center p-2 rounded-lg text-slate-500"
                                    aria-label="Tampilkan password" aria-controls="password" aria-pressed="false"
                                    title="Tampilkan password" data-toggle-password="#password">

                                    {{-- icon "eye" --}}
                                    <svg data-eye xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor">
                                        <path stroke-width="2" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                        <circle cx="12" cy="12" r="3" stroke-width="2" />
                                    </svg>

                                    {{-- icon "eye-off" --}}
                                    <svg data-eye-off xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-width="2"
                                            d="M3 3l18 18M10.58 10.58A3 3 0 0115 12M9.88 4.24A10.94 10.94 0 0122 12s-3.5 7-10 7a10.94 10.94 0 01-6.12-1.88M6.53 6.53A10.94 10.94 0 002 12s3.5 7 10 7c1.71 0 3.32-.32 4.78-.9" />
                                    </svg>
                                </button>
                            </div>

                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" name="remember"
                                    class="rounded border-line text-brand-700 focus:ring-brand-300">
                                <span>Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-brand-700 hover:underline">Lupa
                                    Password?</a>
                            @endif
                        </div>

                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-xl bg-brand-700 hover:bg-brand-600 text-white text-sm px-4 py-2.5">
                            Login
                        </button>
                    </form>

                    <div class="mt-4 text-center text-sm">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-brand-700 hover:underline">Daftar Sekarang</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
