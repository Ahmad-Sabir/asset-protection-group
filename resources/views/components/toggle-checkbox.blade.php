<div class="form-check form-switch">
<input
type="checkbox"
name="{{ $name ?? '' }}"
id="{{ $id ?? Str::random(9) }}"
role="switch"
class='form-check-input appearance-none w-9 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm'
{{ $disabled ?? '' }}
{{ $checked ?? '' }}>
</div>
