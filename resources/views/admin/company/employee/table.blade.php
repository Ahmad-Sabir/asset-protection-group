<div>
    <x-livewire-loader></x-livewire-loader>
        <div class="filters-section border-b py-5">
            <div class="form-group">
                <x-label for="used_id" class="form-label">ID/NAME</x-label>
                <x-input type="text" id="used_id" wire:model="filter.global_search" placeholder="Enter ID/Name"></x-input>
            </div>
            <div class="replacement-cost-bar mx-2">
            <x-label class="gray1 text-sm">Pay Rate</x-label>
            <x-range-bar type='multi' minModel="filter.payrate.min" maxModel="filter.payrate.max" :range="$this->payrate"
                :dynamicRange="$this->filter['payrate']"></x-range-bar>
            </div>
            <div class="filter-btns">
                <div class="form-group">
                    <x-button type="button" class="btn-secondary filter-btn" wire:click.prevent="filter()">
                        <em class="fa-solid fa-sliders"></em> Filter
                    </x-button>
                </div>
                <div class="form-group">
                    <x-nav-link href="javascript:;" wire:click.prevent="clear()">Clear All</x-nav-link>
                </div>
            </div>
        </div>
        <div class="entries mt-5">
            <div class="form-group">
                <x-label class="text-b">Showing</x-label>
                <select class="form-select" aria-label="Default select example" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
                <span>entries</span>
            </div>
        </div>
        <div class="table-border">
        <table class="admin-table" aria-label="">
            <thead>
                <tr>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('id')" role="button" href="#">
                            id
                            @include('components._sort-icon', ['field' => 'id'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('first_name')" role="button" href="#">
                            Name
                            @include('components._sort-icon', ['field' => 'first_name'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('per_hour_rate')" role="button" href="#">
                            Pay rate
                            @include('components._sort-icon', ['field' => 'per_hour_rate'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('deactivate_at')" role="button" href="#">
                            Status
                            @include('components._sort-icon', ['field' => 'deactivate_at'])
                        </a>
                    </th>
                    <th scope="col" class="action">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->first_name }} {{ $employee->last_name}}</td>
                    <td>{{ !is_null($employee->per_hour_rate) ? currency($employee->per_hour_rate).'/hr' : '' }}</td>
                    <td @class([ 's-active'=> is_null($employee->deactivate_at),
                        's-inactive' => !is_null($employee->deactivate_at),
                        ])>
                        {{ is_null($employee->deactivate_at) ? 'Active' : 'Inactive' }}
                    </td>
                    <td>
                        <div class="table-icons">
                            <x-nav-link title="View" href="javascript:;" wire:click="edit({{ json_encode(array_merge(['show' => true], $employee->toArray()), true) }})" data-bs-toggle="offcanvas" data-bs-target="#edit-employee">
                                <em class="fa fa-eye" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link title="Edit" href="javascript:;" wire:click="edit({{ json_encode(array_merge(['edit' => true], $employee->toArray()), true) }})" data-bs-toggle="offcanvas" data-bs-target="#edit-employee">
                                <em class="fa-solid fa-pen" aria-hidden="true"></em>
                            </x-nav-link>
                            @if (auth()->id() != $employee->id)
                            <x-nav-link title="Delete" href="javascript:;" wire:click.prevent="$emit('alert', {{$employee->id}})">
                                <em class="fa-solid fa-trash" aria-hidden="true"></em>
                            </x-nav-link>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No Record Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    {{ $data->links() }}
</div>

@push('script')
<script>
    window.addEventListener('edit-modal', event => {
        let employee = event.detail;
        let routeName = '{{ route("admin.companies.users.update", ["company" => ":company", "user" => ":id"]) }}'
        routeName = routeName.replace(':id', employee.id)
        routeName = routeName.replace(':company', "{{request()->route('company')}}")
        document.querySelector('#employee-patch-form').setAttribute('action', routeName)
        document.querySelector('#employee-patch-form')._x_dataStack[0].formData = employee
        if (employee.profile_media_id) {
            document.getElementById('avatar-edit_media_id').children[0].setAttribute('src', employee.profile.url);
            document.getElementById('edit_media_id').value = employee.profile_media_id;
        }
    });
</script>
@endpush
