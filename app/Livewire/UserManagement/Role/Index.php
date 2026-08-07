<?php

namespace App\Livewire\UserManagement\Role;

use App\Traits\AlertTrait;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
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

    public $roleId = '';
    public $name = '';
    public $guard_name = '';
    public $deleteId = '';


    public function resetInputFields()
    {
        $this->name = '';
    }

    public function render()
    {
        $data = [
            'roles' => Role::orderBy('id', 'ASC')
            ->where('name', 'like', "%{$this->search}%")
            ->paginate($this->paginate),
        ];

        return view('livewire.user-management.role.index', $data);
    }

    public function create()
    {
        $this->resetValidation();
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate(
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Role wajib diisi.',
            ]
        );

        Role::create([
            'name' => $this->name,
            'guard_name' => 'web',
        ]);

        $this->resetInputFields();
        $this->dispatch('closeCreateModal');

        $this->success('Role berhasil disimpan.');
    }

    public function edit($id)
    {
        $this->resetValidation();

        $role = Role::findOrFail($id);

        $this->name = $role->name;
        $this->roleId  = $role->id;
    }

    public function update($roleId)
    {
        $this->validate(
            [
                'name'  => 'required',
            ],
            [
                'name.required'     => 'Role wajib diisi.',
            ]
        );

        $role = Role::findOrFail($roleId);
        $role->update([
            'name'  => $this->name,
            'guard_name' => 'web',
        ]);
        
        $this->resetInputFields();
        $this->dispatch('closeEditModal');

        $this->success('Role berhasil diupdate.');
    }

    public function confirmDelete($roleId)
    {
        $role = Role::findOrFail($roleId);

        $this->dispatch(
            'confirmDelete',
            id: $role->id,
            name: $role->name,
        );
    }

    public function destroy($roleId)
    {
        Role::findOrFail($roleId)->delete();
        $this->success('Role berhasil dihapus.');
    }

    public array $actions = [];
    public $permissionGroups = [];

    public array $rolePermissions = [];
    public function mount()
    {
        $permissions = Permission::orderBy('id', 'asc')->get();

        // Action
        $this->actions = $permissions
            ->map(fn ($permission) => Str::before($permission->name, '_'))
            ->unique()
            ->values()
            ->toArray();

        // Group berdasarkan resource
        $groups = [];

        foreach ($permissions as $permission) {

            $action = Str::before($permission->name, '_');

            $resource = Str::after($permission->name, '_');

            $groups[$resource][$action] = $permission->name;
        }

        $this->permissionGroups = $groups;
    }

    public function setPermissions($id)
    {
        $role = Role::findOrFail($id);

        $this->roleId = $role->id;
        $this->name = $role->name;

        $this->rolePermissions = $role->permissions
            ->pluck('name')
            ->toArray();
    }

    public function savePermissions()
{
    $role = Role::findById($this->roleId);

    $role->syncPermissions($this->rolePermissions);

    $this->dispatch('closeSetPermissionModal');

    $this->success('Permission berhasil diperbarui.');
}

}
