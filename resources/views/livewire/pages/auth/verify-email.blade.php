<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

new #[Layout('layouts.guest')] #[Title('Verifikasi Email')] class extends Component {
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/');
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
                    <h1 class="auth-title">Verifikasi Email Anda</h1>
                    <p class="auth-subtitle mb-0">Terima kasih sudah mendaftar.</p>
                    <p class="auth-subtitle mb-5">Silakan klik link verifikasi yang telah kami kirimkan ke email Anda.
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success">
                            Link verifikasi baru telah dikirim ke email Anda.
                        </div>
                    @endif

                    <button wire:click="sendVerification" type="button" class="btn btn-primary">
                        Kirim Ulang Email Verifikasi
                    </button>

                    <button wire:click="logout" type="button" class="btn btn-link">
                        Logout
                    </button>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>

</div>
