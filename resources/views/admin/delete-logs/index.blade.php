<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <!-- Validation Errors -->
        <x-alert-message class="mb-4"/>

        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>Delete Logs</h1>
            </div>
        </div>
        <div class="main-content">
            <livewire:delete-log-table/>
            <livewire:sweet-alert component="delete-log-table" entityTitle="Logs"/>
        </div>
    </div>
</x-app-layout>
