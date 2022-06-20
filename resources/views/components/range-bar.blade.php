@pushOnce('style')
<link rel="stylesheet" href="{{ asset('/css/range-bar.css') }}">
@endPushOnce
@if(isset($type) && $type == "single")
<div class="main-content-range-bar">
    <div class="range-slider grad"
        style='--min:0; --max:10000; --step:100; --value:200; --text-value:"200"; --prefix:"$"'>
        <input type="range" min="0" max="10000" step="100" value="200"
            oninput="this.parentNode.style.setProperty('--value',this.value); this.parentNode.style.setProperty('--text-value', JSON.stringify((+this.value).toLocaleString()))">
        <output></output>
        <div class='range-slider__progress'></div>
    </div>
</div>
@else
<!-- multi rangeslider (flat design)  -->

<div class="main-content-range-bar">
    <div class="range-slider flat" data-ticks-position='top'
        style='--min:{{ $range['min'] ?? 0 }}; --max:{{ $range['max'] ?? 0 }}; --value-a:{{ Arr::get($dynamicRange ?? [], 'min', 0) }}; --value-b:{{ Arr::get($dynamicRange ?? [], 'max', 0) }}; --prefix:"$"; --text-value-a:"{{ Arr::get($dynamicRange ?? [], 'min', 0) }}"; --text-value-b:"{{ Arr::get($dynamicRange ?? [], 'max', 0) }}";'>
        <input type="range" min="{{ $range['min'] ?? 0 }}" max="{{ $range['max'] ?? 0 }}"
            @isset($minModel)
                wire:model.defer="{{ $minModel }}"
            @endisset
            oninput="this.parentNode.style.setProperty('--value-a',this.value); this.parentNode.style.setProperty('--text-value-a', JSON.stringify(this.value))">
        <output></output>
        <input type="range" min="{{ $range['min'] ?? 0 }}" max="{{ $range['max'] ?? 0}}"
            @isset($maxModel)
                wire:model.defer="{{ $maxModel }}"
            @endisset
            oninput="this.parentNode.style.setProperty('--value-b',this.value); this.parentNode.style.setProperty('--text-value-b', JSON.stringify(this.value))">
        <output></output>
        <div class='range-slider__progress'></div>
    </div>
</div>
@endif

@pushOnce('script')
<script src="{{ asset('js/range-bar.js') }}" defer></script>
@endPushOnce
