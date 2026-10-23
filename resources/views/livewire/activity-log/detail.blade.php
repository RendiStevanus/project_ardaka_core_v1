<div wire:ignore.self class="modal modal-lg fade text-left" id="activityModal" tabindex="-1"
    aria-labelledby="activityModalLabel" style="display: none;" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activityModalLabel">Detail Aktivitas</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body">
                @if ($selected)
                    @php
                        $changes = collect($selected->attribute_changes);
                        $new = $changes->get('attributes', []);
                        $old = $changes->get('old', []);
                        $fields = collect(array_keys($new))->merge(array_keys($old))->unique();
                        $props = collect($selected->properties);
                    @endphp

                    <dl class="row mb-3">
                        <dt class="col-sm-3">Waktu</dt>
                        <dd class="col-sm-9">{{ $selected->created_at->format('d M Y H:i:s') }}</dd>

                        <dt class="col-sm-3">Pengguna</dt>
                        <dd class="col-sm-9">{{ $selected->causer?->name ?? 'Sistem' }}</dd>

                        <dt class="col-sm-3">Event</dt>
                        <dd class="col-sm-9">{{ $selected->event ?? '-' }}</dd>

                        <dt class="col-sm-3">Data</dt>
                        <dd class="col-sm-9">
                            {{ $selected->subject_type ? class_basename($selected->subject_type) : '-' }}
                            @if ($selected->subject_id)
                                <small class="text-muted">({{ $selected->subject_id }})</small>
                            @endif
                        </dd>

                        <dt class="col-sm-3">Deskripsi</dt>
                        <dd class="col-sm-9">{{ $selected->description }}</dd>
                    </dl>

                    @if ($fields->isNotEmpty())
                        <h6>Perubahan data</h6>
                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="25%">Field</th>
                                        <th>Sebelum</th>
                                        <th>Sesudah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fields as $field)
                                        @php
                                            $before = $old[$field] ?? null;
                                            $after = $new[$field] ?? null;
                                        @endphp
                                        <tr>
                                            <td>{{ $field }}</td>
                                            <td class="text-danger">
                                                {{ is_string($before) ? $before : json_encode($before) }}</td>
                                            <td class="text-success">
                                                {{ is_string($after) ? $after : json_encode($after) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($props->isNotEmpty())
                        <h6>Informasi tambahan</h6>
                        <table class="table table-sm table-bordered mb-0">
                            <tbody>
                                @foreach ($props as $key => $value)
                                    <tr>
                                        <td width="25%">{{ $key }}</td>
                                        <td>{{ is_string($value) ? $value : json_encode($value) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
