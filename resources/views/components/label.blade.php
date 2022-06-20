@props(['value', 'required'])

<label {{ $attributes->merge(['class' => 'form-label']) }}>
    {{ $value ?? $slot }}
    @isset ($required)
        <span class="required">*</span>
    @endisset
</label>
