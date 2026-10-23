<?php

namespace App\Livewire\ActivityLog;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

#[Layout('layouts.app')]
#[Title('Activity Log')]
class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $paginate = 10;
    public $search = '';
    public $logName = '';
    public $event = '';
    public $dateFrom = '';
    public $dateTo = '';

    #[Locked]
    public $selectedId = null;

    public function mount()
    {
        Gate::authorize('read_activity_log');
    }

    public function updated($property)
    {
        if (in_array($property, ['paginate', 'search', 'logName', 'event', 'dateFrom', 'dateTo'])) {
            $this->resetPage();
        }
    }

    #[Computed]
    public function logNames()
    {
        return Activity::query()->whereNotNull('log_name')->distinct()->orderBy('log_name')->pluck('log_name');
    }

    #[Computed]
    public function events()
    {
        return Activity::query()->whereNotNull('event')->distinct()->orderBy('event')->pluck('event');
    }

    public function show($id)
    {
        Gate::authorize('read_activity_log');

        $this->selectedId = Activity::findOrFail($id)->id;

        $this->dispatch('openModal', id: 'activityModal');
    }

    public function resetFilters()
    {
        $this->reset(['search', 'logName', 'event', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    public function render()
    {
        $activities = Activity::query()
            ->with(['causer', 'subject'])
            ->when($this->search, function ($q) {
                $term = "%{$this->search}%";

                $q->where(function ($q) use ($term) {
                    $q->where('description', 'like', $term)
                        ->orWhereHasMorph('causer', [User::class], function ($q) use ($term) {
                            $q->where(function ($q) use ($term) {
                                $q->where('name', 'like', $term)
                                    ->orWhere('email', 'like', $term);
                            });
                        });
                });
            })
            ->when($this->logName, fn($q) => $q->where('log_name', $this->logName))
            ->when($this->event, fn($q) => $q->where('event', $this->event))
            ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->latest()
            ->latest('id')
            ->paginate($this->paginate);

        return view('livewire.activity-log.index', [
            'activities' => $activities,
            'selected'   => $this->selectedId
                ? Activity::with(['causer', 'subject'])->find($this->selectedId)
                : null,
        ]);
    }
}
