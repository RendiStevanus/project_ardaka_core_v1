<div>
    @props(['title'])

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="card-title mb-0">{{ $title }}</h3>

            @isset($actions)
                <div class="d-flex gap-2 mt-2 mt-md-0">{{ $actions }}</div>
            @endisset
        </div>

        <div class="card-content">
            <div class="card-body">{{ $slot }}</div>
        </div>
    </div>
</div>
