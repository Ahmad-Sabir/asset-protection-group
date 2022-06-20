<div>
    <x-livewire-loader></x-livewire-loader>
    <div class="main-wrapper md:overflow-hidden overflow-x-auto">
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
        <table class="admin-table" aria-label="">
            <thead>
                <tr>
                    <th scope="col" class="id-width">
                        ID
                    </th>
                    <th scope="col">
                        Work Order
                    </th>
                    <th scope="col">
                        WORK ORDER TYPE
                    </th>
                    <th scope="col">
                       Frequency
                    </th>
                    <th scope="col" class="date-width">
                        Due Date
                    </th>
                    <th scope="col">
                        Assigned To
                    </th>
                    <th scope="col">
                        Qualification
                    </th>
                    <th scope="col">
                       Status
                    </th>
                    <th scope="col" class="action">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $work_order)
                <tr>
                    <td>{{ $work_order->id }}</td>
                    <td>{{ $work_order->title }}</td>
                    <td>{{ $work_order->work_order_type }}</td>
                    <td>
                    {{
                        $work_order->work_order_type == config('apg.recurring_status.recurring') ? $work_order->work_order_frequency : 'Once'
                    }}
                    </td>
                    <td>{{ $work_order->due_date ? customDateFormat($work_order->due_date) : '' }}</td>
                    <td>{{ $work_order->user?->full_name }}</td>
                    <td>{{ $work_order->qualification }}</td>
                    <td>
                        <span class="{{ config('apg.work_order_status_color.' . $work_order->work_order_status) }}">
                            {{ $work_order->work_order_status }}
                        </span>
                    </td>
                    <td>
                        <div class="table-icons">
                            <x-nav-link href="{{ route('admin.work-orders.show', $work_order->id) }}">
                                <em class="fa fa-eye" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.work-orders.edit', [$work_order->id, 'is_compliance' => true]) }}">
                                <em class="fa-solid fa-pen" aria-hidden="true"></em>
                            </x-nav-link>
                            <x-nav-link href="javascript:;" wire:click.prevent="$emit('alert', {{$work_order->id}})">
                                <em class="fa-solid fa-trash" aria-hidden="true"></em>
                            </x-nav-link>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center">No Record Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $data->links() }}
</div>
