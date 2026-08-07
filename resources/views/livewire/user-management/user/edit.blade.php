<div wire:ignore.self class="modal fade text-left" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
    style="display: none;" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"> Edit User</h5>
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
                <div class="form-body">
                    <div class="row">
                        <form wire:submit="update({{ $user_id }})">

                            {{-- Name --}}
                            <div class="row mb-3">
                                <label for="edit-name" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input wire:model="name" type="text"
                                        class="form-control form-control-sm @error('name')
                                    is-invalid @enderror"
                                        id="edit-name" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="row mb-3">
                                <label for="edit-email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input wire:model="email" type="text"
                                        class="form-control form-control-sm @error('email')
                                    is-invalid @enderror"
                                        id="edit-email" value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Role --}}
                            <div class="row mb-3">
                                <label for="edit-role" class="col-sm-2 col-form-label">role</label>
                                <div class="col-sm-10">
                                    <select wire:model="role"
                                        class="form-select form-select-sm @error('role') is-invalid @enderror"
                                        id="edit-role">
                                        <option value="">::.. Pilih Role ..::</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            {{-- form --}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Batal</span>
                </button>
                <button type="submit" class="btn btn-primary btn-xs ms-1">
                    <i class="bi bi-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Update</span>
                </button>
                </form>
                {{-- End Form --}}
            </div>
        </div>
    </div>

</div>
