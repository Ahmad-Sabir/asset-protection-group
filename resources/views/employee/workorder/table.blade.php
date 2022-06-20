<div>
    <x-livewire-loader></x-livewire-loader>
    <div class="main-wrapper">
        <div class="filters-wrapper">
            <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3">
                <div class="form-group">
                    <x-label>&nbsp;</x-label>
                    <x-button type="button" class="btn-outline-secondary" wire:click="dateFilter('current_month')" id="current_month">
                        View Work Order Of Current Month
                    </x-button>
                </div>
                <div class="form-group">
                    <x-label>Work Order Flag</x-label>
                    <div class="form-group">
                        <x-button type="button" class="btn-outline-secondary">
                        <label for="flag">
                            <x-input type="checkbox" id="flag" value="on" class="form-check-input hidden" wire:model="filter.flag"></x-input>
                                <em class="fa-bookmark {{isset($this->filter['flag']) && $this->filter['flag'] == 'on' ? 'fa-solid' : 'fa-regular'}}"></em>{{isset($this->filter['flag']) && $this->filter['flag'] == 'on' ? 'Bookmarked' : 'Bookmark'}}
                            </label>
                        </x-button>
                    </div>
                </div>
                <div class="form-group">
                    <x-label>&nbsp;</x-label>
                    <input type="text" class="form-control" wire:model="filter.global_search" id="global_search" placeholder="Search Work Order ID/Title">
                </div>
                <div class="form-group mt-3">
                    <label for="exampleFormControlInpu3" class="form-label">Work Order Status</label>
                    <select class="form-select" wire:model="filter.work_order_status">
                        @forelse(config('apg.employee_work_order_status') as $status)
                        <option value="{{$status}}">{{$status}}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="form-group mt-3">
                    <x-label for="location">Asset Type</x-label>
                    <livewire:dynamic-dropdown
                        name="asset_type"
                        :where="[
                            ['type', '=', config('apg.type.company')],
                            ['company_id', '!=', null],
                        ]"
                        :entity="\App\Models\Admin\Asset\AssetType::class"
                        entity-select-fields="id, name"
                        :entity-search-fields="['name']"
                        entity-field="name"
                        entity-display-field="name"
                        onChangeFunc="assetTypeFilter"
                        isDataAttribute="true"
                    >
                </div>
                <div class="form-group mt-3">
                    <x-label for="location">Location</x-label>
                    <livewire:dynamic-dropdown
                        name="location"
                        id="filterLocation"
                        :where="[
                            ['name', '!=', ''],
                            ['company_id', '!=', null],
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
                <div class="form-group work-order-calender-field">
                    <x-label for="due_date">Due Date</x-label>
                    <x-date-picker id="due_date" mode="range" wire:model="filter.range_due_date" autocomplete="off" data-input>
                    </x-date-picker>
                </div>
            </div>
        </div>
        <div class="filters-section mt-5">
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
    </div>
    <div class="main-wrapper">
        <div class="entries" style="display: flex; justify-content: space-between;">
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
                    @forelse ($data as $work_order)
                    <tr>
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
                                <x-nav-link href="{{ route('employee.work-orders.show', $work_order->id) }}">
                                    <em class="fa fa-eye" aria-hidden="true"></em>
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

    {{ $data->links() }}
</div>
<script>
function assetTypeFilter(option) {
    window.livewire.emitTo('work-order-table', 'manualFilter','asset_type', option.value);
}
function locationFilter(option) {
    window.livewire.emitTo('work-order-table', 'manualFilter','location', option.value);
}
var check1 = document.querySelector("#flag");
        check1.onchange = function() {
            if (this.checked) {
                document.querySelector(".fa-bookmark").classList.add('fa-solid');
                document.querySelector(".fa-bookmark").classList.remove('fa-regular');
            } else {
                document.querySelector(".fa-bookmark").classList.add('fa-regular');
                document.querySelector(".fa-bookmark").classList.remove('fa-solid');
            }
        }
</script>
