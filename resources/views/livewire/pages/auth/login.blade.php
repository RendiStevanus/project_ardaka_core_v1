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
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('img/logo/logostt-lightmode.png') }}"
                                alt="Logo"></a>
                    </div>
                    <h3 class="auth-title">Selamat Datang!</h3>
                    <p class="auth-subtitle">Masukan <i>email</i> dan <i>password</i> Anda.</p>

                    <form wire:submit="login">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input wire:model="form.email" id="email" name="email" type="email"
                                class="form-control" placeholder="Email" required autofocus autocomplete="email">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('form.email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input wire:model="form.password" id="password" name="password" type="password"
                                class="form-control" required placeholder="Password" autocomplete="current-password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('form.password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input wire:model="form.remember" class="form-check-input me-2" type="checkbox"
                                id="remember" name="remember">
                            <label class="form-check-label text-gray-600" for="remember">
                                {{ __('Remember me') }}
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block shadow-lg mt-3">Masuk</button>
                    </form>

                    <div class="text-center mt-5 text-lg fs-5">
                        <p class="text-gray-600 mb-3">{{ __('Belum punya akun?') }} <a href="{{ route('register') }}"
                                class="font-bold fst-italic">
                                Daftar sekarang</a></p>

                        @if (Route::has('password.request'))
                            <p><a class="font-bold fst-italic" href="{{ route('password.request') }}" wire:navigate>Lupa
                                    password?</a></p>
                        @endif
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
