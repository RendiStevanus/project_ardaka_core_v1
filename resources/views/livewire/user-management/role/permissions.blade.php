<div wire:ignore.self class="modal modal-lg fade text-left" id="setPermissionModal" tabindex="-1"
    aria-labelledby="setPermissionModalLabel" style="display: none;" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form wire:submit="savePermissions">
                <div class="modal-header">
                    <h5 class="modal-title" id="setPermissionModalLabel">Set Permission</h5>
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
                        <label for="permission-role-name" class="col-sm-1 col-form-label col-form-label-sm">Role</label>
                        <div class="col-sm-11">
                            <input wire:model="name" type="text" id="permission-role-name"
                                class="form-control form-control-sm" disabled>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="25%">Menu</th>
                                    @foreach ($actions as $action)
                                        <th class="text-center">{{ $action }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($permissionGroups as $resource => $permissions)
                                    <tr>
                                        <td>{{ $resource }}</td>

                                        @foreach ($actions as $action)
                                            <td class="text-center">
                                                @if (isset($permissions[$action]))
                                                    <div class="form-check form-switch d-flex justify-content-center">
                                                        <input type="checkbox" class="form-check-input"
                                                            wire:model="rolePermissions"
                                                            value="{{ $permissions[$action] }}">
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-xs ms-1" wire:loading.attr="disabled"
                        wire:target="savePermissions">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
