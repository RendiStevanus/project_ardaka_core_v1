<div>
    <x-card title="Users Terhapus">
        <x-slot:actions>
            <x-button wire:click="back" variant="secondary" icon="bi-arrow-left">
                Kembali
            </x-button>
        </x-slot:actions>

        <x-table.toolbar />

        <x-table :paginator="$users">
            <x-slot:head>
                <th width="5%" class="text-center">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Dihapus pada</th>
                <th width="10%" class="text-center"><i class="bi bi-gear"></i></th>
            </x-slot:head>

            @forelse ($users as $user)
                <tr wire:key="trashed-{{ $user->id }}">
                    <td class="text-center">{{ $users->firstItem() + $loop->index }}</td>
                    <td class="text-bold-500">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->implode(', ') ?: '-' }}</td>
                    <td class="text-nowrap">{{ $user->deleted_at->format('d M Y H:i') }}</td>
                    <x-table.actions :id="$user->id" :edit="false" :delete="false">
                        <x-button can="restore_user" wire:click="confirmRestore('{{ $user->id }}')" variant="link"
                            class="p-0 lh-1 fs-6" title="Pulihkan">
                            <i class="bi bi-arrow-counterclockwise text-success"></i>
                        </x-button>

                        <x-button can="forcedelete_user" wire:click="confirmForceDelete('{{ $user->id }}')"
                            variant="link" class="p-0 lh-1 fs-6" title="Hapus permanen">
                            <i class="bi bi-trash3-fill text-danger"></i>
                        </x-button>
                    </x-table.actions>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada user yang dihapus.</td>
                </tr>
            @endforelse
        </x-table>
    </x-card>
</div>
