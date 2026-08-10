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

        $user->assignRole(Role::findByName('calon-mahasiswa'));

        Auth::login($user);

        $this->redirect(route('login', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('img/logo/logostt-lightmode.png') }}"
                                alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Daftar Akun Baru</h1>
                    <p class="auth-subtitle">Buat akun baru untuk melanjutkan.</p>

                    <form wire:submit="register">
                        {{-- Nama --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input wire:model="name" id="name" type="text" class="form-control"
                                placeholder="Nama Lengkap" required autofocus autocomplete="name">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- email --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input wire:model="email" id="email" type="email" class="form-control"
                                placeholder="Email" required autocomplete="email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        {{-- Password --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input wire:model="password" id="password" type="password" class="form-control"
                                placeholder="Password" required autocomplete="new-password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input wire:model="password_confirmation" id="password_confirmation" type="password"
                                class="form-control" placeholder="Konfirmasi Password" required
                                autocomplete="new-password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <button class="btn btn-primary btn-block shadow-lg mt-5">DAFTAR</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-5">
                        <p class='text-gray-600'>{{ __('Sudah punya akun?') }} <a href="{{ route('login') }}"
                                class="font-bold fst-italic" wire:navigate>Login disini</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
</div>
