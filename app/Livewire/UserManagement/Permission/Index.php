<?php

namespace App\Livewire\UserManagement\Permission;

use App\Traits\AlertTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use SweetAlert2\Laravel\Traits\WithSweetAlert;

#[Layout('layouts.app')]
#[Title('Permissions')]
class Index extends Component
{
    use WithPagination;
    use WithSweetAlert;
    use AlertTrait;

    protected $paginationTheme = 'bootstrap';

    public $paginate = 10;
    public $search = '';

    #[Locked]
    public $permissionId = null;

    public $name = '';

    public function resetInputFields()
    {
        $this->reset(['name', 'permissionId']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.user-management.permission.index', [
            'permissions' => Permission::where('name', 'like', "%{$this->search}%")
                ->orderBy('id', 'desc')
                ->paginate($this->paginate),
        ]);
    }

    public function create()
    {
        Gate::authorize('create_permission');

        $this->resetInputFields();
        $this->dispatch('openModal', id: 'permissionModal');
    }

    public function edit($id)
    {
        Gate::authorize('update_permission');

        $this->resetInputFields();

        $permission = Permission::findOrFail($id);

        $this->permissionId = $permission->id;
        $this->name         = $permission->name;

        $this->dispatch('openModal', id: 'permissionModal');
    }

    public function save()
    {
        Gate::authorize($this->permissionId ? 'update_permission' : 'create_permission');

        $this->validate(
            [
                'name' => [
                    'required',
                    Rule::unique('permissions', 'name')
                        ->where('guard_name', 'web')
                        ->ignore($this->permissionId),
                ],
            ],
            [
                'name.required' => 'Permission wajib diisi.',
                'name.unique'   => 'Permission sudah ada.',
            ]
        );

        if ($this->permissionId) {
            Permission::findOrFail($this->permissionId)->update([
                'name' => $this->name,
            ]);
            $message = 'Permission berhasil diupdate.';
        } else {
            Permission::create([
                'name'       => $this->name,
                'guard_name' => 'web',
            ]);
            $message = 'Permission berhasil disimpan.';
        }

        $this->resetInputFields();
        $this->dispatch('closeModal', id: 'permissionModal');

        $this->success($message);
    }

    public function confirmDelete($id)
    {
        Gate::authorize('delete_permission');

        $permission = Permission::findOrFail($id);

        $this->dispatch(
            'confirmDelete',
            id: $permission->id,
            component: $this->getId(),
            html: '<b>' . e($permission->name) . '</b>',
        );
    }

    public function destroy($id)
    {
        Gate::authorize('delete_permission');

        Permission::findOrFail($id)->delete();

        $this->success('Permission berhasil dihapus.');
    }
}
