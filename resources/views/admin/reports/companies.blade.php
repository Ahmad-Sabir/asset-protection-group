<x-app-layout>
    <!-- Content -->
    <x-report-layout>
        <livewire:table
        :model="App\Models\Company::class"
        view-file="livewire.reports.company"
        :auto-save-filter=true
        />
    </x-report-layout>
</x-app-layout>
