<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <!-- Validation Errors -->
        <x-alert-message class="mb-4"/>

        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>Notifications</h1>
            </div>
        </div>
        <div class="main-content">
            <livewire:notification-table />
        </div>
    </div>
</x-app-layout>
