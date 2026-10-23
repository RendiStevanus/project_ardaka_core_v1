<div wire:ignore.self class="modal fade text-left" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel"
    style="display: none;" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form wire:submit="save">
                <div class="modal-header">
                    <h5 class="modal-title" id="roleModalLabel">
                        {{ $roleId ? 'Edit Role' : 'Tambah Role' }}
                    </h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="role-name" class="col-sm-2 col-form-label col-form-label-sm">Role</label>
                        <div class="col-sm-10">
                            <input wire:model="name" type="text" id="role-name"
                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                placeholder="Role...">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-xs ms-1" wire:loading.attr="disabled"
                        wire:target="save">
                        {{ $roleId ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
