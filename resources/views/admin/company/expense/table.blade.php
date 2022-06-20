<div>
    <x-livewire-loader></x-livewire-loader>

        <div class="grid md:grid-cols-3 grid-cols-1 gap-4 pt-5">
            <div class="form-group w-full">
                <x-label for="expense_id" class="form-label">Search Keyword</x-label>
                <input type="text" class="form-control w-full" wire:model="filter.global_search"
                    placeholder="Enter Expense ID/Asset ID/Work Order ID">
            </div>
            <div class="form-group w-full">
                <x-label for="type" class="form-label">Type</x-label>
                    <x-select  class="form-select w-full" id="type" wire:model="filter.type">
                        <option value="">Select Type</option>
                        <option value="employee-payment">Employee payment</option>
                        <option value="maintenance-material">Maintenance material</option>
                </x-select>
            </div>
            <div class="form-group w-full">
                <x-label for="description" class="form-label">Description</x-label>
                <input type="text" class="form-control w-full" wire:model="filter.description"
                    placeholder="Description">
            </div>
            <div>
                <x-label class="gray1 text-sm">Amount</x-label>
             <x-range-bar type='multi' minModel="filter.amount.min" maxModel="filter.amount.max" :range="$this->amount"
                :dynamicRange="$this->filter['amount']"></x-range-bar>
            </div>
            <div class="form-group">
                <x-label>Location</x-label>
                <livewire:dynamic-dropdown
                name="location"
                :where="[
                    ['name', '!=', ''],
                    ['company_id', '=', $companyId]
                ]"
               :entity="\App\Models\Admin\Asset\Location::class"
                entity-select-fields="DISTINCT name"
                :entity-search-fields="['name']"
                entity-field="name"
                entity-display-field="name"
                isDataAttribute="true"
                onChangeFunc="initManualFilter"
                >
            </div>
            @php
            $assigned = "concat(first_name, ' ', last_name)";
            @endphp
            <div class="form-group">
                <x-label for="assignee_employee">Assigned Employee</x-label>
                <livewire:dynamic-dropdown
                name="assigned"
                :where="[
                    ['company_id', '=', $companyId]
                ]"
                :entity="\App\Models\User::class"
                entity-select-fields="id, first_name, last_name"
                :entity-search-fields="[$assigned]"
                entity-field="id"
                entity-display-field="full_name"
                :entity_id="$this->filter['assigned'] ?? ''"
                isDataAttribute="true"
                onChangeFunc="initManualFilter"
                >
            </div>
        </div>
            <div class="flex justify-end items-center border-b mb-8 pb-5">
                <div class="form-group">
                    <x-button type="button" class="btn-secondary filter-btn" wire:click.prevent="filter()">
                        <em class="fa-solid fa-sliders"></em> Filter
                    </x-button>
                </div>
                <div class="form-group ml-4">
                    <x-nav-link href="javascript:;" wire:click.prevent="clear()">Clear All</x-nav-link>
                </div>
            </div>
        <div class="entries">
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
                    <th scope="col" class="id-width">
                        <a wire:click.prevent="sortBy('id')" role="button" href="#">
                            id
                            @include('components._sort-icon', ['field' => 'id'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('expense_date')" role="button" href="#">
                            Date
                            @include('components._sort-icon', ['field' => 'expense_date'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('type')" role="button" href="#">
                            Type
                            @include('components._sort-icon', ['field' => 'type'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('description')" role="button" href="#">
                            Description
                            @include('components._sort-icon', ['field' => 'description'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('amount')" role="button" href="#">
                            Amount
                            @include('components._sort-icon', ['field' => 'amount'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('work_order_id')" role="button" href="#">
                            Work Order Id
                            @include('components._sort-icon', ['field' => 'work_order_id'])
                        </a>
                    </th>
                    <th scope="col">
                            Asset Id
                    </th>
                    <th scope="col">
                        Location
                    </th>
                    <th scope="col" class="action">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $expense)
                <tr>
                    <td>{{ $expense->id }}</td>
                    <td>{{ $expense->expense_date ? customDateFormat($expense->expense_date) : ''  }}</td>
                    <td>{{ ucfirst(str_replace('-',' ',$expense->type)) }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ currency($expense->amount) }}</td>
                    <td>{{ $expense->workOrder->number }}</td>
                    <td>{{$expense->workOrder->asset?->number}}</td>
                    <td>{{$expense->workOrder->asset?->location?->name}}</td>
                    <td>
                        <div class="table-icons">
                            <x-nav-link title="View" href="javascript:;" wire:click="edit({{ json_encode(array_merge(['show' => true], $expense->toArray()), true) }})" data-bs-toggle="offcanvas" data-bs-target="#edit-assettype">
                                <em class="fa fa-eye" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link title="Edit" href="javascript:;" wire:click="edit({{ json_encode(array_merge(['edit' => true], $expense->toArray()), true) }})" data-bs-toggle="offcanvas" data-bs-target="#edit-assettype">
                                <em class="fa-solid fa-pen" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link title="Delete" href="javascript:;" wire:click.prevent="$emit('alert', {{$expense->id}})">
                                <em class="fa-solid fa-trash" aria-hidden="true"></em>
                            </x-nav-link>
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
    function initManualFilter(option, element) {
        window.livewire.emitTo('expense-table', 'manualFilter', element.getAttribute('name'), option.value);
    }
    window.addEventListener('edit-modal', event => {
        let expense = event.detail;
        let routeName = '{{ route("admin.companies.expenses.update", ["company" => ":company", "expense" => ":id"])}}'
        routeName = routeName.replace(':id', expense.id)
        routeName = routeName.replace(':company', "request()->route('company')")
        document.querySelector('#expense-patch-form').setAttribute('action', routeName)
        document.querySelector('#expense-patch-form')._x_dataStack[0].formData = expense
    })
</script>
@endpush
