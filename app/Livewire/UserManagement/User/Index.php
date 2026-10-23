<?php

namespace App\Livewire\UserManagement\User;

use App\Models\User;
use App\Traits\AlertTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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

    public $roles = [];

    public $name = '';

    public $email = '';

    public $role = '';


    public $deleteId = '';
    public function mount()
    {
        $this->roles = Role::orderBy('name')->get();
    }
    public function resetInputFields()
    {
        $this->reset(['name', 'email', 'role', 'user_id']);
        $this->resetValidation();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->dispatch('openModal', id: 'userModal');
    }

    public function edit($id)
    {
        if (Gate::denies('update_user')) {
            $this->error('Anda tidak memiliki akses untuk aksi ini.');
            return;
        }

        $this->resetInputFields();

        $user = User::findOrFail($id);

        $this->user_id = $user->id;
        $this->name    = $user->name;
        $this->email   = $user->email;
        $this->role    = $user->getRoleNames()->first() ?? '';

        $this->dispatch('openModal', id: 'userModal');
    }

    public function save()
    {
        if (Gate::denies($this->user_id ? 'update_user' : 'create_user')) {
            $this->error('Anda tidak memiliki akses untuk aksi ini.');
            return;
        }

        $this->validate(
            [
                'name'  => 'required',
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user_id)],
                'role'  => 'required',
            ],
            [
                'name.required'  => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email'    => 'Email tidak valid.',
                'email.unique'   => 'Email sudah digunakan.',
                'role.required'  => 'Role wajib diisi.',
            ]
        );

        if ($this->user_id) {
            $user = User::findOrFail($this->user_id);

            if (
                $user->hasRole('super-admin')
                && $this->role !== 'super-admin'
                && User::role('super-admin')->count() <= 1
            ) {
                $this->addError('role', 'Role Super Admin terakhir tidak dapat diubah.');
                return;
            }

            $oldRole = $user->getRoleNames()->first();

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
                    'name'     => $this->name,
                    'email'    => $this->email,
                    'password' => bcrypt('password'),
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

    public function render()
    {
        $data = [
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

        ];

        return view('livewire.user-management.user.index', $data);
    }

    public function confirmDelete($id)
    {
        if (Gate::denies('delete_user')) {
            $this->error('Anda tidak memiliki akses untuk aksi ini.');
            return;
        }

        $user = User::findOrFail($id);

        $this->dispatch(
            'confirmDelete',
            id: $user->id,
            component: $this->getId(),
            html: '<b>' . e($user->name) . '</b><br><small>' . e($user->email) . '</small>',
        );
    }

    public function destroy($id)
    {
        if (Gate::denies('delete_user')) {
            $this->error('Anda tidak memiliki akses untuk aksi ini.');
            return;
        }

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            $this->error('Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        if ($user->hasRole('super-admin') && User::role('super-admin')->count() <= 1) {
            $this->error('Super Admin terakhir tidak dapat dihapus.');
            return;
        }


        $user->delete();

        $this->success('User berhasil dihapus.');
    }
}
