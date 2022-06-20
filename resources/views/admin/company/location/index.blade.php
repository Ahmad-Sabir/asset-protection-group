<x-app-layout>
<x-company-layout :company="$company">
    <div class="main-fixed-wrap">
        <div class="top-buttons">
            <x-button type="submit" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-location">
                <em class="fa-solid fa-circle-plus"></em> ADD Location
            </x-button>
        </div>
    </div>
    <div class="main-content">
        <livewire:table
        :model="App\Models\Admin\Asset\Location::class"
        :where="[
            ['company_id', '=', $company->id],
            ['is_crud', '=', 1]
        ]"
        view-file="admin.company.location.table"
        />
    </div>
    <livewire:sweet-alert component="table" entityTitle="Location"/>
    <x-right-modal id="edit-location" heading="Location Detail">
        <form action="" method="post" x-data="submitForm()" @submit.prevent="onSubmitPut" id="location-put-form">
            <div x-show="formData.show">
                <table class="admin-table mt-4" aria-label="">
                <th></th>
                    <tbody>
                        <tr class="border-b">
                            <div class="mapouter">
                                <div id="view-map-canvas" class="h-full mb-4"></div>
                            </div>
                        </tr>
                        <tr class="border-b">
                            <td class="gray3">Name</td>
                            <td class="text-right" x-text="formData.name"></td>
                        </tr>
                        <tr class="border-b">
                            <td class="gray3">Latitude</td>
                            <td class="text-right" x-text="formData.latitude"></td>
                        </tr>
                        <tr class="border-b">
                            <td class="gray3">Longitude</td>
                            <td class="text-right" x-text="formData.longitude"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div x-show="formData.edit">
                <div class="form-group">
                    <x-label for="searchmap" value="Name" required="true"/>
                    <x-input type="text" id="edit_searchmap" class="form-control" name="name"
                        x-model="formData.name"
                        x-bind:class="errorMessages.name ? 'invalid' : ''"
                        placeholder="Search Location"/>
                    <span class="invalid" x-text="errorMessages.name"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Latitude" required="true"/>
                    <x-input type="text" class="form-control" id="edit_latitude" name="latitude"
                    x-model="formData.latitude"
                    x-bind:class="errorMessages.latitude ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.latitude"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Longitude" required="true"/>
                    <x-input type="text" class="form-control" id="edit_longitude" name="longitude"
                    x-model="formData.longitude"
                    x-bind:class="errorMessages.longitude ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.longitude"></span>
                </div>
                <div class="form-group">
                    <x-button id="edit_searchLatLng" type="button" class="btn-primary">
                        Search From Latitude And Longitude
                    </x-button>
                </div>
                <div class="mapouter">
                    <div id="edit-map-canvas" class="h-full mb-4"></div>
                </div>
                <x-button type="submit" class="btn-primary">
                    <em class="fa-solid fa-check"></em> EDIT LOCATION
                </x-button>
            </div>
        </form>
    </x-right-modal>
    <x-right-modal id="add-location" heading="Add Location">
        <form action="{{ route('admin.companies.locations.store', $company->id) }}" method="post" x-data="submitForm()" @submit.prevent="onSubmitPost" id="user-post-form">
            <div class="form-group">
                <x-label for="searchmap" value="Name" required="true"/>
                <x-input type="text" class="form-control" id="searchmap" name="name" x-bind:class="errorMessages.name ? 'invalid' : ''"
                    placeholder="Search Location" x-model="formData.name"/>
                <span class="invalid" x-text="errorMessages.name"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Latitude" required="true"/>
                <x-input type="text" class="form-control" id="latitude" name="latitude"
                x-bind:class="errorMessages.latitude ? 'invalid' : ''" x-model="formData.latitude"/>
                <span class="invalid" x-text="errorMessages.latitude"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Longitude" required="true"/>
                <x-input type="text" class="form-control" id="longitude" name="longitude"
                 x-bind:class="errorMessages.longitude ? 'invalid' : ''" x-model="formData.longitude"/>
                <span class="invalid" x-text="errorMessages.longitude"></span>
            </div>
            <div class="form-group">
                <x-button id="searchLatLng" type="button" class="btn-primary">
                    Search From Latitude And Longitude
                </x-button>
            </div>
            <div class="mapouter">
                <div id="map-canvas" class="h-full mb-4"></div>
            </div>
            <x-button type="submit" class="btn-primary">
                <em class="fa-solid fa-check"></em> ADD LOCATION
            </x-button>
        </form>
    </x-right-modal>
</x-company-layout>
@push('style')
    <style>
        .pac-container { z-index: 100000 !important; }
    </style>
@endpush
@push('script')
<script src="{{ asset('js/googlemaps.js') }}"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_map_key')}}&libraries=places&callback=locate"
    type="text/javascript">
</script>
<script>
    var  geocoder = new google.maps.Geocoder();
    const initMapLocation = (element, latLng, draggable = false) => {
        let map = new google.maps.Map(document.getElementById(element), {
            center:latLng,
            zoom:10,
        });
        let marker = new google.maps.Marker({
            map: map,
            position: latLng,
            draggable: draggable
        });
        if (draggable) {
            var searchBox = new google.maps.places.SearchBox(document.getElementById('edit_searchmap'));
            google.maps.event.addListener(searchBox,'places_changed', function() {
                var places = searchBox.getPlaces();
                var bounds = new google.maps.LatLngBounds();
                var i, place;
                for(i=0; i < places.length; i++){
                    place = places[i];
                    bounds.extend(place.geometry.location);
                    marker.setPosition(place.geometry.location); //set marker position new...
                }
                map.fitBounds(bounds);
                map.setZoom(5);
            });
            google.maps.event.addListener(marker,'position_changed',function() {
            document.getElementById("edit_latitude").value = marker.getPosition().lat();
            document.getElementById("edit_longitude").value = marker.getPosition().lng();
            geocoder.geocode({
                'latLng': marker.getPosition()
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            document.getElementById("edit_searchmap").value = results[0].formatted_address;
                        }
                    }
                });
            });

            document.getElementById("edit_searchLatLng").addEventListener("click", () => {
                let latitude = parseFloat(document.getElementById("edit_latitude").value);
                let longitude = parseFloat(document.getElementById("edit_longitude").value);
                initGeocode({'lat':latitude, 'lng': longitude}, map, marker);
            });
        }

        return {'map' : map, 'marker' : marker};
    }
    const initGeocode = (latLng, map, marker) => {
        geocoder.geocode({
        'latLng': latLng
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var bounds = new google.maps.LatLngBounds();
                    bounds.extend(latLng);
                    marker.setPosition(latLng)
                    map.fitBounds(bounds);
                    map.setZoom(10);
                }
            }
        });
    }
</script>
@endpush
</x-app-layout>
