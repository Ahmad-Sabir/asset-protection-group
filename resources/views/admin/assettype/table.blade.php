<div>
    <x-livewire-loader></x-livewire-loader>
    <div class="main-wrapper">
        <div class="filters-section">
            <div class="form-group">
                <x-label for="assettype_id" class="form-label">ID</x-label>
                <x-input type="text" id="assettype_id" wire:model="filter.id" placeholder="Enter ID"></x-input>
            </div>
            <div class="form-group">
                <x-label for="name_search">Name</x-label>
                <x-input type="text" id="name_search" wire:model="filter.name" placeholder="Enter Name"> </x-input>
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
    </div>
    <div class="main-wrapper">
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
                            <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                Name
                                @include('components._sort-icon', ['field' => 'name'])
                            </a>
                        </th>
                        <th scope="col" class="action">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $assettype)
                    <tr>
                        <td>{{ $assettype->id }}</td>
                        <td>{{ $assettype->name }}</td>
                        <td>
                            <div class="table-icons">
                                <x-nav-link title="View" href="javascript:;" wire:click="edit({{ json_encode(array_merge([
                                'show' => true,
                                'view_file' => 'admin.assettype.edit'
                                ], $assettype->toArray()), true) }})" data-bs-toggle="offcanvas" data-bs-target="#edit-assettype">
                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                </x-nav-link>
                                <x-nav-link title="Edit" href="javascript:;" wire:click="edit({{ json_encode(array_merge([
                                'edit' => true,
                                'view_file' => 'admin.assettype.edit'
                                ], $assettype->toArray()), true) }})" data-bs-toggle="offcanvas" data-bs-target="#edit-assettype">
                                    <em class="fa-solid fa-pen" aria-hidden="true"></em>
                                </x-nav-link>
                                <x-nav-link title="Delete" href="javascript:;" wire:click.prevent="$emit('alert', {{$assettype->id}})">
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
    </div>

    {{ $data->links() }}
</div>

@push('script')
<script>
    window.addEventListener('edit-modal', event => {
        document.getElementById("edit-assettype-body").innerHTML = event.detail;
    });
</script>
@endpush
