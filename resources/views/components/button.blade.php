@props([
    'isDisabled' => true,
    'disabled' => false
])
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn']) }}
    @if ($isDisabled)
        {{ $attributes->merge([':disabled' => 'isLoading']) }}
    @endif
    @if ($disabled)
        disabled
    @endif
    >
    {{ $slot }}
</button>
