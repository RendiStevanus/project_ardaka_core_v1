<div>
    @props([
        'icon' => null,
        'variant' => 'primary',
        'can' => null,
    ])

    @if (!$can || auth()->user()->can($can))
        <button {{ $attributes->merge(['type' => 'button', 'class' => "btn btn-{$variant} btn-xs"]) }}>
            @if ($icon)
                <i class="bi {{ $icon }}"></i>
            @endif
            {{ $slot }}
        </button>
    @endif
</div>
