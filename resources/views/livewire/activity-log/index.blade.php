<div>
    <x-card title="Activity Log">
        {{-- Filter --}}
        <div class="row g-2 mb-3">
            <div class="col-6 col-md-3">
                <select wire:model.live="logName" class="form-select form-select-sm">
                    <option value="">Semua modul</option>
                    @foreach ($this->logNames as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select wire:model.live="event" class="form-select form-select-sm">
                    <option value="">Semua event</option>
                    @foreach ($this->events as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <input wire:model.live="dateFrom" type="date" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-md-2">
                <input wire:model.live="dateTo" type="date" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-md-2">
                <x-button wire:click="resetFilters" variant="outline-secondary" icon="bi-arrow-counterclockwise">
                    Reset
                </x-button>
            </div>
        </div>

        <x-table.toolbar />

        <x-table :paginator="$activities">
            <x-slot:head>
                <th width="5%" class="text-center">No</th>
                <th>Waktu</th>
                <th>Pengguna</th>
                <th>Event</th>
                <th>Data</th>
                <th>Deskripsi</th>
                <th width="8%" class="text-center"><i class="bi bi-gear"></i></th>
            </x-slot:head>

            @foreach ($activities as $activity)
                @php
                    $badge = match ($activity->event) {
                        'created', 'login' => 'success',
                        'updated', 'permissions-synced' => 'warning',
                        'deleted', 'login-failed' => 'danger',
                        'logout' => 'info',
                        default => 'secondary',
                    };
                @endphp

                <tr wire:key="activity-{{ $activity->id }}">
                    <td class="text-center">{{ $activities->firstItem() + $loop->index }}</td>
                    <td class="text-nowrap">{{ $activity->created_at->format('d M Y H:i:s') }}</td>
                    <td>{{ $activity->causer?->name ?? 'Sistem' }}</td>
                    <td><span class="badge bg-{{ $badge }}">{{ $activity->event ?? '-' }}</span></td>
                    <td>{{ $activity->subject_type ? class_basename($activity->subject_type) : '-' }}</td>
                    <td>{{ $activity->description }}</td>
                    <x-table.actions :id="$activity->id" :edit="false" :delete="false">
                        <x-button wire:click="show('{{ $activity->id }}')" variant="link" icon="bi-eye"
                            class="p-0 lh-1 fs-6" />
                    </x-table.actions>
                </tr>
            @endforeach
        </x-table>
    </x-card>

    @include('livewire.activity-log.detail')
</div>
