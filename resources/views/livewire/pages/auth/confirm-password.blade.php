<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] #[Title('Konfirmasi Password')] class extends Component {
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (
            !Auth::guard('web')->validate([
                'email' => Auth::user()->email,
                'password' => $this->password,
            ])
        ) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <x-auth.card title="Konfirmasi Password"
        subtitle="Ini area yang diamankan. Masukkan password Anda untuk melanjutkan.">

        <form wire:submit="confirmPassword">
            <div class="mb-4" x-data="{ show: false }">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                    <input wire:model="password" id="password" type="password" :type="show ? 'text' : 'password'"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password" required
                        autofocus autocomplete="current-password">
                    <button type="button" class="input-group-text auth-eye" x-on:click="show = !show" tabindex="-1"
                        aria-label="Tampilkan atau sembunyikan password">
                        <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2" wire:loading.attr="disabled"
                wire:target="confirmPassword">
                <span wire:loading.remove wire:target="confirmPassword">Konfirmasi</span>
                <span wire:loading wire:target="confirmPassword">
                    <span class="spinner-border spinner-border-sm me-1"></span> Memproses...
                </span>
            </button>
        </form>
    </x-auth.card>
</div>
