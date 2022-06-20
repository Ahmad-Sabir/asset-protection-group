<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>{{ $asset->name }}</h1>
            </div>
        </div>
        <div class="main-content">
            <div class="main-wrapper">
                <div class="admin-tabs">
                    <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <x-nav-link href="#asset-detail" class="nav-link active" id="asset-detail-tab" data-bs-toggle="pill" data-bs-target="#asset-detail" role="tab" aria-controls="asset-detail" aria-selected="true">
                                ASSET DETAILS
                            </x-nav-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <x-nav-link href="#upload-images" class="nav-link" id="upload-images-tab" data-bs-toggle="pill" data-bs-target="#upload-images" role="tab" aria-controls="upload-images" aria-selected="true">
                                ADDITIONAL FILES
                            </x-nav-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <x-nav-link href="#location" class="nav-link" id="location-tab" data-bs-toggle="pill" data-bs-target="#location" role="tab" aria-controls="location" aria-selected="true">
                                LOCATION
                            </x-nav-link>
                        </li>
                    </ul>
                    <form action="{{ route('admin.assets.update', $asset->id) }}" method="post" x-data="submitForm()" @submit.prevent="onSubmitPut" id="asset-put-form">
                        <div class="tab-content" id="tabs-tabContent">
                            <div class="tab-pane fade show active" id="asset-detail" role="tabpanel" aria-labelledby="asset-detail-tab">
                                <div class="tab-content-wrapper tab-content-full">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="form-group">
                                                <x-label for="name" required="true">Name</x-label>
                                                <x-input type="text" id="name" name="name" placeholder="Name"
                                                    x-bind:class="errorMessages.name ? 'invalid' : ''" value="{{ $asset->name }}">
                                                </x-input>
                                                <span class="invalid" x-text="errorMessages.name"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="model">Model</x-label>
                                                <x-input type="text" id="model" name="model" placeholder="Model"
                                                    x-bind:class="errorMessages.model ? 'invalid' : ''"
                                                    value="{{ $asset->model }}">
                                                </x-input>
                                                <span class="invalid" x-text="errorMessages.model"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="manufacturer">Manufacturer</x-label>
                                                <x-input type="text" id="manufacturer" name="manufacturer" placeholder="Manufacturer"
                                                    x-bind:class="errorMessages.manufacturer ? 'invalid' : ''" value="{{ $asset->manufacturer }}">
                                                </x-input>
                                                <span class="invalid" x-text="errorMessages.manufacturer"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="asset_type_id" required="true">Asset Type</x-label>
                                                <livewire:dynamic-dropdown
                                                name="asset_type_id"
                                                :where="[
                                                    ['type', '=', config('apg.type.master')],
                                                ]"
                                                :entity="\App\Models\Admin\Asset\AssetType::class"
                                                entity-select-fields="id, name"
                                                :entity-search-fields="['name']"
                                                entity-field="id"
                                                entity-display-field="name"
                                                :entity_id="$asset->asset_type_id ?? ''"
                                                >
                                                <span class="invalid" x-text="errorMessages.asset_type_id"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="status">Status</x-label>
                                                <x-select id="status" name="status" x-bind:class="errorMessages.status ? 'invalid' : ''">
                                                    <option value="0" @selected($asset->status == 0)>In Active</option>
                                                    <option value="1" @selected($asset->status == 1)>Active</option>
                                                </x-select>
                                                <span class="invalid" x-text="errorMessages.status"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="installation_date">Installation Date</x-label>
                                                <x-date-picker id="installation_date" name="installation_date" placeholder="Select Installation Date"
                                                    x-bind:class="errorMessages.installation_date ? 'invalid' : ''"
                                                    value="{{ $asset->installation_date ? customDateFormat($asset->installation_date) : '' }}"
                                                    autocomplete="off" data-input>
                                                </x-date-picker>
                                                <span class="invalid" x-text="errorMessages.installation_date"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="replacement_cost">Replacement Cost</x-label>
                                                <x-input type="number" id="replacement_cost" name="replacement_cost" placeholder="Replacement Cost"
                                                    x-bind:class="errorMessages.replacement_cost ? 'invalid' : ''"
                                                    value="{{ $asset->replacement_cost }}">
                                                </x-input>
                                                <span class="invalid" x-text="errorMessages.replacement_cost"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="purchase_date">Purchase Date</x-label>
                                                <x-date-picker id="purchase_date" name="purchase_date" placeholder="Select Purchase Date"
                                                    x-bind:class="errorMessages.purchase_date ? 'invalid' : ''"
                                                    value="{{ $asset->purchase_date ? customDateFormat($asset->purchase_date) : '' }}"
                                                    autocomplete="off" data-input>
                                                </x-date-picker>
                                                <span class="invalid" x-text="errorMessages.purchase_date"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="purchase_price">Purchase Price</x-label>
                                                <x-input type="number" id="purchase_price" name="purchase_price"
                                                    x-bind:class="errorMessages.purchase_price ? 'invalid' : ''"
                                                    placeholder="Purchase Price" value="{{ $asset->purchase_price }}">
                                                </x-input>
                                                <span class="invalid" x-text="errorMessages.purchase_price"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="warranty_expiry_date">Warranty Expiration</x-label>
                                                <x-date-picker id="warranty_expiry_date" name="warranty_expiry_date"
                                                    placeholder="Select Warranty Expiration"
                                                    x-bind:class="errorMessages.warranty_expiry_date ? 'invalid' : ''"
                                                    value="{{ $asset->warranty_expiry_date ? customDateFormat($asset->warranty_expiry_date) : '' }}" autocomplete="off" data-input>
                                                </x-date-picker>
                                                <span class="invalid" x-text="errorMessages.warranty_expiry_date"></span>
                                            </div>
                                            <p class="mt-5 mb-1">Total Useful Life</p>
                                            <div class="flex grid-cols-3 gap-4">
                                                <div class="form-group">
                                                    <x-label> Year </x-label>
                                                    <div>
                                                        <x-input type="number" min="1" name="total_useful_life[year]" placeholder="Year"
                                                            value="{{ $asset->total_useful_life['year'] > 0 ?? '' }}">
                                                        </x-input>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <x-label> Month </x-label>
                                                    <div>
                                                        <x-input type="number" min="1" name="total_useful_life[month]" placeholder="Month"
                                                            value="{{ $asset->total_useful_life['month'] > 0 ?? '' }}"
                                                            onchange="this.value = parseInt(this.value) > 11 ? 11 : this.value"
                                                            onkeyup="this.value = parseInt(this.value) > 11 ? 11 : this.value">
                                                        </x-input>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <x-label> Day </x-label>
                                                    <div>
                                                        <x-input type="number" min="1" name="total_useful_life[day]" placeholder="Day"
                                                            value="{{ $asset->total_useful_life['day'] > 0 ?? '' }}"
                                                            onchange="this.value = parseInt(this.value) > 29 ? 29 : this.value"
                                                            onkeyup="this.value = parseInt(this.value) > 29 ? 29 : this.value">
                                                        </x-input>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (! is_null($asset->total_useful_life_date))
                                            <div class="form-group">
                                                <x-label>Remaining UseFul Life</x-label>
                                                <x-input type="text" placeholder="{{ remainingDays($asset->total_useful_life_date) }}" disabled></x-input>
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <x-label for="description">Additional Information</x-label>
                                                <x-textarea id="description" name="description"
                                                rows="4" cols="5" placeholder="Additional Information">{{ $asset->description }}</x-textarea>
                                                <span class="invalid" x-text="errorMessages.description"></span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="main-wrapper" x-data="addCustomFields()">
                                                <div class="heading"><h5>Custom Fields</h5></div>
                                                <div class="col">
                                                    <table class="admin-table">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Value</th>
                                                                <th>Unit</th>
                                                                <th>&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <template x-for="(field, index) in fields" :key="index">
                                                                <tr class="form-group">
                                                                    <td x-text="index + 1"></td>
                                                                    <td><input  type="text" placeholder="Name" x-model="field.name" :name="`custom_values[${index}][name]`" class="form-control"></td>
                                                                    <td><input type="text" placeholder="Value" x-model="field.value" :name="`custom_values[${index}][value]`" class="form-control"></td>
                                                                    <td><input type="text" placeholder="Unit" x-model="field.unit" :name="`custom_values[${index}][unit]`" class="form-control"></td>
                                                                    <td><x-button type="button" class="red" @click="removeField(index)"><em class="fa-solid fa-trash-can"></em></x-button></td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                            <td colspan="5" class="text-right"><x-button type="button" class="btn-secondary mt-4" @click="addNewField()">+ Add Field</x-button></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <x-button type="submit" class="btn-primary">
                                                <em class="fa-solid fa-check"></em> SAVE CHANGES
                                            </x-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="upload-images" role="tabpanel" aria-labelledby="upload-images-tab">
                                <div class="tab-content-wrapper tab-content-full">
                                    <div class="image-upload">
                                        <x-dropzone name="media_ids" id="media_ids" multiFiles="50" :medias="$asset->medias"/>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location-tab">
                                <div class="tab-content-wrapper tab-content-full">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="form-group">
                                                <x-label>
                                                    Drag the pin on the map to update the location or provide latitude and longitude coordinates
                                                    for the location.
                                                </x-label>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="latitude">Latitude</x-label>
                                                <x-input type="text" id="latitude" name="location[latitude]" placeholder="Latitude"
                                                    value="{{ $asset->location?->latitude }}">
                                                </x-input>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="longitude">Longitude</x-label>
                                                <x-input type="text" id="longitude" name="location[longitude]" placeholder="Longitude"
                                                    value="{{ $asset->location?->longitude }}">
                                                </x-input>
                                            </div>
                                            <div class="form-group">
                                                <x-button id="searchLatLng" type="button" class="btn-primary">
                                                    Search From Latitude And Longitude
                                                </x-button>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="searchmap">Location Name</x-label>
                                                <x-input type="text" id="searchmap" name="location[name]" placeholder="Search Location"
                                                    value="{{ $asset->location?->name }}">
                                                </x-input>
                                            </div>
                                            <div class="mapouter">
                                                <div id="map-canvas" class="h-full mb-4"></div>
                                            </div>
                                            <div class="form-group">
                                                <x-button type="submit" class="btn-primary">
                                                    <em class="fa-solid fa-check"></em>Save Changes
                                                </x-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- tabs end --}}
                </div>
            </div>

        </div>
    </div>
@push('script')
<script>
    function addCustomFields() {
        return {
            fields: @json($asset->custom_values ?? []),
            addNewField() {
                this.fields.push({
                    name: '',
                    value: ''
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            }
        }
    }


</script>
<script src="{{ asset('js/googlemaps.js') }}"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_map_key')}}&libraries=places&callback=locate"
    type="text/javascript">
</script>
@endpush
</x-app-layout>
