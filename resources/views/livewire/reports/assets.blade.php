<div>
<x-livewire-loader></x-livewire-loader>
<div id="asset_report" x-data=customizeTable()>
    <div class="form-group flex md:flex-row flex-col justify-between items-center">
        <div class="form-group">
            <x-label>Saved Filters</x-label>
            <livewire:dynamic-dropdown name="filter_report" :where="[
                ['type', '=', config('apg.report_types.assets')],
            ]" :entity="\App\Models\FilterReport::class"
            entity-select-fields="id, name, filter"
            :entity-search-fields="['name']"
            entity-field="id"
            entity-display-field="name"
            isDataAttribute="true"
            onChangeFunc="initFilterReport">
        </div>
        <div>
            <x-button id="export-pdf" :isDisabled="false" @click="exportPdfReportAsset(field)" type="button" class="btn-primary mr-3">
                <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
            </x-button>
            <x-button id="export-csv" :isDisabled="false" @click="exportCsvReportAsset(field)" type="button" class="btn-outline-primary md:mt-0 mt-3">
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
            <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                <div class="form-group col-span-2 w-full">
                    <x-label>Search Keyword</x-label>
                    <x-input type="text" class="w-full" placeholder="Enter Asset ID/ Company ID/ Name/ ManuFacture/ Model Name" wire:model.defer="filter.global_search">
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
            </div>
            <div class="grid md:grid-cols-2 grid-cols-1 gap-4 advance-filter-calander">
                <div class="form-group">
                    <x-label>Installation Date</x-label>
                    <x-date-picker id="installation_date" mode="range" wire:model.defer="filter.range_installation_date" autocomplete="off" data-input>
                    </x-date-picker>
                </div>
                <div class="form-group">
                    <x-label>Creation Date</x-label>
                    <x-date-picker id="created_at" mode="range" wire:model.defer="filter.range_created_at" autocomplete="off" data-input>
                    </x-date-picker>
                </div>
            </div>
            <div class="grid md:grid-cols-3 grid-cols-1 gap-4 assets-range-bar">
                <div class="replacement-cost-bar">
                    <x-label class="gray1 text-sm">Replacement Cost</x-label>
                    <x-range-bar type='range' minModel="filter.cost.min" maxModel="filter.cost.max" :range="$this->range_cost_price" :dynamicRange="$this->filter['cost'] ?? []"></x-range-bar>
                </div>
                <div class="replacement-cost-bar">
                    <x-label class="gray1 text-sm">Purchase Price (Min - Max)</x-label>
                    <x-range-bar type='range' minModel="filter.purchase_price.min" maxModel="filter.purchase_price.max" :range="$this->range_purchase_price" :dynamicRange="$this->filter['purchase_price'] ?? []"></x-range-bar>
                </div>
                <div class="form-group w-full">
                    <x-label>Status</x-label>
                    <x-select class="w-full" wire:model="filter.status">
                        <option value=""> Select </option>
                        <option value="1">Active</option>
                        <option value="0">In Active</option>
                    </x-select>
                </div>
                <div>
                    <x-label class="gray1 text-sm">Remaining Useful Life</x-label>
                    <div class="form-group flex">
                        <x-input type="number" class="w-full mr-2" placeholder="Year" wire:model.defer="filter.remaining_useful_life.year"></x-input>
                        <x-input type="number" class="w-full mr-2" placeholder="Month" wire:model.defer="filter.remaining_useful_life.month"></x-input>
                        <x-input type="number" class="w-full" placeholder="Day" wire:model.defer="filter.remaining_useful_life.day"></x-input>
                    </div>
                </div>
                <div>
                    <x-label class="gray1 text-sm">Total Useful Life</x-label>
                    <div class="form-group flex">
                        <x-input type="number" class="w-full mr-2" placeholder="Year" wire:model.defer="filter.total_useful_life.year"></x-input>
                        <x-input type="number" class="w-full mr-2" placeholder="Month" wire:model.defer="filter.total_useful_life.month"></x-input>
                        <x-input type="number" class="w-full" placeholder="Day" wire:model.defer="filter.total_useful_life.day"></x-input>
                    </div>
                </div>
                <div>
                    <x-label class="gray1 text-sm">Remaining Warranty</x-label>
                    <div class="form-group flex">
                        <x-input type="number" class="w-full mr-2" placeholder="Year" wire:model.defer="filter.warranty.year"></x-input>
                        <x-input type="number" class="w-full mr-2" placeholder="Month" wire:model.defer="filter.warranty.month"></x-input>
                        <x-input type="number" class="w-full" placeholder="Day" wire:model.defer="filter.warranty.day"></x-input>
                    </div>
                </div>
            </div>
            <div class="flex md:flex-row flex-col justify-between items-center gap-4">
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
                <div class="flex md:flex-row flex-col justify-end items-center w-full gap-4">
                    <div class="form-group">
                        <x-button :isDisabled="false" class="btn-secondary" @click="filter(field)"><em class="fa-solid fa-sliders"></em> FILTER</x-button>
                    </div>
                    <div class="form-group">
                        <x-button :isDisabled="false" class="btn-outline-primary" id="save_filter" data-bs-toggle="modal" data-bs-target="#save-filter"><em class="fa-solid fa-floppy-disk"></em>SAVE FILTER</x-button>
                    </div>
                    <x-nav-link href="javascript:;" wire:click.prevent="clear()">Clear All</x-nav-link>
                </div>
            </div>
        </div>
        <div x-show="!advance_filter">
            <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                <div>
                    <div class="form-group">
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
                </div>
                <div>
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
                </div>
                <div>
                    <x-label class="gray1 text-sm">Remaining Useful Life</x-label>
                    <div class="form-group grid grid-cols-3 gap-2">
                        <x-input type="number" class="w-full mr-2" placeholder="Year" wire:model.defer="filter.remaining_useful_life.year"></x-input>
                        <x-input type="number" class="w-full mr-2" placeholder="Month" wire:model.defer="filter.remaining_useful_life.month"></x-input>
                        <x-input type="number" class="w-full" placeholder="Day" wire:model.defer="filter.remaining_useful_life.day"></x-input>
                    </div>
                </div>
            </div>
            <div class="flex justify-end items-center gap-4 w-full mt-2">
                <div class="form-group">
                    <x-button :isDisabled="false" class="btn-secondary" @click="filter(field)" ><em class="fa-solid fa-sliders"></em> FILTER</x-button>
                </div>
                <x-nav-link class="md:w-auto w-full" href="javascript:;" wire:click.prevent="clear()">Clear All</x-nav-link>
            </div>
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
        <div class="flex md:flex-row flex-col items-center justify-between mb-2">
            <div class="form-group md:order-1 order-2">
                <span>Showing</span>
                <select class="form-select" aria-label="Default select example" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
                <span>entries</span>
            </div>
            <div class="popover-box md:w-auto w-full ml-2 mb-5 md:order-2 order-1">
                <x-button :isDisabled="false" id="popover-btn" type="button" class="btn-outline-primary" @click="popover_active=!popover_active">
                    <em class="fa-solid fa-sliders"></em>
                    Customize Table
                </x-button>
                <div class="popover-content customize-table" :class="popover_active ? 'popover-active' : '' ">
                    <div class="text-left">
                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.id" @change="field.id=!field.id">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">ID</label>
                        </div>
                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.company_id" @change="field.company_id=!field.company_id">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Company ID</label>
                        </div>
                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.installation_date" @change="field.installation_date=!field.installation_date">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Installation Date</label>
                        </div>
                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.name" @change="field.name=!field.name">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Name</label>
                        </div>
                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.manufacturer" @change="field.manufacturer=!field.manufacturer">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Manufacture</label>
                        </div>
                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.model" @change="field.model=!field.model">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Model</label>
                        </div>
                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.asset_type" @change="field.asset_type=!field.asset_type">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Asset Type</label>
                        </div>

                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.status" @change="field.status=!field.status">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Status</label>
                        </div>

                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.location_id" @change="field.location_id=!field.location_id">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Location</label>
                        </div>


                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.replacement_cost" @change="field.replacement_cost=!field.replacement_cost">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Replacement cost</label>
                        </div>


                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.purchase_price" @change="field.purchase_price=!field.purchase_price">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Purchase price</label>
                        </div>


                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.total_useful_life" @change="field.total_useful_life=!field.total_useful_life">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Total useful life</label>
                        </div>


                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.remaining_useful_life" @change="field.remaining_useful_life=!field.remaining_useful_life">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Remaining useful life</label>
                        </div>


                        <div class="form-check">
                            <x-input class="form-check-input" type="checkbox" ::checked="field.warranty_expiry_date" @change="field.warranty_expiry_date=!field.warranty_expiry_date">
                            </x-input>
                            <label class="form-check-label" for="flexCheckDefault">Remaining Warranty</label>
                        </div>


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
                        <th scope="col" class="id-width" x-show="field.company_id">
                            <a wire:click.prevent="sortBy('company_number')" role="button" href="#">
                                Company Id
                                @include('components._sort-icon', ['field' => 'company_number'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.name">
                            <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                Name
                                @include('components._sort-icon', ['field' => 'name'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.manufacturer">
                            <a wire:click.prevent="sortBy('manufacturer')" role="button" href="#">
                                Manufacture
                                @include('components._sort-icon', ['field' => 'manufacturer'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.model">
                            <a wire:click.prevent="sortBy('model')" role="button" href="#">
                                Model name
                                @include('components._sort-icon', ['field' => 'model'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.asset_type">
                            <a role="button" href="#">
                                Asset Type
                            </a>
                        </th>
                        <th scope="col" x-show="field.status">
                            <a wire:click.prevent="sortBy('status')" role="button" href="#">
                                Status
                                @include('components._sort-icon', ['field' => 'status'])
                            </a>
                        </th>
                        <th scope="col" class="date-width" x-show="field.installation_date">
                            <a wire:click.prevent="sortBy('installation_date')" role="button" href="#">
                                Installation Date
                                @include('components._sort-icon', ['field' => 'installation_date'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.location_id">
                            <a wire:click.prevent="sortBy('location_id')" role="button" href="#">
                                Location
                                @include('components._sort-icon', ['field' => 'location_id'])
                            </a>
                        </th>
                        <th scope="col" class="date-width" x-show="field.replacement_cost">
                            <a wire:click.prevent="sortBy('replacement_cost')" role="button" href="#">
                                Replacement cost
                                @include('components._sort-icon', ['field' => 'replacement_cost'])
                            </a>
                        </th>
                        <th scope="col" class="date-width" x-show="field.purchase_price">
                            <a wire:click.prevent="sortBy('purchase_price')" role="button" href="#">
                                Purchase price
                                @include('components._sort-icon', ['field' => 'purchase_price'])
                            </a>
                        </th>
                        <th scope="col" class="date-width" x-show="field.total_useful_life">
                            <a role="button" href="#">
                                Total Useful Life
                            </a>
                        </th>
                        <th scope="col" class="date-width" x-show="field.remaining_useful_life">
                            <a role="button" href="#">
                                Remaining useful life
                            </a>
                        </th>
                        <th scope="col" class="date-width" x-show="field.warranty_expiry_date">
                            <a role="button" href="#">
                                Remaining Warranty
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($assets as $key => $asset)
                    <tr>
                        <td x-show="field.id">{{ $asset->number }}</td>
                        <td x-show="field.company_id">{{ $asset->company_number }}</td>
                        <td x-show="field.name">{{ $asset->name }}</td>
                        <td x-show="field.manufacturer">{{ $asset->manufacturer }}</td>
                        <td x-show="field.model">{{ $asset->model }}</td>
                        <td x-show="field.asset_type">{{ $asset->assetType?->name }}</td>
                        <td x-show="field.status" class="{{ $asset->status ? 's-active' : 's-inactive' }}">
                            {{ $asset->status ? 'Active' : 'Inactive' }}
                        </td>
                        <td x-show="field.installation_date">{{ $asset->installation_date ? customDateFormat($asset->installation_date) : '' }}</td>
                        <td x-show="field.location_id">{{ $asset->location?->name }}</td>
                        <td x-show="field.replacement_cost">{{ currency($asset->replacement_cost) }}</td>
                        <td x-show="field.purchase_price">{{ currency($asset->purchase_price) }}</td>
                        <td x-show="field.total_useful_life">
                            {{ !empty($asset->total_useful_life) ? totalUseFulLife($asset->total_useful_life) : '' }}
                        </td>
                        <td x-show="field.remaining_useful_life">
                            {{ !empty($asset->total_useful_life_date) ? remainingDays($asset->total_useful_life_date) : '' }}
                        </td>
                        <td x-show="field.warranty_expiry_date">
                            {{ remainingWarrantyDays($asset->installation_date, $asset->warranty_expiry_date) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="15" class="text-center">No Record Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $assets->links() }}
        </div>
    </div>
    <x-modal id="save-filter">
        <form wire:submit.prevent="saveFilter">
            <div class="modal-header flex flex-shrink-0 items-center justify-center pb-0 rounded-t-md">
                <h5 class="text-xl text-center font-medium leading-normal text-gray-800 mt-5 pt-5" id="exampleModalScrollableLabel">
                    Filter Name
                </h5>
            </div>
            <div class="modal-body flex justify-center relative p-4">
                <div>
                    <div class="form-group">
                        <x-input class="form-control modal-input" type="text" wire:model.defer="filterName"></x-input>
                        @error('filterName') <span class="invalid mt-2 text-center">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center pt-0 rounded-b-md mb-5 pb-5">
                <x-button :isDisabled="false" type="submit" class="btn-primary uppercase" data-bs-dismiss="modal"><em class="fa-solid fa-check"></em> Save</x-button>
                <x-button :isDisabled="false" type="button" class="btn-gray uppercase ml-2" data-bs-dismiss="modal"><em class="fa-solid fa-sliders"></em> Cancel</x-button>
            </div>
        </form>
    </x-modal>
    <script>
        function customizeTable() {
            return {
                popover_active : false,
                field: @json($customizeField)
            }
        }

        function initFilterReport(option) {
            if (option.value) {
                let filters = JSON.parse(option.dataset.dynamicoption);
                window.livewire.emitTo('reports.assets', 'customizeFilter', filters);
                document.getElementById("advance_filter").click();
            }
        }
        function initManualFilter(option, element) {
            window.livewire.emitTo('reports.assets', 'manualFilter', element.getAttribute('name'), option.value);
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
        function exportPdfReportAsset(field) {
            window.livewire.emitTo('reports.assets', 'exportPdfReportAsset', field, 'pdf');
            document.getElementById("export-pdf").disabled = true;
        }
        function exportCsvReportAsset(field) {
            window.livewire.emitTo('reports.assets', 'exportCsvReportAsset', field, 'csv');
            document.getElementById("export-csv").disabled = true;
        }
        function filter(field) {
            window.livewire.emitTo('reports.assets', 'filter', field);
        }

    </script>
</div>
