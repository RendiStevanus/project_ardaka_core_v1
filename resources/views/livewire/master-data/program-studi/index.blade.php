<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="card-title mb-0">Program Studi</h3>

            <div class="d-flex gap-2 mt-2 mt-md-0">
                @can('create_master_program_studi')
                    <button wire:click="create" type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i class="bi bi-person-fill-add"></i> Tambah
                    </button>
                @endcan
                @can('export_master_program_studi')
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-printer"></i> Export
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-file-earmark-excel"></i> Export to Excel
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-filetype-pdf"></i> Export to PDF
                                </a>
                            </li>
                        </ul>
                    </div>
                @endcan
            </div>

        </div>

        <div class="card-content">
            <div class="card-body">
                <!-- Table with outer spacing -->
                <div class="mb-3 d-flex justify-content-between">
                    <div class="col-12 col-md-2 d-flex align-items-center">
                        <select wire:model.live="paginate" class="form-select form-select-sm" id="paginate">
                            <option value="5">5</option>
                            <option value="10" selected="">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label class="form-label ms-2" for="paginate">entries</label>
                    </div>
                    <div>
                        <input wire:model.live="search" class="form-control form-control-sm" id="search"
                            placeholder="Search..." type="text">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-2">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jenjang</th>
                                <th>Akreditasi</th>
                                <th width="10%" class="text-center"><i class="bi bi-gear"></i></th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $no = $program_studi->firstItem();
                            @endphp

                            @foreach ($program_studi as $item)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-bold-500">{{ $item->kode }}</td>
                                    <td class="text-bold-500">{{ $item->nama }}</td>
                                    <td>{{ $item->jenjang }}</td>
                                    <td>{{ $item->akreditasi }}</td>
                                    <td class="text-center">
                                        @can('update_master_program_studi')
                                            <a wire:click="edit({{ $item->id }})" href="#" data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="bi bi-pen"></i>
                                            </a>
                                        @endcan
                                        @can('delete_master_program_studi')
                                            <button wire:click="confirmDelete({{ $item->id }})"
                                                class="btn btn-link p-0">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $program_studi->onEachSide(0)->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    @include('livewire.master-data.program-studi.create')
    @include('livewire.master-data.program-studi.edit')

    @script
        <script>
            $wire.on('closeCreateModal', () => {
                $('#createModal').modal('hide');
            });

            $wire.on('closeEditModal', () => {
                $('#editModal').modal('hide');
            });

            $wire.on('confirmDelete', (event) => {
                Swal.fire({
                    html: `
                            Apakah Anda yakin ingin menghapus program studi berikut?<hr>
                            <b>(${event.kode}) ${event.jenjang}</b> <b>${event.nama}</b><br>
                        `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#435ebe',
                    cancelButtonColor: '#dc3545',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.destroy(event.id);
                    }
                });
            });
        </script>
    @endscript

</div>
