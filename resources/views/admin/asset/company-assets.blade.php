<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
         <!-- Validation Errors -->
        <x-alert-message class="mb-4"/>
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>MANAGE COMPANY ASSETS</h1>
            </div>
        </div>
        <div class="main-content">
                <livewire:asset-table
                    :where="[['type', '=', config('apg.type.company')]]"
                    whereHas="company"
                    view-file="admin.company.asset.company-table"
                    />
                <livewire:sweet-alert component="asset-table" entityTitle="asset"/>
        </div>
    </div>
@pushOnce('script')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_map_key')}}&libraries=places"
        type="text/javascript">
    </script>
@endPushOnce
</x-app-layout>
