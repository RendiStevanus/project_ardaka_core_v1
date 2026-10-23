<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogAuthActivity
{
    public function handleLogin(Login $event): void
    {
        $this->record($event->user, 'login', 'Login ke sistem');
    }

    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            $this->record($event->user, 'logout', 'Logout dari sistem');
        }
    }

    public function handleFailed(Failed $event): void
    {
        activity('auth')
            ->event('login-failed')
            ->withProperties([
                'email'      => $event->credentials['email'] ?? null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ])
            ->log('Percobaan login gagal');
    }

    protected function record($user, string $event, string $description): void
    {
        activity('auth')
            ->causedBy($user)
            ->performedOn($user)
            ->event($event)
            ->withProperties([
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ])
            ->log($description);
    }
}
