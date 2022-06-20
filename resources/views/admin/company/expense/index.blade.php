<x-app-layout>
    <x-company-layout :company="$company">
        <div class="main-fixed-wrap">
            <div class="heading">
            </div>
            <div class="top-buttons gap-3">
                <x-button type="button" id="export-pdf" onclick="pdfExport()" class="btn btn-primary">
                    <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
                </x-button>
                <x-button type="button" id="export-csv" onclick="csvExport()" class="btn btn-primary">
                    <em class="fa-solid fa-cloud-arrow-down"></em> Download CSV
                </x-button>
                <x-button type="submit" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-expenses">
                    <em class="fa-solid fa-circle-plus"></em> ADD EXPENSE
                </x-button>
            </div>
        </div>
            <div class="main-content">
                <livewire:expense-table :model="App\Models\Expense::class"
                :where="[['company_id', '=', $company->id]]"
                 view-file="admin.company.expense.table"
                :companyId="$company->id"/>
                <livewire:sweet-alert component="expense-table" entityTitle="Expense" />
            </div>
        </div>
        <x-right-modal id="edit-assettype" heading="Edit Expense">
            <form action="" method="post" x-data="submitForm()" @submit.prevent="onSubmitPut" id="expense-patch-form">
                <div x-show="formData.show">
                    <table class="admin-table mt-4" aria-label="">
                        <th></th>
                        <tbody>
                            <tr class="border-b">
                                <td class="gray3">Id</td>
                                <td class="text-right" x-text="formData.id"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="gray3">Date</td>
                                <td class="text-right" x-text="formData.expense_date"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="gray3">Type</td>
                                <td class="text-right" x-text="formData.type"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="gray3">Description</td>
                                <td class="text-right" x-text="formData.description"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="gray3">Amount</td>
                                <td class="text-right" x-text="formData.amount"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="gray3">Work Order Id</td>
                                <td class="text-right" x-text="formData.work_order?.number"></td>
                            </tr>
                            <tr class="border-b">
                                <td class="gray3">Asset Id</td>
                                <td class="text-right" x-text="formData.work_order?.asset?.number"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div x-show="formData.edit">
                    <div class="form-group">
                        <x-label for="expense_date">Expense Date</x-label>
                        <x-date-picker id="edit_expense_date" name="expense_date"
                            autocomplete="off" data-input maxDate="true" x-model="formData.expense_date">
                        </x-date-picker>
                        <span class="invalid" x-text="errorMessages.expense_date"></span>
                    </div>
                    <div class="form-group">
                        <x-label for="type">Type</x-label>
                        <x-select class="w-full" id="type" name="type">
                            <option value="employee-payment" :selected="formData.type == 'employee-payment'">Employee Payment</option>
                            <option value="maintenance-material":selected="formData.type  == 'maintenance-material'" >Maintenance Material</option>
                        </x-select>
                        <span class="invalid" x-text="errorMessages.role"></span>
                    </div>
                    <div class="form-group">
                        <x-label for="description" value="Description" />
                        <x-textarea id="description" class="form-control" x-model="formData.description" name="description"
                        rows="4" cols="20"></x-textarea>
                        <span class="invalid" x-text="errorMessages.description"></span>
                    </div>
                    <div class="form-group">
                        <x-label for="amount" value="Amount" />
                        <x-input type="number" class="form-control" x-model="formData.amount" id="amount" name="amount"
                            x-bind:class="errorMessages.amount ? 'invalid' : ''" />
                        <span class="invalid" x-text="errorMessages.amount"></span>
                    </div>
                    <div class="form-group">
                        <x-input type="hidden" class="form-control" x-model="formData.work_order_id" id="work_order_id" name="work_order_id"
                            x-bind:class="errorMessages.work_order_id ? 'invalid' : ''" />
                        <span class="invalid" x-text="errorMessages.work_order_id"></span>
                    </div>
                    <x-button type="submit" class="btn-primary">
                        <em class="fa-solid fa-check"></em> EDIT Expense
                    </x-button>
                </div>
            </form>
        </x-right-modal>
        <x-right-modal id="add-expenses" heading="Add Expense">
            <form action="{{ route('admin.companies.expenses.store', $company->id) }}" method="post" x-data="submitForm()"
                @submit.prevent="onSubmitPost" id="expense-post-form">
                <div class="form-group">
                    <x-label for="expense_date">Expense Date</x-label>
                    <x-date-picker id="expense_date" name="expense_date"
                        autocomplete="off" data-input maxDate="true">
                    </x-date-picker>
                    <span class="invalid" x-text="errorMessages.expense_date"></span>
                </div>
                <div class="form-group">
                    <x-label for="type" required="true">Expense Type</x-label>
                    <x-select class="w-full" id="type" name="type">
                        <option value="">Select</option>
                        <option value="employee-payment" :selected="formData.type == 'employee-payment'">Employee Payment</option>
                        <option value="maintenance-material":selected="formData.type  == 'maintenance-material'" >Maintenance Material</option>
                    </x-select>
                    <span class="invalid" x-text="errorMessages.type"></span>
                </div>
                <div class="form-group">
                    <x-label for="description" value="Description" required="true"/>
                    <x-textarea id="description" class="form-control"  name="description"
                    rows="4" cols="20"></x-textarea>
                    <span class="invalid" x-text="errorMessages.description"></span>
                </div>
                <div class="form-group">
                    <x-label for="amount" value="Amount" required="true"/>
                    <x-input type="number" class="form-control" id="amount" name="amount" x-bind:class="errorMessages.amount ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.amount"></span>
                </div>
                <div class="form-group">
                    <x-label for="work_order_id" required="true">Work Order</x-label>
                    <livewire:dynamic-dropdown
                    name="work_order_id"
                    entity="\App\Models\Admin\WorkOrder\WorkOrder"
                    :where="[
                        ['type', '=', config('apg.type.company')],
                        ['company_id', '=', $company->id]
                    ]"
                    entity-select-fields="id, title , asset_id"
                    :entity-search-fields="['title']"
                    entity-field="id"
                    entity-display-field="title"
                    :entity_id="request('work_order_id')"
                    isDataAttribute="true"
                    onChangeFunc="initExpense"
                    >
                    <span class="invalid" x-text="errorMessages.work_order_id"></span>
                </div>
                <div class="form-group">
                    <x-label for="asset_id" value="Asset Id" required="true"/>
                    <x-input type="text" class="form-control" id="asset_id" name="asset_id"
                    x-bind:class="errorMessages.asset_id ? 'invalid' : ''" x-model="formData.asset_id" readonly/>
                    <span class="invalid" x-text="errorMessages.asset_id"></span>
                </div>
                <x-button type="submit" class="btn-primary">
                    <em class="fa-solid fa-check"></em> ADD Expense
                </x-button>
            </form>
        </x-right-modal>
    </x-company-layout>
    @push('script')
    <script>
        initExpense = (option) => {
            if (option.value) {
                let work0rder = JSON.parse(option.dataset.dynamicoption);
                document.querySelector('#expense-post-form')._x_dataStack[0].formData.asset_id = work0rder.asset_id;
            }
        }

        function pdfExport() {
            window.livewire.emitTo('expense-table', 'pdfExport', 'pdf');
            document.getElementById("export-pdf").disabled = true;
        }

        function csvExport() {
            window.livewire.emitTo('expense-table', 'csvExport', 'csv', "{{ config('apg.type.company') }}");
            document.getElementById("export-csv").disabled = true;
        }
    </script>
    @endpush
    </x-app-layout>>
