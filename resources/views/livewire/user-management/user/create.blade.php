<div wire:ignore.self class="modal fade text-left" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
    style="display: none;" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"> Tambah User</h5>
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
                <form wire:submit.prevent="store">
                    {{-- Nama --}}
                    <div class="row mb-3">
                        <label for="name-horizontal" class="col-sm-2 col-form-label col-form-label-sm">Nama</label>
                        <div class="col-sm-10">
                            <input wire:model="name" type="text" id="name-horizontal"
                                class="form-control form-control-sm @error('name')
                                    is-invalid
                                @enderror"
                                placeholder="Nama..." value="{{ old('name') }}" autofocus>
                            @error('name')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="row mb-3">
                        <label for="email-horizontal" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
                        <div class="col-sm-10">
                            <input wire:model="email" type="email" id="email-horizontal"
                                class="form-control form-control-sm @error('email')
                                    is-invalid
                                @enderror"
                                placeholder="Email..." value="{{ old('email') }}">
                            @error('email')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    {{-- Role --}}
                    <div class="row mb-3">
                        <label for="role-horizontal" class="col-sm-2 col-form-label col-form-label-sm">Role</label>
                        <div class="col-sm-10">
                            <select wire:model="role"
                                class="form-select form-select-sm @error('role')
                                    is-invalid
                                @enderror"
                                id="role-horizontal">
                                <option value="" disabled>::.. Pilih Role ..::</option>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">
                    <i class="bi bi-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Batal</span>
                </button>

                <button type="submit" class="btn btn-primary btn-xs ms-1">
                    <i class="bi bi-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Simpan</span>
                </button>
                </form>
                {{-- End Form --}}
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
</div>
