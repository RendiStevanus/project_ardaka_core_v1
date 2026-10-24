<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] #[Title('Lupa Password')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <x-auth.card title="Lupa Password"
        subtitle="Masukkan email Anda, kami akan mengirimkan tautan untuk mereset password.">

        @if (session('status'))
            <div class="alert alert-success py-2 small">{{ session('status') }}</div>
        @endif

        <form wire:submit="sendPasswordResetLink">
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input wire:model="email" id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com" required
                        autofocus autocomplete="email">
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2" wire:loading.attr="disabled"
                wire:target="sendPasswordResetLink">
                <span wire:loading.remove wire:target="sendPasswordResetLink">Kirim Tautan Reset</span>
                <span wire:loading wire:target="sendPasswordResetLink">
                    <span class="spinner-border spinner-border-sm me-1"></span> Memproses...
                </span>
            </button>
        </form>

        <x-slot:footer>
            Ingat akun Anda? <a href="{{ route('login') }}" wire:navigate>Masuk</a>
        </x-slot:footer>
    </x-auth.card>
</div>
