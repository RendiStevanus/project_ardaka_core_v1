<?php

namespace App\Livewire\UserManagement\User;

use App\Models\User;
use App\Traits\AlertTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use SweetAlert2\Laravel\Traits\WithSweetAlert;

#[Layout('layouts.app')]
#[Title('Users')]
class Index extends Component
{
    use WithPagination;
    use WithSweetAlert;
    use AlertTrait;

    #[Locked]
    public $user_id = null;

    protected $paginationTheme = 'bootstrap';

    public $paginate = '10';

    public $search = '';

    public $name = '';

    public $email = '';

    public $role = '';

    /* ---------- Helper ---------- */

    private function assignableRoles()
    {
        return Role::query()
            ->when(
                ! Auth::user()->hasRole('super-admin'),
                fn($query) => $query->where('name', '!=', 'super-admin')
            )
            ->orderBy('name');
    }

    private function denied(string $ability): bool
    {
        if (Gate::denies($ability)) {
            $this->error('Anda tidak memiliki akses untuk aksi ini.');

            return true;
        }

        return false;
    }

    private function canManage(User $target): bool
    {
        if ($target->hasRole('super-admin') && ! Auth::user()->hasRole('super-admin')) {
            $this->error('Hanya Super Admin yang dapat mengelola akun Super Admin.');

            return false;
        }

        return true;
    }

    private function isLastActiveSuperAdmin(User $user): bool
    {
        return $user->is_active
            && $user->hasRole('super-admin')
            && User::role('super-admin')->where('is_active', true)->count() <= 1;
    }

    public function resetInputFields()
    {
        $this->reset(['name', 'email', 'role', 'user_id']);
        $this->resetValidation();
    }

    /* ---------- Tambah & edit ---------- */

    public function create()
    {
        if ($this->denied('create_user')) {
            return;
        }

        $this->resetInputFields();
        $this->dispatch('openModal', id: 'userModal');
    }

    public function edit($id)
    {
        if ($this->denied('update_user')) {
            return;
        }

        $user = User::findOrFail($id);

        if (! $this->canManage($user)) {
            return;
        }

        $this->resetInputFields();

        $this->user_id = $user->id;
        $this->name    = $user->name;
        $this->email   = $user->email;
        $this->role    = $user->getRoleNames()->first() ?? '';

        $this->dispatch('openModal', id: 'userModal');
    }

