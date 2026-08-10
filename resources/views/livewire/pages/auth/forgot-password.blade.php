<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
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
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('img/logo/logostt-lightmode.png') }}"
                                alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Lupa Password</h1>
                    <p class="auth-subtitle mb-5">Silakan masukan email Anda, kami akan mengirimkan tautan untuk mereset
                        password Anda.</p>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form wire:submit="sendPasswordResetLink">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input wire:model="email" id="email" name="email" type="email" class="form-control"
                                placeholder="Email" required autofocus autocomplete="email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="btn btn-primary btn-block shadow-lg mt-5">Send</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-5">
                        <p class='text-gray-600'>Remember your account? <a href="{{ route('login') }}"
                                class="font-bold fst-italic" wire:navigate>Login</a>.
                        </p>
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
