<?php

namespace App\Livewire\UserManagement\Permission;

use Spatie\Permission\Models\Permission;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use SweetAlert2\Laravel\Traits\WithSweetAlert;
use App\Traits\AlertTrait;

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

    public $name = '';
    public $guard_name = '';

    public $permission_id = '';
    public $deleteId = '';

    public function resetInputFields()
    {
        $this->name = '';
    }

    public function render()
    {
        $data = [
            'permissions' => Permission::orderBy('id', 'desc')
            ->where('name', 'like', "%{$this->search}%")
            ->paginate($this->paginate),
        ];
        return view('livewire.user-management.permission.index', $data);
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

        Permission::create([
            'name' => $this->name,
            'guard_name' => 'web',
        ]);

        $this->resetInputFields();
        $this->dispatch('closeCreateModal');

        $this->success('Permission berhasil disimpan.');
    }

    public function edit($id)
    {
        $this->resetValidation();

        $permission = Permission::findOrFail($id);

        $this->name = $permission->name;
        $this->permission_id  = $permission->id;
    }

    public function update($permission_id)
    {
        $this->validate(
            [
                'name'  => 'required',
            ],
            [
                'name.required'     => 'Role wajib diisi.',
            ]
        );

        $permission = Permission::findOrFail($permission_id);
        $permission->update([
            'name'  => $this->name,
            'guard_name' => 'web',
        ]);
        
        $this->resetInputFields();
        $this->dispatch('closeEditModal');

        $this->success('Permission berhasil diupdate.');
    }

    public function confirmDelete($id)
    {
        $permission = Permission::findOrFail($id);

        $this->dispatch(
            'confirmDelete',
            id: $permission->id,
            name: $permission->name,
        );
    }

    public function destroy($id)
    {
        Permission::findOrFail($id)->delete();

        $this->success('Permission berhasil dihapus.');
    }
}
