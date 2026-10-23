<div>
    <x-card title="Permissions">
        <x-slot:actions>
            <x-button can="create_permission" wire:click="create" icon="bi-person-fill-add">
                Tambah Permission
            </x-button>
        </x-slot:actions>

        <x-table.toolbar />

        <x-table :paginator="$permissions">
            <x-slot:head>
                <th width="5%" class="text-center">No</th>
                <th>Permission</th>
                <th>Guard_name</th>
                <th width="10%" class="text-center"><i class="bi bi-gear"></i></th>
            </x-slot:head>

            @foreach ($permissions as $permission)
                <tr wire:key="permission-{{ $permission->id }}">
                    <td class="text-center">{{ $permissions->firstItem() + $loop->index }}</td>
                    <td class="text-bold-500">{{ $permission->name }}</td>
                    <td>{{ $permission->guard_name }}</td>
                    <x-table.actions :id="$permission->id" can-edit="update_permission" can-delete="delete_permission" />
                </tr>
            @endforeach
        </x-table>
    </x-card>

    {{-- Modal --}}
    @include('livewire.user-management.permission.form')
</div>
