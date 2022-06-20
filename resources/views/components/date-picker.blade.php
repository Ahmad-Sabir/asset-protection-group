@pushOnce('style')
<link rel="stylesheet" href="{{ '/css/date-picker.css' }}">
@endPushOnce
@php
    $class = isset($mode) && $mode == 'range' ? 'range-input' : '';
@endphp
<div class="calender-field">
    <input id="{{ $id ?? 'date-picker' }}" {!! $attributes->merge(['class' => 'flatpickr form-control ' . $class, 'placeholder' => 'Select Date']) !!} type="text" onkeydown="return false" >
    @isset($mode)
    <em class="fa-solid fa-arrow-right right-arrow-icon"> <span>To</span></em>
    @endisset
    <em class="fa-solid fa-calendar"></em>
</div>

@pushOnce('script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endPushOnce

@push('script')
<script>
    var format = {
        dateFormat: "m-d-Y"
    };
    @isset ($mode)
        format = Object.assign(format, {'mode' : 'range'})
    @endisset
    @isset ($maxDate)
        format = Object.assign(format, {'maxDate': "today"})
    @endisset

    flatpickr("#{{ $id ?? 'date-picker' }}", format);
</script>
@endpush
