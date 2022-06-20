<div>
    <x-livewire-loader></x-livewire-loader>
    <div class="main-wrapper">
        <div class="table-border">
            <table class="admin-table" aria-label="">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Notifications</th>
                        <th scope="col">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $memberType = (auth()->user()->user_status == config('apg.user_status.employee')) ? 'employee'  : 'admin';
                    @endphp
                    @forelse ($push ?? [] as $key => $notification)
                        <tr class="{{ ($notification['read_at'] != null) ? 'bg-white' : 'notification-hover' }}">
                            <td>{{ ++$key }}</td>
                            <td>
                                <a href="{{ route("$memberType.work-orders.show", [$notification->data['workorder_id'], 'notification_id' => $notification->id]) }}">
                                    {{ $notification->data['message'] }}
                                </a>
                            </td>
                            <td>{{ customDateFormat($notification->created_at, false) }}</td>
                        </tr>
                    @empty
                        <div>No notification found.</div>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $push->links() }}
</div>
