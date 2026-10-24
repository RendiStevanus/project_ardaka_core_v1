<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] #[Title('Reset Password')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset($this->only('email', 'password', 'password_confirmation', 'token'), function ($user) {
            $user
                ->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])
                ->save();

            event(new PasswordReset($user));
        });

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    <x-auth.card title="Reset Password" subtitle="Buat password baru untuk akun Anda.">
        <form wire:submit="resetPassword">
            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input wire:model="email" id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror" required readonly
                        autocomplete="username">
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Password baru --}}
            <div class="mb-3" x-data="{ show: false }">
                <label for="password" class="form-label">Password Baru</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                    <input wire:model="password" id="password" type="password" :type="show ? 'text' : 'password'"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password baru"
                        required autofocus autocomplete="new-password">
                    <button type="button" class="input-group-text auth-eye" x-on:click="show = !show" tabindex="-1"
                        aria-label="Tampilkan atau sembunyikan password">
                        <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Konfirmasi password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                    <input wire:model="password_confirmation" id="password_confirmation" type="password"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Ulangi password baru" required autocomplete="new-password">
                </div>
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2" wire:loading.attr="disabled"
                wire:target="resetPassword">
                <span wire:loading.remove wire:target="resetPassword">Reset Password</span>
                <span wire:loading wire:target="resetPassword">
                    <span class="spinner-border spinner-border-sm me-1"></span> Memproses...
                </span>
            </button>
        </form>
    </x-auth.card>
</div>
