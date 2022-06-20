@pushOnce('style')
<link rel="stylesheet" href="{{ url('assets/css/selectr.min.css') }}">
@endPushOnce
<div class="selectr-wrap">
    <select
        selectr-select
        data-livewire="{{ $this->id }}"
        data-onchangefun="{{ $this->onChangeFunc }}"
        {{ (isset($multiple) && $multiple == "true") ? 'multiple' : '' }}
        name="{{ $name ?? 'asset'}}" class="{{ $class ?? '' }}"
        {{ !empty($this->parentModel) ? "wire:model={$this->parentModel}" : '' }}
        {{ !empty($this->elementId) ? "id={$this->elementId}" : '' }}
        {{ !empty($this->xModel) ? "x-model={$this->xModel}" : '' }}
    >
    <option value="">Select</option>
    @foreach($data as $value)
    <option value="{{ $value->{$this->entityField} }}" data-dynamicoption="{{ $this->isDataAttribute ? json_encode($value->toArray()) : '' }}"
        {{
            (isset($entity_id) &&
            $entity_id == $value->{$this->entityField}) ||
            in_array($value->id, $entity_ids) || $this->selectedByDisplayName == $value->{$this->entityDisplayField} ? 'selected="selected"' : ''
        }}> {{ $value->{$this->entityDisplayField} }}
    </option>
    @endforeach
    </select>
</div>

@pushOnce('script')
<script src="{{ url('assets/js/selectr.min.js') }}" type="text/javascript"></script>
@endPushOnce
