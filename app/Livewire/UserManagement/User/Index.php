<?php

namespace App\Livewire\UserManagement\User;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use SweetAlert2\Laravel\Traits\WithSweetAlert;
use App\Traits\AlertTrait;

#[Layout('layouts.app')]
#[Title('Users')]
class Index extends Component
{
    use WithPagination;
    use WithSweetAlert;
    use AlertTrait;

    protected $paginationTheme = 'bootstrap';

    public $paginate = '10';

    public $search = '';

    public $roles = [];

    public $name = '';

    public $email = '';

    public $role = '';

    public $user_id = '';

    public $deleteId = '';

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->role = '';
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

    public function mount()
    {
        $this->roles = Role::orderBy('name')->get();
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
                'email' => 'required|email|unique:users',
                'role' => 'required',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'role.required' => 'Role wajib diisi.',
            ]
        );

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt('password'),
        ]);

        $user->assignRole($this->role);

        $this->resetInputFields();
        $this->dispatch('closeCreateModal');

        $this->success('User berhasil disimpan.');
    }

    public function edit($id)
    {
        $this->resetValidation();

        $user = User::with('roles')->findOrFail($id);

        $this->name     = $user->name;
        $this->email    = $user->email;
        $this->role     = $user->getRoleNames()->first();
        $this->user_id  = $user->id;
    }

    public function update($user_id)
    {
        $this->validate(
            [
                'name'  => 'required',
                'email' => 'required|email|unique:users,email,' . $user_id,
                'role'  => 'required',
            ],
            [
                'name.required'     => 'Nama wajib diisi.',
                'email.required'    => 'Email wajib diisi.',
                'email.email'       => 'Email tidak valid.',
                'email.unique'      => 'Email sudah digunakan.',
                'role.required'     => 'Role wajib diisi.',
            ]
        );

        $user = User::findOrFail($user_id);
        $user->update([
            'name'  => $this->name,
            'email' => $this->email,
        ]);
        
        // Jika $this->role berisi nama role
        $user->syncRoles($this->role);

        $this->resetInputFields();
        $this->dispatch('closeEditModal');

        $this->success('User berhasil diupdate.');
    }

    public function confirmDelete($id)
    {
        $user = User::findOrFail($id);

        $this->dispatch(
            'confirmDelete',
            id: $user->id,
            name: $user->name,
            email: $user->email,
        );
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        $this->success('User berhasil dihapus.');
    }

}
