<div>
    <x-livewire-loader></x-livewire-loader>
    <div class="main-wrapper">
        <div class="filters-wrapper">
            <div class="grid grid-rows-2">
                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-4">
                    <div class="form-group mt-5">
                        <x-label></x-label>
                        <x-button type="button" class="btn-outline-secondary" wire:click="dateFilter('current_month')" id="current_month">
                            View Work Order Of Current Month
                        </x-button>
                    </div>
                    <div class="form-group mt-5">
                        <x-label></x-label>
                        <x-button type="button" class="btn-outline-secondary" wire:click="dateFilter('current_year')" id="current_year">
                            View Work Order Of Year To Date
                        </x-button>
                    </div>
                    <div class="form-group">
                        <x-label>Work Order Flag</x-label>
                        <div class="form-group">
                            <x-button type="button" class="btn-outline-secondary">
                            <x-label for="flag">
                                <x-input type="checkbox" id="flag" value="on" class="form-check-input hidden" wire:model="filter.flag"></x-input>
                                    <em class="fa-bookmark {{isset($this->filter['flag']) && $this->filter['flag'] == 'on' ? 'fa-solid' : 'fa-regular'}}"></em>{{isset($this->filter['flag']) && $this->filter['flag'] == 'on' ? 'Bookmarked' : 'Bookmark'}}
                            </x-label>
                            </x-button>
                        </div>
                    </div>
                </div>
                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-4">
                    <div class="form-group mt-8">
                        <input type="text" class="form-control" wire:model="filter.global_search" id="global_search" placeholder="Search Work Order ID/Title">
                    </div>
                    <div class="form-group mt-3 work-order-calender-field">
                        <x-label for="due_date">Due Date</x-label>
                        <x-date-picker id="due_date" mode="range" wire:model="filter.range_due_date" autocomplete="off" data-input>
                        </x-date-picker>
                    </div>
                </div>
                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-4">
                    <div class="form-group mt-3">
                        <label for="exampleFormControlInpu3" class="form-label">Work Order Status</label>
                        <select class="form-select" wire:model="filter.work_order_status">
                            @forelse(config('apg.work_order_status') as $status)
                            <option value="{{$status}}">{{$status}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <x-label for="location">Location</x-label>
                        <livewire:dynamic-dropdown
                            name="location"
                            id="filterLocation"
                            :where="[
                                ['name', '!=', ''],
                                ['company_id', '=', null],
                            ]"
                            entity="\App\Models\Admin\Asset\Location"
                            entity-select-fields="DISTINCT id, name"
                            :entity-search-fields="['name']"
                            entity-field="name"
                            entity-display-field="name"
                            isDataAttribute="true"
                            onChangeFunc="locationFilter"
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end items-center mt-5">
            <div class="form-group">
                <x-button type="button" class="btn-secondary filter-btn" wire:click.prevent="filter()">
                    <em class="fa-solid fa-sliders"></em> Filter
                </x-button>
            </div>
            <div class="form-group ml-3">
                <x-nav-link href="javascript:;" wire:click.prevent="clear()">Clear All</x-nav-link>
            </div>
        </div>
    </div>
    <div class="main-wrapper">
        <div class="entries flex md:flex-row flex-col justify-between items-center">
            <div class="form-group">
                <x-label class="text-b">Showing</x-label>
                <select class="form-select" aria-label="Default select example" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
                <span>entries</span>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInpu3" class="form-label">Work Order Bulk Update Status</label>
                <select class="form-select" onchange="handleStatus(event)">
                    <option selected disabled>Select Status</option>
                    @forelse(config('apg.work_order_status') as $status)
                    <option value="{{$status}}">{{$status}}</option>
                    @empty
                    @endforelse
                </select>
            </div>
        </div>
        <div class="table-border">
        <table class="admin-table" aria-label="">
            <thead>
                <tr>
                    <th scope="col">
                    <input type="checkbox" onchange="checkAll(this)">
                    </th>
                    <th scope="col" class="id-width">
                        <a wire:click.prevent="sortBy('number')" role="button" href="#">
                            id
                            @include('components._sort-icon', ['field' => 'number'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('title')" role="button" href="#">
                            Work Order
                            @include('components._sort-icon', ['field' => 'title'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('asset_id')" role="button" href="#">
                            Asset
                            @include('components._sort-icon', ['field' => 'asset_id'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('asset_type_id')" role="button" href="#">
                            Asset Type
                            @include('components._sort-icon', ['field' => 'asset_type_id'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('work_order_status')" role="button" href="#">
                            Status
                        @include('components._sort-icon', ['field' => 'work_order_status'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('work_order_type')" role="button" href="#">
                            Work Order Type
                            @include('components._sort-icon', ['field' => 'work_order_type'])
                        </a>
                    </th>
                    <th scope="col" class="date-width">
                        <a wire:click.prevent="sortBy('due_date')" role="button" href="#">
                            Due Date
                        @include('components._sort-icon', ['field' => 'due_date'])
                    </a>
                </th>
                <th scope="col">
                    <a wire:click.prevent="sortBy('assignee_user_id')" role="button" href="#">
                        Assigned To
                    @include('components._sort-icon', ['field' => 'assignee_user_id'])
                    </a>
                </th>
                <th scope="col" class="action">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $work_order)
                <tr>
                    <td>
                        <input type="checkbox" name="workOrderID" value="{{ $work_order->id }}">
                    </td>
                    <td>{{ $work_order->number }}</td>
                    <td>{{ $work_order->title }}</td>
                    <td>{{ $work_order->asset?->name}}</td>
                    <td>{{ $work_order->assetType?->name}}</td>
                    <td>{{ $work_order->work_order_status }}</td>
                    <td>{{ $work_order->work_order_type}}</td>
                    <td>{{ $work_order->due_date ? customDateFormat($work_order->due_date) : '' }}</td>
                    <td>{{ $work_order->user?->full_name}}</td>
                    <td>
                        <div class="table-icons">
                            <form method="post" action="{{ route('admin.work-orders.clone', $work_order->id) }}" x-data="submitForm()" @submit.prevent="onSubmitPost">
                                <button title="Clone" type="submit">
                                    <em class="fas fa-solid fa-clone" aria-hidden="true"></em>
                                </button>
                            </form>
                            <x-nav-link title="View" href="{{ route('admin.work-orders.show', $work_order->id) }}">
                                <em class="fa fa-eye" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link title="Edit" href="{{ route('admin.work-orders.edit', $work_order->id) }}">
                                <em class="fa-solid fa-pen" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link title="Delete" href="javascript:;" wire:click.prevent="$emit('alert', {{$work_order->id}})">
                                <em class="fa-solid fa-trash" aria-hidden="true"></em>
                            </x-nav-link>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center">No Record Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
    <a data-bs-toggle="modal" id="hold_modal" data-bs-target="#reason_hold"></a>
    <x-modal id="reason_hold">
        <div class="modal-header flex flex-shrink-0 items-center justify-center pb-0 rounded-t-md">
            <h5 class="text-xl text-center font-medium leading-normal text-gray-800 mt-5 pt-5" id="exampleModalScrollableLabel">
                On Hold Reason
            </h5>
        </div>
        <div class="modal-body flex justify-center relative p-4">
            <div class="form-group w-full">
                <x-textarea class="w-full" type="text" id="on_hold_reason"></x-textarea>
            </div>
        </div>
    </x-modal>
    {{ $data->links() }}
</div>
@include('custom-workorder-table-js')
