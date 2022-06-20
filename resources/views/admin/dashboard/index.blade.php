<x-app-layout>
    <div class="main-content">
            <livewire:asset-table
                :where="[
                    ['type', '=', config('apg.type.master')]
                ]"
                view-file="admin.dashboard.table"
                />
            <livewire:sweet-alert component="asset-table" entityTitle="asset"/>
    </div>
@pushOnce('script')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_map_key')}}&libraries=places"
        type="text/javascript">
    </script>
@endPushOnce
</x-app-layout>
