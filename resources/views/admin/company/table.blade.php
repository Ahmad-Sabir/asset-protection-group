<div>
    <x-livewire-loader></x-livewire-loader>
    <div class="main-wrapper">
        <div class="filters-section">
            <div class="form-group">
                <x-label for="used_id" class="form-label">Company ID</x-label>
                <x-input type="text" id="used_id" wire:model="filter.id" placeholder="Enter ID"></x-input>
            </div>
            <div class="form-group">
                <x-label for="name">Company Name</x-label>
                <x-input type="text" id="name" wire:model="filter.name" placeholder="Company Name"> </x-input>
            </div>
            <div class="form-group">
                <x-label for="email"> Email Address</x-label>
                <x-input type="text" id="email" wire:model="filter.manager_email" placeholder="Enter Email"></x-input>
            </div>
            <div class="form-group company-status">
                <x-label for="status">Company Status</x-label>
                <x-select  class="form-select" id="status" wire:model.defer="filter.deactivate_at" >
                    <option value="">Select</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </x-select>
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
                            Company id
                            @include('components._sort-icon', ['field' => 'id'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('name')" role="button" href="#">
                            Company Name
                            @include('components._sort-icon', ['field' => 'name'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('manager_email')" role="button" href="#">
                            Company Email
                            @include('components._sort-icon', ['field' => 'manager_email'])
                        </a>
                    </th>
                    <th scope="col">
                        <a wire:click.prevent="sortBy('deactivate_at')" role="button" href="#">
                            Status
                            @include('components._sort-icon', ['field' => 'deactivate_at'])
                        </a>
                    </th>
                    <th scope="col" class="action">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $company)
                <tr>
                    <td>{{ $company->id }}</td>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->manager_email }}</td>
                    <td @class([ 's-active'=> is_null($company->deactivate_at),
                        's-inactive' => !is_null($company->deactivate_at),
                        ])>
                        {{ is_null($company->deactivate_at) ? 'Active' : 'Inactive' }}
                    </td>
                    <td>
                        <div class="table-icons">
                            <x-nav-link title="View" href="{{ route('admin.companies.show', $company->id) }}">
                                <em class="fa fa-eye" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link title="Edit" href="javascript:;" wire:click="edit({{ json_encode(array_merge(['edit' => true], $company->toArray()), true) }})" data-bs-toggle="offcanvas" data-bs-target="#edit-company">
                                <em class="fa-solid fa-pen" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link title="Delete" href="javascript:;" wire:click.prevent="$emit('alert', {{$company->id}})">
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
</div>

@push('script')
<script>
    window.addEventListener('edit-modal', event => {
        let company = event.detail;
        let routeName = '{{ route("admin.companies.update", ":id") }}'
        routeName = routeName.replace(':id', company.id)
        document.querySelector('#company-patch-form').setAttribute('action', routeName)
        document.querySelector('#company-patch-form')._x_dataStack[0].formData = company;
        if (company.profile_media_id) {
            document.getElementById('avatar-edit_media_id').children[0].setAttribute('src', company.profile.url);
            document.getElementById('edit_media_id').value = company.profile_media_id;
        }
    });
</script>
@endpush
