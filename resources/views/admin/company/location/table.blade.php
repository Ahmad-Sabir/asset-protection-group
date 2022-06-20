<div>
    <x-livewire-loader></x-livewire-loader>

        <div class="filters-section border-b py-5 my-5">
            <div class="form-group">
                <x-label for="location_name" class="form-label">Name</x-label>
                <x-input type="text" id="location_name" wire:model="filter.name" placeholder="Enter Name"></x-input>
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
                    <th scope="col">
                        <a wire:click.prevent="sortBy('id')" role="button" href="#">
                            id
                            @include('components._sort-icon', ['field' => 'id'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('name')" role="button" href="#">
                            Name
                            @include('components._sort-icon', ['field' => 'name'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('latitude')" role="button" href="#">
                            Latitude
                            @include('components._sort-icon', ['field' => 'latitude'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('longitude')" role="button" href="#">
                            Longitude
                            @include('components._sort-icon', ['field' => 'longitude'])
                        </a>
                    </th>
                    <th scope="col" class="action">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $location)
                <tr>
                    <td>{{ $location->id }}</td>
                    <td>{{ $location->name }}</td>
                    <td>{{ $location->latitude }}</td>
                    <td>{{ $location->longitude }}</td>
                    <td>
                        <div class="table-icons">
                            <x-nav-link title="View" href="javascript:;" wire:click="edit({{ json_encode(array_merge(['show' => true], $location->only(['id', 'name', 'latitude', 'longitude'])), true) }})" data-bs-toggle="offcanvas" data-bs-target="#edit-location">
                                <em class="fa fa-eye" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link title="Edit" href="javascript:;" wire:click="edit({{ json_encode(array_merge(['edit' => true], $location->only(['id', 'name', 'latitude', 'longitude'])), true) }})" data-bs-toggle="offcanvas" data-bs-target="#edit-location">
                                <em class="fa-solid fa-pen" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link title="Delete" href="javascript:;" wire:click.prevent="$emit('alert', {{$location->id}})">
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
    var mapView;
    var mapEdit;
    document.addEventListener('DOMContentLoaded', function () {
        mapView = initMapLocation('view-map-canvas', {'lat':38.50134180000001, 'lng': 43.37893139999999});
        mapEdit = initMapLocation('edit-map-canvas', {'lat':38.50134180000001, 'lng': 43.37893139999999}, true);
    });

    window.addEventListener('edit-modal', event => {
        let location = event.detail;
        let routeName = '{{ route("admin.companies.locations.update", ["company" => ":company", "location" => ":id"]) }}'
        routeName = routeName.replace(':id', location.id)
        routeName = routeName.replace(':company', "{{request()->route('company')}}")
        document.querySelector('#location-put-form').setAttribute('action', routeName)
        document.querySelector('#location-put-form')._x_dataStack[0].formData = location
        if (location.edit) {
            initGeocode({'lat':location.latitude, 'lng': location.longitude}, mapEdit.map, mapEdit.marker);
        } else if (location.show) {
            initGeocode({'lat':location.latitude, 'lng': location.longitude}, mapView.map, mapView.marker);
        }
    });
</script>
@endpush
