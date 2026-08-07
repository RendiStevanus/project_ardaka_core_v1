<?php

namespace App\Traits;

use SweetAlert2\Laravel\Traits\WithSweetAlert;
trait AlertTrait
{
    use WithSweetAlert;
    
    protected function success(string $text): void
    {
        $this->swalToastSuccess([
            'text' => $text,
            'showConfirmButton' => false,
            'timer' => 2000,
            'timerProgressBar' => true,
        ]);
    }

    protected function error(string $text): void
    {
        $this->swalToastError([
            'text' => $text,
            'showConfirmButton' => false,
            'timer' => 2000,
            'timerProgressBar' => true,
        ]);
    }

    protected function warning(string $text): void
    {
        $this->swalToastWarning([
            'text' => $text,
            'showConfirmButton' => false,
            'timer' => 2000,
            'timerProgressBar' => true,
        ]);
    }
}