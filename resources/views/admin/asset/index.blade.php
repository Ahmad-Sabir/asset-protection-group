<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
         <!-- Validation Errors -->
        <x-alert-message class="mb-4"/>
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>MANAGE MASTER ASSETS</h1>
            </div>
            <div class="top-buttons gap-3">
                <x-button type="button" id="export-pdf" onclick="pdfExport()" class="btn-outline-secondary">
                    <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
                </x-button>
                <x-button type="button" id="export-csv" onclick="csvExport()" class="btn-outline-primary">
                    <em class="fa-solid fa-cloud-arrow-down"></em> Download CSV
                </x-button>
                <form class="md:w-auto w-full" action="{{ route('admin.assets.import.csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-input type="file" id="CSVFile" onchange="form.submit()" name="file" class="form-control"
                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                    class="hidden" required></x-input>
                    <x-button type="button" class="btn-outline-primary" onclick="document.getElementById('CSVFile').click()">
                        <em class="fa-solid fa-cloud-arrow-up"></em> Import Assets
                    </x-button>
                    <x-button type="submit" class="btn-outline-primary" class="hidden">
                        <em class="fa-solid fa-cloud-arrow-up"></em>
                    </x-button>
                </form>
                <a class="md:w-auto w-full" href="{{ route('admin.assets.export.template') }}">
                    <x-button type="button" class="btn-outline-primary">
                        <em class="fa-solid fa-cloud-arrow-down"></em> CSV Template
                    </x-button>
                </a>
                <x-nav-link href="{{ route('admin.assets.create') }}" class="btn btn-primary">
                    <em class="fa-solid fa-circle-plus"></em> ADD ASSET
                </x-nav-link>
            </div>
        </div>
        <div class="main-content">
                <livewire:asset-table
                    :where="[['type', '=', config('apg.type.master')]]"
                    view-file="admin.asset.table"
                    />
                <livewire:sweet-alert component="asset-table" entityTitle="asset"/>
        </div>
    </div>
@pushOnce('script')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_map_key')}}&libraries=places"
        type="text/javascript">
    </script>
    <script>
        function pdfExport() {
            window.livewire.emitTo('asset-table', 'export', 'pdf');
            document.getElementById("export-pdf").disabled = true;
        }
    </script>
    <script>
        function csvExport() {
            window.livewire.emitTo('asset-table', 'csvExport', 'csv', "{{ config('apg.type.master') }}");
            document.getElementById("export-csv").disabled = true;
        }
    </script>
@endPushOnce
</x-app-layout>
