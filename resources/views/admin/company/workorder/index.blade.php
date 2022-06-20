<x-app-layout>
    <x-company-layout :company="$company">
    <div class="main-fixed-wrap">
        <div class="heading"></div>
        <div class="top-buttons gap-3">
            <x-button type="button" id="export-pdf" onclick="pdfworkOrderExport()" class="btn-outline-secondary">
                <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
            </x-button>
            <x-button type="submit" id="export-csv" onclick="csvExport()" class="btn-outline-primary">
                <em class="fa-solid fa-cloud-arrow-down"></em> Download CSV
            </x-button>
            <x-button onclick="exportComprehensive()" id="export-pdf" type="button" class="btn-outline-primary">
                <em class="fa-solid fa-cloud-arrow-down"></em> Download Comprehensive Plan
            </x-button>
            <form class="md:w-auto w-full" action="{{ route('admin.companies.work-orders.import.csv', $company->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-input type="file" id="CSVFile" onchange="form.submit()" name="file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="hidden" required></x-input>
                <x-button type="button" class="btn btn-outline-primary" onclick="document.getElementById('CSVFile').click()">
                    <em class="fa-solid fa-cloud-arrow-up"></em> Import Work Orders
                </x-button>
                <x-button type="submit" class="btn btn-outline-primary" class="hidden">
                    <em class="fa-solid fa-cloud-arrow-up"></em>
                </x-button>
            </form>
            <a class="md:w-auto w-full" href="{{ route('admin.work-orders.export.template') }}">
                <x-button type="submit" class="btn-outline-primary">
                    <em class="fa-solid fa-cloud-arrow-down"></em> CSV Template
                </x-button>
            </a>
            <x-nav-link href="{{ route('admin.companies.work-orders.create', $company->id) }}" class="btn btn-primary">
                <em class="fa-solid fa-circle-plus"></em> ADD NEW WORK ORDER
            </x-nav-link>
        </div>
    </div>
    <div class="main-content">
        <livewire:work-order-table
            :where="[['type', '=', config('apg.type.company')],
            ['company_id', '=', $company->id]]"
            view-file="admin.company.workorder.table"
            :companyId="$company->id"
        />

        <livewire:sweet-alert component="work-order-table" entityTitle="workorder" />
    </div>

</x-company-layout>
@pushOnce('script')
<script>
    function pdfworkOrderExport() {
        window.livewire.emitTo('work-order-table', 'export', 'pdf');
        document.getElementById("export-pdf").disabled = true;
    }
</script>
<script>
    function exportComprehensive() {
        window.livewire.emitTo('work-order-table', 'exportComprehensive', 'pdf', "{{ $company->id }}");
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
