<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <!-- Validation Errors -->
        <x-alert-message class="mb-4" :errors="$errors" />
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>MANAGE WORK ORDERS</h1>
            </div>
            <div class="top-buttons gap-3">
                <x-button type="submit" id="export-pdf" onclick="pdfExport()" class="btn-outline-secondary">
                    <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
                </x-button>
                <x-button type="submit" id="export-csv" onclick="csvExport()" class="btn-outline-primary">
                    <em class="fa-solid fa-cloud-arrow-down"></em> Download CSV
                </x-button>
            </div>
        </div>
        <div class="main-content">
            <livewire:work-order-table
                :where="[['assignee_user_id', '=', Auth::user()->id]]"
                view-file="employee.workorder.table"
            />
            <livewire:sweet-alert component="work-order-table" entityTitle="workorder" />
        </div>
    </div>
    @pushOnce('script')
    <script>
        function pdfExport() {
            window.livewire.emitTo('work-order-table', 'export', 'pdf');
            document.getElementById("export-pdf").disabled = true;
        }
    </script>
    <script>
        function csvExport() {
            window.livewire.emitTo('work-order-table', 'csvExport', 'csv');
            document.getElementById("export-csv").disabled = true;
        }
    </script>
    @endpushOnce
</x-app-layout>
