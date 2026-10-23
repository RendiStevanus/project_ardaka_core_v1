<div>
    <div class="mb-3 d-flex justify-content-between">
        <div class="col-12 col-md-2 d-flex align-items-center">
            <select wire:model.live="paginate" class="form-select form-select-sm" id="paginate">
                @foreach ([5, 10, 25, 50, 100] as $n)
                    <option value="{{ $n }}">{{ $n }}</option>
                @endforeach
            </select>
            <label class="form-label ms-2" for="paginate">entries</label>
        </div>
        <div>
            <input wire:model.live="search" class="form-control form-control-sm" id="search" placeholder="Search..."
                type="text">
        </div>
    </div>
</div>
