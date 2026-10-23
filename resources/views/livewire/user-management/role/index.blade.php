<div>
    <x-card title="Roles">
        <x-slot:actions>
            <x-button can="create_role" wire:click="create" icon="bi-person-fill-add">
                Tambah Role
            </x-button>
        </x-slot:actions>

        <x-table.toolbar />

        <x-table :paginator="$roles">
            <x-slot:head>
                <th width="5%" class="text-center">No</th>
                <th>Role</th>
                <th>guard_name</th>
                <th width="10%">Permissions</th>
                <th width="10%" class="text-center"><i class="bi bi-gear"></i></th>
            </x-slot:head>

            @foreach ($roles as $role)
                <tr wire:key="role-{{ $role->id }}">
                    <td class="text-center">{{ $roles->firstItem() + $loop->index }}</td>
                    <td class="text-bold-500">{{ $role->name }}</td>
                    <td>{{ $role->guard_name }}</td>
                    <td>
                        <x-button can="update_role" wire:click="setPermissions('{{ $role->id }}')"
                            variant="outline-success" icon="bi-gear">
                            Set Permissions
                        </x-button>
                    </td>
                    <x-table.actions :id="$role->id" can-edit="update_role" can-delete="delete_role" />
                </tr>
            @endforeach
        </x-table>
    </x-card>

    {{-- Modal --}}
    @include('livewire.user-management.role.form')
    @include('livewire.user-management.role.permissions')

</div>
