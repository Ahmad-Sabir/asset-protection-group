<div>
    <x-livewire-loader></x-livewire-loader>
    <div class="main-wrapper">
        <div class="advance-filters" x-data="{advance_filter:false, isLoading:false}">
            <div x-show="advance_filter" x-transition:enter.duration.600ms x-transition:leave.duration.500ms>
                <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                    <div class="form-group col-span-2 w-full">
                        <x-label>Search Keyword</x-label>
                        <x-input type="text" class="w-full" placeholder="Enter Asset ID/ Name/ ManuFacture/ Model Name" wire:model.defer="filter.global_search">
                        </x-input>
                    </div>
                    <div class="form-group w-full">
                        <x-label>Asset Type</x-label>
                        <livewire:dynamic-dropdown
                        name="asset_type"
                        :where="[
                            ['type', '=', config('apg.type.master')],
                            ['company_id', '=', $companyId],
                        ]"
                        :entity="\App\Models\Admin\Asset\AssetType::class"
                        entity-select-fields="DISTINCT name"
                        :entity-search-fields="['name']"
                        entity-field="name"
                        entity-display-field="name"
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
                        whereNull="company_id"
                    :entity="\App\Models\Admin\Asset\Location::class"
                        entity-select-fields="DISTINCT name"
                        :entity-search-fields="['name']"
                        entity-field="name"
                        entity-display-field="name"
                        isDataAttribute="true"
                        onChangeFunc="initManualFilter"
                        >
                    </div>
                    <div class="flex justify-end items-center w-full gap-4">
                        <div class="form-group">
                            <x-button :isDisabled="false" class="btn-secondary" wire:click.prevent="filter()"><em class="fa-solid fa-sliders"></em> FILTER</x-button>
                        </div>
                        <x-nav-link class="w-full md:w-auto" href="javascript:;" wire:click.prevent="clear()">Clear All</x-nav-link>
                    </div>
                </div>
            </div>
            <div x-show="!advance_filter">
                <div class="grid md:grid-cols-3 grid-cols-1 gap-2">
                    <div>
                        <div class="form-group">
                            <x-label>Asset Type</x-label>
                            <livewire:dynamic-dropdown
                            name="asset_type"
                            :where="[
                                ['type', '=', config('apg.type.master')],
                                ['company_id', '=', $companyId],
                            ]"
                            :entity="\App\Models\Admin\Asset\AssetType::class"
                            entity-select-fields="DISTINCT name"
                            :entity-search-fields="['name']"
                            entity-field="name"
                            entity-display-field="name"
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
                                whereNull="company_id"
                                :entity="\App\Models\Admin\Asset\Location::class"
                                entity-select-fields="DISTINCT name"
                                :entity-search-fields="['name']"
                                entity-field="name"
                                entity-display-field="name"
                                isDataAttribute="true"
                                onChangeFunc="initManualFilter"
                            >
                        </div>
                    </div>
                    <div>
                        <x-label class="gray1 text-sm">Remaining Useful Life</x-label>
                        <div class="form-group grid grid-cols-3 gap-2">
                            <x-input type="number" class="w-full" placeholder="Year" wire:model.defer="filter.remaining_useful_life.year"></x-input>
                            <x-input type="number" class="w-full" placeholder="Month" wire:model.defer="filter.remaining_useful_life.month"></x-input>
                            <x-input type="number" class="w-full" placeholder="Day" wire:model.defer="filter.remaining_useful_life.day"></x-input>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end items-center gap-4 w-full">
                    <div class="form-group">
                        <x-button :isDisabled="false" class="btn-secondary" wire:click.prevent="filter()"><em class="fa-solid fa-sliders"></em> FILTER</x-button>
                    </div>
                    <x-nav-link class="md:w-auto w-full" href="javascript:;" wire:click.prevent="clear()">Clear All</x-nav-link>
                </div>
            </div>
            <div class="flex justify-center my-6 border-t">
                <x-button :isDisabled="false" class="more-text-btn" @click="advance_filter=!advance_filter">
                    <span x-show="!advance_filter">Advanced Filter</span>
                    <span x-show="advance_filter">Basic Filter</span>
                </x-button>
            </div>
        </div>
        <div class="admin-tabs switch-tabs">
            <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#tabs-map" class="nav-link" id="tabs-map-tab" data-bs-toggle="pill" data-bs-target="#tabs-map" role="tab" aria-controls="tabs-map" aria-selected="true"><em class="fa-solid fa-map"></em> Map</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-table" class="nav-link active" id="tabs-table-tab" data-bs-toggle="pill" data-bs-target="#tabs-table" role="tab" aria-controls="tabs-table" aria-selected="false"><em class="fa-solid fa-list"></em> Table</a>
                </li>
            </ul>
            <div class="tab-content" id="tabs-tabContent">
                <div class="tab-pane fade show active" id="tabs-table" role="tabpanel" aria-labelledby="tabs-table-tab">
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
                                        <a wire:click.prevent="sortBy('number')" role="button" href="#">
                                            id
                                            @include('components._sort-icon', ['field' => 'number'])
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                            Name
                                            @include('components._sort-icon', ['field' => 'name'])
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a wire:click.prevent="sortBy('asset_type_id')" role="button" href="#">
                                            Asset Type
                                            @include('components._sort-icon', ['field' => 'asset_type_id'])
                                        </a>
                                    </th>
                                    <th scope="col" class="date-width">
                                        <a wire:click.prevent="sortBy('installation_date')" role="button" href="#">
                                            Installation Date
                                            @include('components._sort-icon', ['field' => 'installation_date'])
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a wire:click.prevent="sortBy('location_id')" role="button" href="#">
                                            Location
                                            @include('components._sort-icon', ['field' => 'location_id'])
                                        </a>
                                    </th>
                                    <th scope="col" class="action">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $key => $asset)
                                <tr>
                                    <td>{{ $asset->number }}</td>
                                    <td>{{ $asset->name }}</td>
                                    <td>{{ $asset->assetType?->name }}</td>
                                    <td>{{ $asset->installation_date ? customDateFormat($asset->installation_date) : '' }}</td>
                                    <td>{{ $asset->location?->name }}</td>
                                    <td>
                                        <div class="table-icons">
                                            <x-nav-link title="View" href="{{ route('admin.assets.show', $asset->id) }}">
                                                <em class="fa fa-eye" aria-hidden="true"></em>
                                            </x-nav-link>
                                            <x-nav-link title="Edit" href="{{ route('admin.assets.edit', $asset->id) }}">
                                                <em class="fa-solid fa-pen" aria-hidden="true"></em>
                                            </x-nav-link>
                                            <x-nav-link title="Delete" href="javascript:;" wire:click.prevent="$emit('alert', {{$asset->id}})">
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
                        {{ $data->links() }}
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-map" role="tabpanel" aria-labelledby="tabs-map-tab">
                    <div class="mapouter">
                        <div id="map-canvas" class="h-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function initManualFilter(option, element) {
            window.livewire.emitTo('asset-table', 'manualFilter', element.getAttribute('name'), option.value);
        }
        var locations = '';
        document.addEventListener('DOMContentLoaded', function() {
            locations = @json($mapData, true);
            Livewire.hook('message.received', (el, component) => {
                locations = component.serverMemo.data.mapData;
                if (locations) {
                    locateMap();
                }
            });
            const locateMap = () => {
                navigator.geolocation.getCurrentPosition(initMapView);
            }
            const initMapView = (position) => {
                const map = new google.maps.Map(document.getElementById("map-canvas"), {
                    zoom: 10,
                    center: {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    },
                });
                setMarkers(map);
            }
            const setMarkers = (map) => {
                let infowindow = new google.maps.InfoWindow();
                Object.entries(locations).forEach(([key, value]) => {
                    let marker = new google.maps.Marker({
                        position: {
                            lat: value.latitude,
                            lng: value.longitude
                        },
                        map,
                    });
                    google.maps.event.addListener(marker, 'click', (function(marker, value) {
                        let img = '';
                        if (value.url) {
                            img = `<img src=${value.url} />`;
                        }
                        let routeName = '{{ route("admin.assets.show", ":id") }}';
                        routeName = routeName.replace(':id', value.asset_id)
                        let markerContent = `<div class='map-marker'>${img}<p><a href="${routeName}" target="_blank">${value.name}</a></p></div>`;
                        return function() {
                            infowindow.setContent(markerContent);
                            infowindow.open(map, marker);
                        }
                    })(marker, value));
                });
            }
            locateMap();
        });
    </script>
</div>
