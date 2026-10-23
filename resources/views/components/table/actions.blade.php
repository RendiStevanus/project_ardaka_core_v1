<div>
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
    @props(['id', 'canEdit' => null, 'canDelete' => null, 'edit' => true, 'delete' => true])

    <td class="text-center align-middle">
        <div class="d-flex justify-content-center align-items-center gap-2">
            {{ $slot }}

            @if ($edit)
                <x-button :can="$canEdit" wire:click="edit('{{ $id }}')" variant="link" icon="bi-pen"
                    class="p-0 lh-1 fs-6" />
            @endif

            @if ($delete)
                <x-button :can="$canDelete" wire:click="confirmDelete('{{ $id }}')" variant="link"
                    class="p-0 lh-1 fs-6">
                    <i class="bi bi-trash text-danger"></i>
                </x-button>
            @endif
        </div>
    </td>
</div>
