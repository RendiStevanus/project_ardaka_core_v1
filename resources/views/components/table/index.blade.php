<div>
    <!-- Very little is needed to make a happy life. - Marcus Aurelius -->
    @props(['paginator' => null])

    <div class="table-responsive">
        <table class="table table-hover mb-2">
            <thead>
                <tr>{{ $head }}</tr>
            </thead>
            <tbody>{{ $slot }}</tbody>
        </table>

        @if ($paginator)
            {{ $paginator->onEachSide(0)->links() }}
        @endif
    </div>
</div>
