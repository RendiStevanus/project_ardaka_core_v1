<?php

namespace App\Livewire\UserManagement\User;

use App\Models\User;
use App\Traits\AlertTrait;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use SweetAlert2\Laravel\Traits\WithSweetAlert;

#[Layout('layouts.app')]
#[Title('Users Terhapus')]
class Trashed extends Component
{
    use WithPagination;
    use WithSweetAlert;
    use AlertTrait;

    protected $paginationTheme = 'bootstrap';

    public $paginate = 10;
    public $search = '';

    public function mount()
    {
        Gate::authorize('restore_user');
    }

    public function updated($property)
    {
        if (in_array($property, ['paginate', 'search'])) {
            $this->resetPage();
        }
    }

    public function back()
    {
        return $this->redirectRoute('users');
    }

    public function render()
    {
        return view('livewire.user-management.user.trashed', [
            'users' => User::onlyTrashed()
                ->with('roles:id,name')
                ->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                })
                ->orderByDesc('deleted_at')
                ->paginate($this->paginate),
        ]);
    }

    public function confirmRestore($id)
    {
        if (Gate::denies('restore_user')) {
            $this->error('Anda tidak memiliki akses untuk aksi ini.');
            return;
        }

        $user = User::onlyTrashed()->findOrFail($id);

        $this->dispatch(
            'confirmAction',
            id: $user->id,
            component: $this->getId(),
            method: 'restore',
            title: 'Pulihkan user?',
            html: '<b>' . e($user->name) . '</b><br><small>' . e($user->email) . '</small>',
            confirmText: 'Ya, pulihkan',
            icon: 'question',
        );
    }

    public function restore($id)
    {
        if (Gate::denies('restore_user')) {
            $this->error('Anda tidak memiliki akses untuk aksi ini.');
            return;
        }

        User::onlyTrashed()->findOrFail($id)->restore();

        $this->success('User berhasil dipulihkan.');
    }

    public function confirmForceDelete($id)
    {
        if (Gate::denies('forcedelete_user')) {
            $this->error('Anda tidak memiliki akses untuk aksi ini.');
            return;
        }

        $user = User::onlyTrashed()->findOrFail($id);

        $this->dispatch(
            'confirmAction',
            id: $user->id,
            component: $this->getId(),
            method: 'forceDestroy',
            title: 'Hapus permanen?',
            html: '<b>' . e($user->name) . '</b><br><small>' . e($user->email) . '</small>'
                . '<hr><span class="text-danger">Data tidak dapat dipulihkan setelah dihapus permanen.</span>',
            confirmText: 'Ya, hapus permanen',
            icon: 'warning',
        );
    }

    public function forceDestroy($id)
    {
        if (Gate::denies('forcedelete_user')) {
            $this->error('Anda tidak memiliki akses untuk aksi ini.');
            return;
        }

        User::onlyTrashed()->findOrFail($id)->forceDelete();

        $this->success('User berhasil dihapus permanen.');
    }
}
