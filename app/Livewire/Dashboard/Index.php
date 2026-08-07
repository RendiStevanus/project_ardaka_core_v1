<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
class Index extends Component
{
    #[Layout('layouts.app')]
    #[Title('Dashboard')] 
    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