    public function save()
    {
        if ($this->denied($this->user_id ? 'update_user' : 'create_user')) {
            return;
        }

        $this->validate(
            [
                'name'  => 'required',
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user_id)],
                'role'  => ['required', Rule::in($this->assignableRoles()->pluck('name')->all())],
            ],
            [
                'name.required'  => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email'    => 'Email tidak valid.',
                'email.unique'   => 'Email sudah digunakan.',
                'role.required'  => 'Role wajib diisi.',
                'role.in'        => 'Role tidak valid.',
            ]
        );

        if ($this->user_id) {
            $user = User::findOrFail($this->user_id);

            if (! $this->canManage($user)) {
                return;
            }

            $oldRole = $user->getRoleNames()->first();

            if ($user->id === Auth::id() && $this->role !== $oldRole) {
                $this->addError('role', 'Anda tidak dapat mengubah role Anda sendiri.');
                return;
            }

            if ($this->role !== 'super-admin' && $this->isLastActiveSuperAdmin($user)) {
                $this->addError('role', 'Role Super Admin terakhir tidak dapat diubah.');
                return;
            }

            DB::transaction(function () use ($user) {
                $user->update([
                    'name'  => $this->name,
                    'email' => $this->email,
                ]);

                $user->syncRoles($this->role);
            });

            if ($oldRole !== $this->role) {
                activity('User')
                    ->performedOn($user)
                    ->event('role-changed')
                    ->withProperties(['old' => $oldRole, 'new' => $this->role])
                    ->log('Role user diubah');
            }

            $message = 'User berhasil diupdate.';
        } else {
            $user = DB::transaction(function () {
                $user = User::create([
                    'name'              => $this->name,
                    'email'             => $this->email,
                    'password'          => Hash::make('password'),
                    'email_verified_at' => now(),
                ]);

                $user->assignRole($this->role);

                return $user;
            });

            activity('User')
                ->performedOn($user)
                ->event('role-changed')
                ->withProperties(['old' => null, 'new' => $this->role])
                ->log('Role user ditetapkan');

            $message = 'User berhasil disimpan.';
        }

        $this->resetInputFields();
        $this->dispatch('closeModal', id: 'userModal');

        $this->success($message);
    }

    /* ---------- Aktif / nonaktif ---------- */
    public function confirmToggle($id)
    {
        if ($this->denied('update_user')) {
            return;
        }

        $user = User::findOrFail($id);

        if (! $this->canManage($user)) {
            return;
        }

        $action = $user->is_active ? 'Nonaktifkan' : 'Aktifkan';

        $this->dispatch(
            'confirmAction',
            id: $user->id,
            component: $this->getId(),
            method: 'toggleActive',
            title: "{$action} user?",
            html: '<b>' . e($user->name) . '</b><br><small>' . e($user->email) . '</small>',
            confirmText: 'Ya, ' . strtolower($action),
            icon: $user->is_active ? 'warning' : 'question',
        );
    }

    public function toggleActive($id)
    {
        if ($this->denied('update_user')) {
            return;
        }

        $user = User::findOrFail($id);

        if (! $this->canManage($user)) {
            return;
        }

        if ($user->id === Auth::id()) {
            $this->error('Anda tidak dapat menonaktifkan akun Anda sendiri.');
            return;
        }

        if ($this->isLastActiveSuperAdmin($user)) {
            $this->error('Super Admin aktif terakhir tidak dapat dinonaktifkan.');
            return;
        }

        $user->update(['is_active' => ! $user->is_active]);

        $this->success($user->is_active ? 'User berhasil diaktifkan.' : 'User berhasil dinonaktifkan.');
    }

    /* ---------- Hapus ---------- */

    public function confirmDelete($id)
    {
        if ($this->denied('delete_user')) {
            return;
        }

        $user = User::findOrFail($id);

        if (! $this->canManage($user)) {
            return;
        }

        $this->dispatch(
            'confirmDelete',
            id: $user->id,
            component: $this->getId(),
            html: '<b>' . e($user->name) . '</b><br><small>' . e($user->email) . '</small>',
        );
    }

    public function destroy($id)
    {
        if ($this->denied('delete_user')) {
            return;
        }

        $user = User::findOrFail($id);

        if (! $this->canManage($user)) {
            return;
        }

        if ($user->id === Auth::id()) {
            $this->error('Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        if ($this->isLastActiveSuperAdmin($user)) {
            $this->error('Super Admin aktif terakhir tidak dapat dihapus.');
            return;
        }

        $user->delete();

        $this->success('User berhasil dihapus.');
    }

    public function goToTrashed()
    {
        Gate::authorize('restore_user');

        return $this->redirectRoute('users.trashed');
    }

    /* ---------- Render ---------- */

    public function render()
    {
        return view('livewire.user-management.user.index', [
            'roles' => $this->assignableRoles()->get(),
            'users' => User::select('users.*')
                ->leftJoin('model_has_roles', function ($join) {
                    $join->on('users.id', '=', 'model_has_roles.model_id')
                        ->where('model_has_roles.model_type', User::class);
                })
                ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->with('roles:id,name')
                ->where(function ($query) {
                    $query->where('users.name', 'like', "%{$this->search}%")
                        ->orWhere('users.email', 'like', "%{$this->search}%")
                        ->orWhere('roles.name', 'like', "%{$this->search}%");
                })
                ->orderByRaw("
                    CASE roles.name
                        WHEN 'super-admin' THEN 1
                        WHEN 'admin-pmb' THEN 2
                        WHEN 'pimpinan' THEN 3
                        WHEN 'keuangan' THEN 4
                        WHEN 'calon-mahasiswa' THEN 5
                        ELSE 99
                    END
                ")
                ->orderBy('users.name')
                ->paginate($this->paginate)
                ->withQueryString(),
        ]);
    }
}
