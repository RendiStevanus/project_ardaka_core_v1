<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

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
    <x-auth.card title="Verifikasi Email"
        subtitle="Terima kasih sudah mendaftar. Klik tautan verifikasi yang telah kami kirim ke email Anda.">

        @if (session('status') === 'verification-link-sent')
            <div class="alert alert-success py-2 small">
                Tautan verifikasi baru telah dikirim ke email Anda.
            </div>
        @endif

        <button wire:click="sendVerification" type="button" class="btn btn-primary w-100 py-2" wire:loading.attr="disabled"
            wire:target="sendVerification">
            <span wire:loading.remove wire:target="sendVerification">Kirim Ulang Email Verifikasi</span>
            <span wire:loading wire:target="sendVerification">
                <span class="spinner-border spinner-border-sm me-1"></span> Mengirim...
            </span>
        </button>

        <x-slot:footer>
            <button wire:click="logout" type="button" class="btn btn-link p-0">Keluar</button>
        </x-slot:footer>
    </x-auth.card>
</div>
