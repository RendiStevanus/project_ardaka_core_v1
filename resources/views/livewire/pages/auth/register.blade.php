<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Spatie\Permission\Models\Role;

new #[Layout('layouts.guest')] #[Title('Register')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        $user->assignRole(Role::findByName('user'));

        Auth::login($user);

        $this->redirect(route('login', absolute: false), navigate: true);
    }
}; ?>

<div>
    <x-auth.card title="Daftar Akun Baru" subtitle="Buat akun untuk mulai menggunakan sistem.">
        <form wire:submit="register">
            {{-- Nama --}}
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input wire:model="name" id="name" type="text"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Nama lengkap" required
                        autofocus autocomplete="name">
                </div>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input wire:model="email" id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com" required
                        autocomplete="email">
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3" x-data="{ show: false }">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                    <input wire:model="password" id="password" type="password" :type="show ? 'text' : 'password'"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password" required
                        autocomplete="new-password">
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
                        placeholder="Ulangi password" required autocomplete="new-password">
                </div>
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2" wire:loading.attr="disabled"
                wire:target="register">
                <span wire:loading.remove wire:target="register">Daftar</span>
                <span wire:loading wire:target="register">
                    <span class="spinner-border spinner-border-sm me-1"></span> Memproses...
                </span>
            </button>
        </form>

        <x-slot:footer>
            Sudah punya akun? <a href="{{ route('login') }}" wire:navigate>Masuk di sini</a>
        </x-slot:footer>
    </x-auth.card>
</div>
