<div>
    <x-livewire-loader></x-livewire-loader>
    <div class="main-wrapper">
        <div class="filters-section">
            <div class="form-group">
                <x-label for="user_name">User Name</x-label>
                <x-input type="text" id="user_name" wire:model="filter.user_name" placeholder="User Name"> </x-input>
            </div>
            <div class="form-group">
                <x-label for="company">Company</x-label>
                <x-input type="text" id="company" wire:model="filter.company" placeholder="Enter Company"></x-input>
            </div>
            <div class="form-group">
                <x-label for="description">Description</x-label>
                <x-input type="text" id="description" wire:model="filter.description" placeholder="Enter Description"></x-input>
            </div>
            <div class="form-group">
                <x-label for="created_on">Deleted On</x-label>
                <x-date-picker id="created_on" mode="range" wire:model="filter.range_created_at" autocomplete="off" data-input>
                </x-date-picker>
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
        <div class="flex md:flex-row flex-col justify-between items-center">
            <div class="form-group flex items-center md:order-1 order-2">
                <x-label class="text-b">Showing</x-label>
                <select class="form-select mx-2" aria-label="Default select example" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
                <span>entries</span>
            </div>
            <div class="form-group md:order-2 order-1">
                <x-button type="button" class="btn-danger filter-btn md:mb-0 mb-3"
                wire:click.prevent="$emit('alert', false, 'bulkRestore', {
                    'confirm':  'messages.confirm_restore_log',
                    'success':  'messages.restore_success',
                })">
                <em class="fa-solid fa-trash-restore"></em> Bulk Restore
                </x-button>
                <x-button type="button" class="btn-danger filter-btn md:ml-2 ml-0"
                wire:click.prevent="$emit('alert', true, 'bulkRestore')">
                <em class="fa-solid fa-trash"></em> Bulk Delete
                </x-button>
            </div>
        </div>
        <div class="table-border">
            <table class="admin-table" aria-label="">
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="form-check">
                                <x-input class="form-check-input" type="checkbox" wire:model="selectAll"/>
                            </div>
                        </th>
                        <th scope="col">User Name</th>
                        <th scope="col">Company</th>
                        <th scope="col">Type</th>
                        <th scope="col">Description</th>
                        <th scope="col" class="date-width">Deleted On</th>
                        <th scope="col" class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                    <tr>
                        <td>
                            <div class="form-check">
                                <x-input class="form-check-input" type="checkbox" wire:model.defer="logIds" value="{{ $log->id }}" />
                            </div>
                        </td>
                        <td> {{ $log->user->full_name }}</td>
                        <td> {{ $log->company?->name  }} </td>
                        <td> {{ class_basename($log->entity_type) }} </td>
                        <td>
                            @if (class_basename($log->entity_type) == 'WorkOrder')
                                @php
                                    $workOrder = $log->entity()->withTrashed()->first();
                                    $asset = $workOrder?->asset()->withTrashed()->first();
                                @endphp
                                @if (! empty($asset))
                                    <x-nav-link href="javascript:;" title="{{ $asset->number }} - {{ $asset->name }}">{{ $log->description }}</x-nav-link >
                                @else
                                    {{ $log->description }}
                                @endif
                            @else
                                {{ $log->description }}
                            @endif
                        </td>
                        <td> {{ customDateFormat($log->created_at) }}</td>
                        <td class="text-right">
                            <x-nav-link title="Undo" href="javascript:;" wire:click="$emit('alert', {{$log->id}}, 'reStore', {
                                'confirm':  'messages.confirm_restore_log',
                                'success':  'messages.restore_success',
                            })" title="Restore">
                                <em class="fa-solid fa fa-undo" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link title="Delete" href="javascript:;" wire:click.prevent="$emit('alert', {{$log->id}})">
                                <em class="fa-solid fa-trash" aria-hidden="true"></em>
                            </x-nav-link>
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
    {{ $logs->links() }}
    </div>
</div>
