<div wire:ignore.self class="modal fade text-left" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
    style="display: none;" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"> Tambah Program Studi</h5>
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

                    {{-- Kode --}}
                    <div class="row mb-3">
                        <label for="kode-horizontal" class="col-sm-2 col-form-label col-form-label-sm">Kode</label>
                        <div class="col-sm-10">
                            <input wire:model="kode" type="text" id="kode-horizontal"
                                class="form-control form-control-sm @error('kode')
                                    is-invalid
                                @enderror"
                                placeholder="Kode Program Studi" value="{{ old('kode') }}" autofocus>
                            @error('kode')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    {{-- Nama --}}
                    <div class="row mb-3">
                        <label for="name-horizontal" class="col-sm-2 col-form-label col-form-label-sm">Nama</label>
                        <div class="col-sm-10">
                            <input wire:model="nama" type="text" id="name-horizontal"
                                class="form-control form-control-sm @error('nama')
                                    is-invalid
                                @enderror"
                                placeholder="Nama Program Studi" value="{{ old('nama') }}" autofocus>
                            @error('nama')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    {{-- Jenjang --}}
                    <div class="row mb-3">
                        <label for="jenjang-horizontal"
                            class="col-sm-2 col-form-label col-form-label-sm">Jenjang</label>
                        <div class="col-sm-10">
                            <input wire:model="jenjang" type="text" id="jenjang-horizontal"
                                class="form-control form-control-sm @error('jenjang')
                                    is-invalid
                                @enderror"
                                placeholder="Jenjang Program Studi" value="{{ old('jenjang') }}" autofocus>
                            @error('jenjang')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    {{-- Akreditasi --}}
                    <div class="row mb-3">
                        <label for="akreditasi-horizontal"
                            class="col-sm-2 col-form-label col-form-label-sm">Akreditasi</label>
                        <div class="col-sm-10">
                            <input wire:model="akreditasi" type="text" id="akreditasi-horizontal"
                                class="form-control form-control-sm @error('akreditasi')
                                    is-invalid
                                @enderror"
                                placeholder="Akreditasi Program Studi" value="{{ old('akreditasi') }}" autofocus>
                            @error('akreditasi')
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
