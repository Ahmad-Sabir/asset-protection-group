<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <!-- Validation Errors -->
        <x-alert-message class="mb-4" :errors="$errors" />
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>MANAGE MASTER WORK ORDERS</h1>
            </div>
            <div class="top-buttons gap-3">
                <x-button id="export-pdf" onclick="pdfworkOrderExport()" type="button" class="btn-outline-secondary">
                    <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
                </x-button>
                <x-button type="submit" id="export-csv" onclick="csvExport()" class="btn-outline-primary">
                    <em class="fa-solid fa-cloud-arrow-down"></em> Download CSV
                </x-button>
                <x-button id="export-pdf" onclick="exportComprehensive()" type="button" class="btn-outline-primary">
                    <em class="fa-solid fa-cloud-arrow-down"></em> Download Comprehensive Plan
                </x-button>
                <form class="md:w-auto w-full" action="{{ route('admin.work-orders.import.csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-input type="file" id="CSVFile" onchange="form.submit()" name="file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="hidden" required></x-input>
                    <x-button type="button" class="btn-outline-primary" onclick="document.getElementById('CSVFile').click()">
                        <em class="fa-solid fa-cloud-arrow-up"></em> Import Work Orders
                    </x-button>
                    <x-button type="submit" class="btn-outline-primary" class="hidden">
                        <em class="fa-solid fa-cloud-arrow-up"></em>
                    </x-button>
                </form>
                <a class="md:w-auto w-full" href="{{ route('admin.work-orders.export.template') }}">
                    <x-button type="submit" class="btn-outline-primary">
                        <em class="fa-solid fa-cloud-arrow-down"></em> CSV Template
                    </x-button>
                </a>
                <x-nav-link href="{{ route('admin.work-orders.create') }}" class="btn btn-primary">
                    <em class="fa-solid fa-circle-plus"></em> ADD NEW WORK ORDER
                </x-nav-link>
            </div>
        </div>
        <div class="main-content">
            <livewire:work-order-table
                :where="[['type', '=', config('apg.type.master')]]"
                view-file="admin.workorder.table"
            />

            <livewire:sweet-alert component="work-order-table" entityTitle="workorder" />
        </div>
    </div>
@pushOnce('script')
<script>
    function pdfworkOrderExport() {
        window.livewire.emitTo('work-order-table', 'export', 'pdf');
        document.getElementById("export-pdf").disabled = true;
    }
</script>
<script>
    function exportComprehensive() {
        window.livewire.emitTo('work-order-table', 'exportComprehensive', 'pdf');
        document.getElementById("export-pdf").disabled = true;
    }
</script>
<script>
    function csvExport() {
        window.livewire.emitTo('work-order-table', 'csvExport', 'csv');
        document.getElementById("export-csv").disabled = true;
    }
</script>
@endPushOnce
</x-app-layout>
