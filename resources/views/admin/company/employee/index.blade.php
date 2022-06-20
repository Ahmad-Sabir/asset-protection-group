<x-app-layout>
<x-company-layout :company="$company">
    <div class="main-fixed-wrap">
        <div class="top-buttons gap-3">
            <x-button type="button" id="export-csv" onclick="csvExport()" class="btn btn-outline-primary">
                <em class="fa-solid fa-cloud-arrow-down"></em> CSV Download
            </x-button>
            <x-button type="submit" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-employee">
                <em class="fa-solid fa-user-plus"></em> ADD Employee
            </x-button>
        </div>
    </div>
    <div class="main-content">
        <livewire:company.employee-table
        :where="[['company_id', '=', $company->id]]"
        view-file="admin.company.employee.table"
        :companyId="$company->id"
        />
    </div>
    <livewire:sweet-alert component="company.employee-table" entityTitle="Employee"/>
    <x-right-modal id="edit-employee" heading="Employee Detail">
        <form action="" method="post" x-data="submitForm()" @submit.prevent="onSubmitPut" id="employee-patch-form">
            <div x-show="formData.show">
                <table class="admin-table mt-4" aria-label="">
                    <th></th>
                    <tbody>
                        <div class="upload-image">
                            <div class="image">
                                <img :src=`${formData.profile?.url}` alt="">
                            </div>
                            <div class="profile-name">
                                <h3 class="full-name"><span x-text="formData.first_name"></span> <span x-text="formData.last_name"></span></h3>
                            </div>
                        </div>
                        <tr class="border-b">
                            <td class="gray3">Full Name</td>
                            <td class="text-right"><span x-text="formData.first_name"></span> <span x-text="formData.last_name"></span></td>
                        </tr>
                        <tr class="border-b">
                            <td class="gray3">Email</td>
                            <td class="text-right" x-text="formData.email"></td>
                        </tr>
                        <tr class="border-b">
                            <tr class="border-b">
                            <td class="gray3">Phone</td>
                            <td class="text-right" x-text="formData.phone"></td>
                        </tr>
                        <tr class="border-b">
                            <td class="gray3">Rate Per Hour</td>
                            <td class="text-right" x-text="formData.per_hour_rate"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div x-show="formData.edit">
                <div class="form-group">
                    <x-dropzone name="profile_media_id" id="edit_media_id" ::media="formData.profile"/>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Employee First Name" required="true"/>
                    <x-input type="text" class="form-control" x-model="formData.first_name" id="first_name" name="first_name" x-bind:class="errorMessages.first_name ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.first_name"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Employee Last Name" required="true"/>
                    <x-input type="text" class="form-control" x-model="formData.last_name" id="last_name" name="last_name" x-bind:class="errorMessages.last_name ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.last_name"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Employee Email" required="true"/>
                    <x-input type="text" class="form-control" x-model="formData.email" id="email" name="email" x-bind:class="errorMessages.email ? 'invalid' : ''" readonly/>
                    <span class="invalid" x-text="errorMessages.email"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Employee Phone"/>
                    <x-input type="number" class="form-control" x-model="formData.phone" id="phone" name="phone" x-bind:class="errorMessages.phone ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.phone"></span>
                </div>
                    <div class="form-group">
                    <x-label for="email" value="Employee Rate Per Hour"/>
                    <x-input type="number" class="form-control" x-model="formData.per_hour_rate" id="per_hour_rate" name="per_hour_rate" x-bind:class="errorMessages.per_hour_rate ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.per_hour_rate"></span>
                </div>
                <div class="form-group">
                    <x-label for="status">Status</x-label>
                    <x-select class="w-full" id="status" name="status"
                        ::disabled="formData.id == {{auth()->Id()}} || formData.status == 'super-admin'" x-bind:class="errorMessages.status ? 'invalid' : ''">
                        <option value="1" :selected="formData.deactivate_at == null">Active</option>
                        <option value="0" :selected="formData.deactivate_at != null">Inactive</option>
                    </x-select>
                    <span class="invalid" x-text="errorMessages.Status"></span>
                </div>
                <x-button type="submit" class="btn-primary">
                    <em class="fa-solid fa-check"></em> EDIT EMPLOYEE
                </x-button>
            </div>
        </form>
    </x-right-modal>
    <x-right-modal id="add-employee" heading="Add Employee">
        <form action="{{ route('admin.companies.users.store', $company->id) }}" method="post" x-data="submitForm()" @submit.prevent="onSubmitPost" id="user-post-form">
            <div class="form-group">
                <x-dropzone name="profile_media_id"/>
            </div>
            <div class="form-group">
                <x-label for="email" value="Employee First Name" required="true"/>
                <x-input type="text" class="form-control" id="first_name" name="first_name" x-bind:class="errorMessages.first_name ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.first_name"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Employee Last Name" required="true"/>
                <x-input type="text" class="form-control" id="last_name" name="last_name" x-bind:class="errorMessages.last_name ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.last_name"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Employee Email" required="true"/>
                <x-input type="text" class="form-control" id="email" name="email" x-bind:class="errorMessages.email ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.email"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Employee Phone"/>
                <x-input type="number" class="form-control" id="phone" name="phone" x-bind:class="errorMessages.phone ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.phone"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Employee Rate Per Hour"/>
                <x-input type="number" class="form-control" id="per_hour_rate" name="per_hour_rate" x-bind:class="errorMessages.per_hour_rate ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.per_hour_rate"></span>
            </div>
            <x-button type="submit" class="btn-primary">
                <em class="fa-solid fa-check"></em> ADD EMPLOYEE
            </x-button>
        </form>
    </x-right-modal>
</x-company-layout>
@pushOnce('script')
    <script>
        function csvExport() {
            window.livewire.emitTo('company.employee-table', 'csvExport', 'csv');
            document.getElementById("export-csv").disabled = true;
        }
    </script>
@endPushOnce
</x-app-layout>
