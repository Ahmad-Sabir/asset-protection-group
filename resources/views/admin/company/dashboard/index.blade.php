<x-app-layout>
    <x-company-layout :company="$company">
    <div class="main-content">
            <livewire:asset-table
                :where="[
                    ['type', '=', config('apg.type.company')],
                    ['company_id', '=', $company->id]
                ]"
                view-file="admin.company.dashboard.table"
                :companyId="$company->id"
                />
            <livewire:sweet-alert component="asset-table" entityTitle="asset"/>
    </div>
</x-company-layout>
@pushOnce('script')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_map_key')}}&libraries=places"
        type="text/javascript">
    </script>
@endPushOnce
</x-app-layout>
