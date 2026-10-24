    <div>
        <x-card title="Users">
            <x-slot:actions>
                <x-button can="create_user" wire:click="create" icon="bi-person-fill-add">
                    Tambah User
                </x-button>
            </x-slot:actions>

            <x-table.toolbar />

            <x-table :paginator="$users">
                <x-slot:head>
                    <th width="5%" class="text-center">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="10%" class="text-center"><i class="bi bi-gear"></i></th>
                </x-slot:head>

                @foreach ($users as $user)
                    <tr wire:key="user-{{ $user->id }}">
                        <td class="text-center">{{ $users->firstItem() + $loop->index }}</td>
                        <td class="text-bold-500">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->getRoleNames()->implode(', ') ?: '-' }}</td>
                        <x-table.actions :id="$user->id" can-edit="update_user" can-delete="delete_user"
                            :delete="true" :edit="true">
                            <x-button can="update_user" wire:click="confirmToggle('{{ $user->id }}')" variant="link"
                                class="p-0 lh-1 fs-6" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <i
                                    class="bi {{ $user->is_active ? 'bi-toggle-on text-success' : 'bi-toggle-off text-secondary' }}"></i>
                            </x-button>
                        </x-table.actions>
                    </tr>
                @endforeach
            </x-table>
        </x-card>

        @include('livewire.user-management.user.form')
    </div>
