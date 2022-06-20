<div>
    <x-livewire-loader></x-livewire-loader>
    <div class="main-wrapper">
        <div class="filters-section">
            <div class="form-group">
                <x-label for="used_id" class="form-label">ID</x-label>
                <x-input type="text" id="used_id" wire:model="filter.id" placeholder="Enter ID"></x-input>
            </div>
            <div class="form-group">
                <x-label for="full_name_search">Full Name</x-label>
                <x-input type="text" id="full_name_search" wire:model="filter.full_name_search" placeholder="Full Name"> </x-input>
            </div>
            <div class="form-group">
                <x-label for="email">Email</x-label>
                <x-input type="text" id="email" wire:model="filter.email" placeholder="Enter Email"></x-input>
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
                            <a wire:click.prevent="sortBy('first_name')" role="button" href="#">
                                Full Name
                                @include('components._sort-icon', ['field' => 'first_name'])
                            </a>
                        </th>
                        <th scope="col">
                            <a wire:click.prevent="sortBy('email')" role="button" href="#">
                                Email
                                @include('components._sort-icon', ['field' => 'email'])
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
                    @forelse ($data as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->first_name }} {{ $user->last_name}}</td>
                        <td>{{ $user->email }}</td>
                        <td @class([ 's-active'=> is_null($user->deactivate_at),
                            's-inactive' => !is_null($user->deactivate_at),
                            ])>
                            {{ is_null($user->deactivate_at) ? 'Active' : 'Inactive' }}
                        </td>
                        <td>
                            <div class="table-icons">
                                <x-nav-link title="View" href="javascript:;" wire:click="edit({{ json_encode(array_merge(['show' => true], $user->toArray()), true) }})" data-bs-toggle="offcanvas" data-bs-target="#edit-user">
                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                </x-nav-link>
                                <x-nav-link title="Edit" href="javascript:;" wire:click="edit({{ json_encode(array_merge(['edit' => true], $user->toArray()), true) }})" data-bs-toggle="offcanvas" data-bs-target="#edit-user">
                                    <em class="fa-solid fa-pen" aria-hidden="true"></em>
                                </x-nav-link>
                                @if (auth()->id() != $user->id)
                                <x-nav-link title="Delete" href="javascript:;" wire:click.prevent="$emit('alert', {{$user->id}})">
                                    <em class="fa-solid fa-trash" aria-hidden="true"></em>
                                </x-nav-link>
                                @endif
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
        let user = event.detail;
        let routeName = '{{ route("admin.users.update", ":id") }}'
        routeName = routeName.replace(':id', user.id)
        document.querySelector('#user-patch-form').setAttribute('action', routeName)
        document.querySelector('#user-patch-form')._x_dataStack[0].formData = user;
        if (user.profile_media_id) {
            document.getElementById('avatar-edit_media_id').children[0].setAttribute('src', user.profile.url);
            document.getElementById('edit_media_id').value = user.profile_media_id;
        }
    });
</script>
@endpush
