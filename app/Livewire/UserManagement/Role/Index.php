<?php

namespace App\Livewire\UserManagement\Role;

use App\Traits\AlertTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use SweetAlert2\Laravel\Traits\WithSweetAlert;

#[Layout('layouts.app')]
#[Title('Roles')]
class Index extends Component
{
    use WithPagination;
    use WithSweetAlert;
    use AlertTrait;

    protected $paginationTheme = 'bootstrap';

    public $paginate = 10;
    public $search = '';

    #[Locked]
    public $roleId = null;

    public $name = '';

    public array $actions = [];
    public array $permissionGroups = [];
    public array $rolePermissions = [];

    public function mount()
    {
        $permissions = Permission::orderBy('id', 'asc')->get();

        $this->actions = $permissions
            ->map(fn($permission) => Str::before($permission->name, '_'))
            ->unique()
            ->values()
            ->toArray();

        $groups = [];

        foreach ($permissions as $permission) {
            $action   = Str::before($permission->name, '_');
            $resource = Str::after($permission->name, '_');

            $groups[$resource][$action] = $permission->name;
        }

        $this->permissionGroups = $groups;
    }

    public function resetInputFields()
    {
        $this->reset(['name', 'roleId', 'rolePermissions']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.user-management.role.index', [
            'roles' => Role::where('name', 'like', "%{$this->search}%")
                ->orderBy('id', 'ASC')
                ->paginate($this->paginate),
        ]);
    }

    public function create()
    {
        Gate::authorize('create_role');

        $this->resetInputFields();
        $this->dispatch('openModal', id: 'roleModal');
    }

    public function edit($id)
    {
        Gate::authorize('update_role');

        $this->resetInputFields();

        $role = Role::findOrFail($id);

        $this->roleId = $role->id;
        $this->name   = $role->name;

        $this->dispatch('openModal', id: 'roleModal');
    }

    public function save()
    {
        Gate::authorize($this->roleId ? 'update_role' : 'create_role');

        $this->validate(
            [
                'name' => [
                    'required',
                    Rule::unique('roles', 'name')
                        ->where('guard_name', 'web')
                        ->ignore($this->roleId),
                ],
            ],
            [
                'name.required' => 'Role wajib diisi.',
                'name.unique'   => 'Role sudah ada.',
            ]
        );

        if ($this->roleId) {
            $role = Role::findOrFail($this->roleId);

            if ($role->name === 'super-admin' && $this->name !== 'super-admin') {
                $this->addError('name', 'Nama role Super Admin tidak dapat diubah.');
                return;
            }

            $role->update(['name' => $this->name]);
            $message = 'Role berhasil diupdate.';
        } else {
            Role::create([
                'name'       => $this->name,
                'guard_name' => 'web',
            ]);
            $message = 'Role berhasil disimpan.';
        }

        $this->resetInputFields();
        $this->dispatch('closeModal', id: 'roleModal');

        $this->success($message);
    }

    public function confirmDelete($id)
    {
        Gate::authorize('delete_role');

        $role = Role::findOrFail($id);

        $this->dispatch(
            'confirmDelete',
            id: $role->id,
            component: $this->getId(),
            html: '<b>' . e($role->name) . '</b>',
        );
    }

    public function destroy($id)
    {
        Gate::authorize('delete_role');

        $role = Role::findOrFail($id);

        if ($role->name === 'super-admin') {
            $this->error('Role Super Admin tidak dapat dihapus.');
            return;
        }

        $role->delete();

        $this->success('Role berhasil dihapus.');
    }

    public function setPermissions($id)
    {
        Gate::authorize('update_role');

        $this->resetInputFields();

        $role = Role::findOrFail($id);

        $this->roleId = $role->id;
        $this->name   = $role->name;
        $this->rolePermissions = $role->permissions->pluck('name')->toArray();

        $this->dispatch('openModal', id: 'setPermissionModal');
    }

    public function savePermissions()
    {
        Gate::authorize('update_role');

        $role = Role::findOrFail($this->roleId);
        $role->syncPermissions($this->rolePermissions);

        $this->resetInputFields();
        $this->dispatch('closeModal', id: 'setPermissionModal');

        $this->success('Permission berhasil diperbarui.');
    }
}
