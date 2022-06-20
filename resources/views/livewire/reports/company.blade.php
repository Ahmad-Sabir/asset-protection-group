<div>
    <div x-data=customizeTable()>
    <div class="flex md:flex-row flex-col justify-between items-center mb-4">
        <div class="form-group w-64">
            <x-label>Saved Filters</x-label>
            <livewire:dynamic-dropdown name="filter_report" :where="[
                ['type', '=', config('apg.report_types.users')],
            ]" :entity="\App\Models\FilterReport::class"
            entity-select-fields="id, name, filter"
            :entity-search-fields="['name']"
            entity-field="id"
            entity-display-field="name"
            isDataAttribute="true"
            onChangeFunc="initFilterReport">
        </div>
        <div>
            <x-button id="export-pdf" @click="exportPdfReportCompany(field)" type="button" type="button" class="btn-primary mr-3 md:mb-0 mb-3">
                <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
            </x-button>
            <x-button id="export-csv" @click="exportCsvReportCompany(field)" type="button" type="button" class="btn-outline-primary">
                <em class="fa-solid fa-cloud-arrow-down"></em> Download CSV
            </x-button>
        </div>
    </div>
    <x-livewire-loader></x-livewire-loader>

    <div class="filters-section mb-4">
        <div class="form-group">
            <x-label for="used_id" class="form-label">Company ID</x-label>
            <x-input type="text" id="used_id" wire:model.defer="filter.id" placeholder="Enter ID"></x-input>
        </div>
        <div class="form-group">
            <x-label for="name">Company Name</x-label>
            <x-input type="text" id="name" wire:model.defer="filter.name" placeholder="Company Name"> </x-input>
        </div>
        <div class="form-group">
            <x-label for="email"> Email Address</x-label>
            <x-input type="text" id="email" wire:model.defer="filter.manager_email" placeholder="Enter Email"></x-input>
        </div>
        <div class="form-group w-48">
            <x-label for="status">Company Status</x-label>
            <x-select class="form-select w-48" id="status" wire:model.defer="filter.deactivate_at">
                <option value="">Select</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </x-select>
        </div>
        <div class="flex md:flex-row flex-col justify-end items-center w-full">
            <div class="form-group">
                <x-button :isDisabled="false" class="btn-secondary" @click="filter(field)"><em class="fa-solid fa-sliders"></em> FILTER</x-button>
            </div>
            <div class="form-group">
                <x-button :isDisabled="false" class="btn-outline-primary" id="save_filter" data-bs-toggle="modal"
                data-bs-target="#save-filter"><em class="fa-solid fa-floppy-disk"></em>SAVE FILTER</x-button>
            </div>
            <x-nav-link href="javascript:;" wire:click.prevent="clear()">Clear All</x-nav-link>
        </div>
    </div>
    <div>
        <div class="flex md:flex-row flex-col justify-between mb-4">
            <div class="entries md:order-1 order-2 md:mt-0 mt-3">
                <div class="form-group">
                    <x-label class="text-b">Showing</x-label>
                    <select class="form-select" aria-label="Default select example" wire:model="perPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                    <span>entries</span>
                </div>
            </div>
            <div class="popover-box md:ml-2 ml-0 md:order-2 order-1">
                <x-button :isDisabled="false" type="button" class="btn-outline-primary" @click="popover_active=!popover_active"><em class="fa-solid fa-sliders"></em>Customize Table</x-button>
                <div class="popover-content customize-table" :class="popover_active ? 'popover-active' : '' ">
                    <div class="form-check flex items-center">
                        <x-input id="companyid" class="form-check-input" type="checkbox" ::checked="field.id" @change="field.id=!field.id">
                        </x-input>
                        <label class="form-check-label" for="companyid">Company ID</label>
                    </div>
                    <div class="form-check flex items-center">
                        <x-input id="companyname" class="form-check-input" type="checkbox" ::checked="field.name" @change="field.name=!field.name">
                        </x-input>
                        <label class="form-check-label" for="companyname">Company Name</label>
                    </div>
                    <div class="form-check flex items-center">
                        <x-input id="companyemail" class="form-check-input" type="checkbox" ::checked="field.manager_email" @change="field.manager_email=!field.manager_email">
                        </x-input>
                        <label class="form-check-label" for="companyemail">Company Email</label>
                    </div>
                    <div class="form-check flex items-center">
                        <x-input id="managername" class="form-check-input" type="checkbox" ::checked="field.company_manager_name" @change="field.company_manager_name=!field.company_manager_name">
                        </x-input>
                        <label class="form-check-label" for="managername">Company Manager Name</label>
                    </div>
                    <div class="form-check flex items-center">
                        <x-input id="companystatus" class="form-check-input" type="checkbox" ::checked="field.deactivate_at" @change="field.deactivate_at=!field.deactivate_at">
                        </x-input>
                        <label class="form-check-label" for="companystatus">Status</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-border">
            <table class="admin-table" aria-label="">

                <thead>
                    <tr>
                        <th scope="col" class="id-width" x-show="field.id">
                            <a wire:click.prevent="sortBy('id')" role="button" href="#">
                                Company id
                                @include('components._sort-icon', ['field' => 'id'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.name">
                            <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                Company Name
                                @include('components._sort-icon', ['field' => 'name'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.manager_email">
                            <a wire:click.prevent="sortBy('manager_email')" role="button" href="#">
                                Company Email
                                @include('components._sort-icon', ['field' => 'manager_email'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.company_manager_name">
                            <a wire:click.prevent="sortBy('manager_first_name')" role="button" href="#">
                                Company Manager Name
                                @include('components._sort-icon', ['field' => 'manager_first_name'])
                            </a>
                        </th>
                        <th scope="col" x-show="field.deactivate_at">
                            <a wire:click.prevent="sortBy('deactivate_at')" role="button" href="#">
                                Status
                                @include('components._sort-icon', ['field' => 'deactivate_at'])
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $company)
                    <tr>
                        <td x-show="field.id">{{ $company->id }}</td>
                        <td x-show="field.name">{{ $company->name }}</td>
                        <td x-show="field.manager_email">{{ $company->manager_email }}</td>
                        <td x-show="field.company_manager_name">{{ $company->fullName }}</td>
                        <td x-show="field.deactivate_at" @class([ 's-active'=> is_null($company->deactivate_at),
                            's-inactive' => !is_null($company->deactivate_at),
                            ])>
                            {{ is_null($company->deactivate_at) ? 'Active' : 'Inactive' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No Record Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
{{ $data->links() }}
<x-modal id="save-filter">
    <form wire:submit.prevent="saveFilter()">
        <div class="modal-header flex flex-shrink-0 items-center justify-center pb-0 rounded-t-md">
            <h5 class="text-xl text-center font-medium leading-normal text-gray-800 mt-5 pt-5" id="exampleModalScrollableLabel">
                Filter Name
            </h5>
        </div>
        <div class="modal-body flex justify-center relative p-4">
            <div>
                <div class="form-group">
                    <x-input class="form-control modal-input" type="text" wire:model.defer="filterName"></x-input>
                    @error('filterName') <span class="invalid mt-2 text-center">{{ $message }}</span> @enderror
                </div>
            </div>

        </div>
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center pt-0 rounded-b-md mb-5 pb-5">
            <x-button :isDisabled="false" type="submit" class="btn-primary uppercase" data-bs-dismiss="modal"><em class="fa-solid fa-check"></em> Save</x-button>
            <x-button :isDisabled="false" type="button" class="btn-gray uppercase ml-2" data-bs-dismiss="modal"><em class="fa-solid fa-sliders"></em> Cancel</x-button>
        </div>
    </form>
</x-modal>
    {{ $data->links() }}
</div>
</div>
<script>
    function customizeTable() {
        return {
            popover_active:false,
            field: @json($customizeField)
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.hook('message.received', (el, component) => {
            if (component.serverMemo.data.isClear) {
                window.location.reload();
            }
            if (Array.isArray(component.serverMemo.errors.filterName)) {
                setTimeout(() => {
                    document.getElementById("save_filter").click();
                }, 300);
            }
        });
    });
    function initFilterReport(element) {
        if (element.value) {
            let filters = JSON.parse(element.dataset.dynamicoption);
            window.livewire.emitTo('table', 'customizeFilter', filters);
        }
    }
    function exportPdfReportCompany(field) {
        window.livewire.emitTo('table', 'exportPdfReportCompany', field, 'pdf');
        document.getElementById("export-pdf").disabled = true;
    }

    function exportCsvReportCompany(field) {
        window.livewire.emitTo('table', 'exportCsvReportCompany', field, 'csv');
        document.getElementById("export-csv").disabled = true;
    }
    function filter(field) {
        window.livewire.emitTo('table', 'filter', field);
    }
</script>
</div>
