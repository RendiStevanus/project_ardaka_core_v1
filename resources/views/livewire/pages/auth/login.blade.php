<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] #[Title('Login')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: false);
    }
}; ?>

<div>
    <x-auth.card title="Selamat Datang" subtitle="Masuk untuk melanjutkan ke sistem.">

        {{-- Pesan dari middleware (mis. akun dinonaktifkan) --}}
        @error('email')
            <div class="alert alert-danger py-2 small">{{ $message }}</div>
        @enderror

        <form wire:submit="login">
            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input wire:model="form.email" id="email" type="email"
                        class="form-control @error('form.email') is-invalid @enderror" placeholder="nama@email.com"
                        required autofocus autocomplete="email">
                </div>
                @error('form.email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3" x-data="{ show: false }">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                    <input wire:model="form.password" id="password" type="password" :type="show ? 'text' : 'password'"
                        class="form-control @error('form.password') is-invalid @enderror" placeholder="Password"
                        required autocomplete="current-password">
                    <button type="button" class="input-group-text auth-eye" x-on:click="show = !show" tabindex="-1"
                        aria-label="Tampilkan atau sembunyikan password">
                        <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                    </button>
                </div>
                @error('form.password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Remember & lupa password --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check mb-0">
                    <input wire:model="form.remember" class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" wire:navigate class="small">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2" wire:loading.attr="disabled" wire:target="login">
                <span wire:loading.remove wire:target="login">Masuk</span>
                <span wire:loading wire:target="login">
                    <span class="spinner-border spinner-border-sm me-1"></span> Memproses...
                </span>
            </button>
        </form>

        <x-slot:footer>
            Belum punya akun? <a href="{{ route('register') }}" wire:navigate>Daftar sekarang</a>
        </x-slot:footer>
    </x-auth.card>
</div>
