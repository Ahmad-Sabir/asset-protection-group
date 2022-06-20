<div>
    <x-livewire-loader></x-livewire-loader>
    <div x-data=customizeTable()>
    <div class="flex md:flex-row flex-col justify-between items-center mb-4">
        <div class="form-group">
            <x-label>Saved Filters</x-label>
            <livewire:dynamic-dropdown name="filter_report" :where="[
                ['type', '=', config('apg.report_types.work_orders')],
            ]" :entity="\App\Models\FilterReport::class" entity-select-fields="id, name, filter" :entity-search-fields="['name']" entity-field="id" entity-display-field="name" isDataAttribute="true" onChangeFunc="initFilterReport">
        </div>
        <div>
            <x-button id="export-pdf" :isDisabled="false" @click="exportPdfReportWorkOrder(field)" type="button" class="btn-primary mr-3">
                <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
            </x-button>
            <x-button id="export-csv" :isDisabled="false" @click="exportCsvReportWorkOrder(field)" type="button" class="btn-outline-primary md:mt-0 mt-3">
                <em class="fa-solid fa-cloud-arrow-down"></em> Download CSV
        </x-button>
        </div>
    </div>
    <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
        <div class="form-group">
            <x-label>Company</x-label>
            <livewire:dynamic-dropdown
            name="company_id"
            :entity="\App\Models\Company::class"
            entity-select-fields="id, name"
            :entity-search-fields="['name']"
            entity-field="id"
            entity-display-field="name"
            :entity_id="$this->filter['company_id'] ?? ''"
            isDataAttribute="true"
            onChangeFunc="initManualFilter">
        </div>
    </div>
    <div class="advance-filters" x-data="{advance_filter:false, isLoading:false}">
        <div x-show="advance_filter" x-transition:enter.duration.600ms x-transition:leave.duration.500ms>
            <div class="grid md:grid-rows-2 grid-rows-1">
                <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                    <div class="form-group">
                        <x-label>ID/Title</x-label>
                        <x-input type="text" class="w-full" wire:model.defer="filter.global_search" placeholder="Search Work Order ID/Title">
                        </x-input>
                    </div>
                    <div class="form-group w-full">
                        <x-label>Asset Type</x-label>
                        <livewire:dynamic-dropdown
                        name="asset_type"
                        :where="[
                            ['type', '=', config('apg.type.company')]
                        ]"
                        whereNotNull="company_id"
                        :entity="\App\Models\Admin\Asset\AssetType::class"
                        entity-select-fields="DISTINCT name"
                        :entity-search-fields="['name']"
                        entity-field="name"
                        entity-display-field="name"
                        :entity_id="$this->filter['asset_type'] ?? ''"
                        isDataAttribute="true"
                        onChangeFunc="initManualFilter"
                        >
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInpu3" class="form-label">Work Order Status</label>
                        <x-select class="w-full" wire:model="filter.work_order_status">
                            <option value="">Select</option>
                            @foreach(config('apg.work_order_status') as $status)
                            <option value="{{$status}}">{{$status}}</option>
                            @endforeach
                        </x-select>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                    <div class="form-group">
                        <label for="exampleFormControlInpu3" class="form-label">Work Order Type</label>
                        <x-select class="w-full" wire:model="filter.work_order_type">
                            <option value="">Select</option>
                            @foreach(config('apg.work_order_type') as $work_order_type)
                                <option value="{{$work_order_type}}">{{$work_order_type}}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="form-group">
                        <x-label>Location</x-label>
                        <livewire:dynamic-dropdown
                        name="location"
                        :where="[
                            ['name', '!=', '']
                        ]"
                        whereNotNull="company_id"
                        :entity="\App\Models\Admin\Asset\Location::class"
                        entity-select-fields="DISTINCT name"
                        :entity-search-fields="['name']"
                        entity-field="name"
                        entity-display-field="name"
                        :entity_id="$this->filter['location'] ?? ''"
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
                <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                    <div class="form-group">
                        <x-label for="created_on">Due Date</x-label>
                        <x-date-picker mode="range" wire:model.defer="filter.due_date" autocomplete="off" data-input></x-date-picker>
                    </div>
                    <div class="form-group">
                        <x-label for="updated_at">Last Update</x-label>
                        <x-date-picker mode="range" wire:model.defer="filter.updated_at" autocomplete="off" data-input></x-date-picker>
                    </div>
                </div>
            </div>
        </div>
        <div x-show="!advance_filter" x-transition:enter.duration.600ms x-transition:leave.duration.500ms>
            <div class="grid md:grid-rows-2 grid-rows-1">
                <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                    <div class="form-group">
                        <x-label>ID/Title</x-label>
                        <x-input type="text" class="w-full" wire:model.defer="filter.global_search" placeholder="Search Work Order ID/Title">
                        </x-input>
                    </div>
                    <div class="form-group w-full">
                        <x-label>Asset Type</x-label>
                        <livewire:dynamic-dropdown
                        name="asset_type"
                        :where="[
                            ['type', '=', config('apg.type.company')]
                        ]"
                        whereNotNull="company_id"
                        :entity="\App\Models\Admin\Asset\AssetType::class"
                        entity-select-fields="DISTINCT name"
                        :entity-search-fields="['name']"
                        entity-field="name"
                        entity-display-field="name"
                        :entity_id="$this->filter['asset_type'] ?? ''"
                        isDataAttribute="true"
                        onChangeFunc="initManualFilter"
                        >
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInpu3" class="form-label">Work Order Status</label>
                        <x-select class="w-full" wire:model="filter.work_order_status">
                                <option value="">Select</option>
                                @foreach(config('apg.work_order_status') as $status)
                                    <option value="{{$status}}">{{$status}}</option>
                                @endforeach
                        </x-select>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                    @php
                        $assigned = "concat(first_name, ' ', last_name)";
                    @endphp
                    <div class="form-group">
                        <x-label for="assignee_employee">Assigned Employee</x-label>
                        <livewire:dynamic-dropdown
                        name="assigned"
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
                    <div class="form-group">
                        <x-label for="created_on">Due Date</x-label>
                        <x-date-picker mode="range" wire:model.defer="filter.due_date" autocomplete="off" data-input></x-date-picker>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex md:flex-row flex-col justify-end items-center mt-6">
            <div class="form-group">
                <x-button :isDisabled="false" class="btn-secondary" @click="filter(field)"><em class="fa-solid fa-sliders"></em> FILTER</x-button>
            </div>
            <div class="form-group md:ml-3 ml-0">
                <x-button :isDisabled="false" class="btn-outline-primary" id="save_filter" data-bs-toggle="modal" data-bs-target="#save-filter"><em class="fa-solid fa-floppy-disk"></em>SAVE FILTER</x-button>
            </div>
            <x-nav-link class="md:ml-3 ml-0" href="javascript:;" wire:click.prevent="clear()">Clear All</x-nav-link>
        </div>
        <div class="flex justify-center my-6 border-t">
            <x-button :isDisabled="false" class="more-text-btn" @click="advance_filter=!advance_filter">
                <span x-show="!advance_filter">Advanced Filter</span>
                <span x-show="advance_filter">Basic Filter</span>
            </x-button>
            <x-button :isDisabled="false" class="hidden" @click="advance_filter=true" id="advance_filter">Advanced Filter</x-button>
        </div>
    </div>
    <div>
        <div class="flex md:flex-row flex-col justify-between">
            <div class="form-group md:order-1 order-2">
                <span>Showing</span>
                <select class="form-select" aria-label="Default select example" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
                <span>entries</span>
            </div>
            <div class="popover-box ml-2 md:order-2 order-1 md:mb-0 mb-5">
                <x-button :isDisabled="false" type="button" class="btn-outline-primary" @click="popover_active=!popover_active"><em class="fa-solid fa-sliders"></em>Customize Table</x-button>
                <div class="popover-content customize-table" :class="popover_active ? 'popover-active' : '' ">
                    <div class="form-check flex items-center">
                        <x-input class="form-check-input" type="checkbox" ::checked="field.id" @change="field.id=!field.id">
                        </x-input>
                        <label class="form-check-label" for="flexCheckDefault">ID</label>
                    </div>
                    <div class="form-check flex items-center">
                        <x-input class="form-check-input" type="checkbox" ::checked="field.title" @change="field.title=!field.title">
                        </x-input>
                        <label class="form-check-label" for="flexCheckDefault">Work Order</label>
                    </div>
                    <div class="form-check flex items-center">
                        <x-input class="form-check-input" type="checkbox" ::checked="field.asset_id" @change="field.asset_id=!field.asset_id">
                        </x-input>
                        <label class="form-check-label" for="flexCheckDefault">Asset</label>
                    </div>
                    <div class="form-check flex items-center">
                        <x-input class="form-check-input" type="checkbox" ::checked="field.asset_type_id" @change="field.asset_type_id=!field.asset_type_id">
                        </x-input>
                        <label class="form-check-label" for="flexCheckDefault">Asset Type</label>
                    </div>
                    <div class="form-check flex items-center">
                        <x-input class="form-check-input" type="checkbox" ::checked="field.assignee_user_id" @change="field.assignee_user_id=!field.assignee_user_id">
                        </x-input>
                        <label class="form-check-label" for="flexCheckDefault">Assigned To</label>
                    </div>
                    <div class="form-check flex items-center">
                        <x-input class="form-check-input" type="checkbox" ::checked="field.work_order_status" @change="field.work_order_status=!field.work_order_status">
                        </x-input>
                        <label class="form-check-label" for="flexCheckDefault">Status</label>
                    </div>
                    <div class="form-check flex items-center">
                        <x-input class="form-check-input" type="checkbox" ::checked="field.due_date" @change="field.due_date=!field.due_date">
                        </x-input>
                        <label class="form-check-label" for="flexCheckDefault">Due Date</label>
                    </div>
                    <div class="form-check flex items-center">
                        <x-input class="form-check-input" type="checkbox" ::checked="field.work_order_type" @change="field.work_order_type=!field.work_order_type">
                        </x-input>
                        <label class="form-check-label" for="flexCheckDefault">Work Order Type</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-border">
            <table class="admin-table" aria-label="">
                <thead>
                    <tr>
                        <th scope="col" class="id-width" x-show="field.id">
                            <a wire:click.prevent="sortBy('number')" role="button" href="#">
                                id
                                @include('components._sort-icon', ['field' => 'number'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.title">
                            <a wire:click.prevent="sortBy('title')" role="button" href="#">
                                Work Order
                                @include('components._sort-icon', ['field' => 'title'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.asset_id">
                            <a wire:click.prevent="sortBy('asset_id')" role="button" href="#">
                                Asset
                                @include('components._sort-icon', ['field' => 'asset_id'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.asset_type_id">
                            <a wire:click.prevent="sortBy('asset_type_id')" role="button" href="#">
                                Asset Type
                                @include('components._sort-icon', ['field' => 'asset_type_id'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.assignee_user_id">
                            <a wire:click.prevent="sortBy('assignee_user_id')" role="button" href="#">
                                Assigned To
                                @include('components._sort-icon', ['field' => 'assignee_user_id'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.work_order_status">
                            <a wire:click.prevent="sortBy('work_order_status')" role="button" href="#">
                                Status
                                @include('components._sort-icon', ['field' => 'work_order_status'])
                            </a>
                        </th>
                        <th scope="col" class="date-width" x-show="field.due_date">
                            <a wire:click.prevent="sortBy('due_date')" role="button" href="#">
                                Due Date
                                @include('components._sort-icon', ['field' => 'due_date'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.work_order_type">
                            <a wire:click.prevent="sortBy('work_order_type')" role="button" href="#">
                                Work Order Type
                                @include('components._sort-icon', ['field' => 'work_order_type'])
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($workOrders as $workOrder)
                    <tr>
                        <td x-show="field.id">{{ $workOrder->number }}</td>
                        <td x-show="field.title">{{ $workOrder->title }}</td>
                        <td x-show="field.asset_id">{{ $workOrder->asset?->name}}</td>
                        <td x-show="field.asset_type_id">{{ $workOrder->assetType?->name}}</td>
                        <td x-show="field.assignee_user_id">{{ $workOrder->user?->full_name}}</td>
                        <td x-show="field.work_order_status">
                            <span class="{{ config('apg.work_order_status_color.' . $workOrder->work_order_status) }}">
                                {{ $workOrder->work_order_status }}
                            </span>
                        </td>
                        <td x-show="field.due_date">{{ $workOrder->due_date ? customDateFormat($workOrder->due_date) : '' }}</td>
                        <td x-show="field.work_order_type">{{ $workOrder->work_order_type}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No Record Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $workOrders->links() }}
    </div>
    <x-modal id="save-filter">
        <form wire:submit.prevent="saveFilter">
            <div class="modal-header flex flex-shrink-0 items-center justify-center p-4 border-b border-gray-200 rounded-t-md">
                <h5 class="text-xl text-center font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                    Filter Name
                </h5>
            </div>
            <div class="modal-body flex justify-center relative p-4">
                <div>
                    <div class="form-group">
                        <x-input class="form-control " type="text" wire:model.defer="filterName"></x-input>
                        @error('filterName') <span class="invalid mt-2 text-center">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center p-4 border-t border-gray-200 rounded-b-md">
                <x-button :isDisabled="false" type="submit" class="btn-primary uppercase" data-bs-dismiss="modal"><em class="fa-solid fa-check"></em> Save</x-button>
                <x-button :isDisabled="false" type="button" class="btn-gray uppercase ml-2" data-bs-dismiss="modal"><em class="fa-solid fa-sliders"></em> Cancel</x-button>
            </div>
        </form>
    </x-modal>
    <script>
        function customizeTable() {
            return {
                popover_active:false,
                field: @json($customizeField)
            }
        }

        function initFilterReport(option) {
            if (option.value) {
                let filters = JSON.parse(option.dataset.dynamicoption);
                window.livewire.emitTo('reports.work-orders', 'customizeFilter', filters);
            }
        }
        function initManualFilter(option, element) {
            window.livewire.emitTo('reports.work-orders', 'manualFilter', element.getAttribute('name'), option.value);
        }
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.hook('message.received', (el, component) => {
                if (component.serverMemo.data.isClear) {
                    window.location.reload();
                }
                if (Array.isArray(component.serverMemo.errors.filterName)) {
                    setTimeout(() => {
                        document.getElementById("save_filter").click();
                    }, 300);
                }
            });
        });
        function exportPdfReportWorkOrder(field) {
            window.livewire.emitTo('reports.work-orders', 'exportPdfReportWorkOrder', field, 'pdf');
            document.getElementById("export-pdf").disabled = true;
        }
        function exportCsvReportWorkOrder(field) {
            window.livewire.emitTo('reports.work-orders', 'exportCsvReportWorkOrder', field, 'csv');
            document.getElementById("export-csv").disabled = true;
        }
        function filter(field) {
            window.livewire.emitTo('reports.work-orders', 'filter', field);
        }
    </script>
</div>
</div>
