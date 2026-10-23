<div wire:ignore.self class="modal fade text-left" id="userModal" tabindex="-1" aria-labelledby="userModalLabel"
    style="display: none;" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form wire:submit="save">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">
                        {{ $user_id ? 'Edit User' : 'Tambah User' }}
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
                    {{-- Nama --}}
                    <div class="row mb-3">
                        <label for="user-name" class="col-sm-2 col-form-label col-form-label-sm">Nama</label>
                        <div class="col-sm-10">
                            <input wire:model="name" type="text" id="user-name"
                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                placeholder="Nama...">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="row mb-3">
                        <label for="user-email" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
                        <div class="col-sm-10">
                            <input wire:model="email" type="email" id="user-email"
                                class="form-control form-control-sm @error('email') is-invalid @enderror"
                                placeholder="Email...">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Role --}}
                    <div class="row mb-3">
                        <label for="user-role" class="col-sm-2 col-form-label col-form-label-sm">Role</label>
                        <div class="col-sm-10">
                            <select wire:model="role" id="user-role"
                                class="form-select form-select-sm @error('role') is-invalid @enderror">
                                <option value="">::.. Pilih Role ..::</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->name }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
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
                        {{ $user_id ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
