<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">

        <!-- Validation Errors -->
        <x-alert-message class="mb-4" :errors="$errors" />

        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>Manage Companies</h1>
            </div>
            <div class="top-buttons">
                <div class="form-group">
                    <x-button type="submit" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-company">
                        <em class="fa-solid fa-user-plus"></em> ADD New Company
                    </x-button>
                </div>
            </div>
        </div>
        <div class="main-content">
            <livewire:table
                :model="App\Models\Company::class"
                :relations="['profile']"
                view-file="admin.company.table"
            />
            <livewire:sweet-alert component="table" entityTitle="company"/>
        </div>
    </div>
    <x-right-modal id="edit-company" heading="Company Details">
        <form action="" method="post" x-data="submitForm()" @submit.prevent="onSubmitPut" id="company-patch-form">
            <div x-show="formData.show">
                <table class="admin-table mt-4" aria-label="">
                <th></th>
                    <tbody>
                        <div class="upload-image">
                            <div class="image">
                                <img :src=`${formData.profile?.url}` alt="">
                            </div>
                            <div class="profile-name">
                                <h3 class="full-name"><span x-text="formData.name"></span></h3>
                            </div>
                        </div>
                        <tr class="border-b">
                            <td class="gray3">Company Id</td>
                            <td class="text-right"><span x-text="formData.id"></span></td>
                        </tr>
                        <tr class="border-b">
                            <td class="gray3">Manager Full Name</td>
                            <td class="text-right"><span x-text="formData.manager_first_name"></span> <span x-text="formData.manager_last_name"></span></td>
                        </tr>
                        <tr class="border-b">
                            <td class="gray3">Manager Email</td>
                            <td class="text-right" x-text="formData.manager_email"></td>
                        </tr>
                        <tr class="border-b">
                            <td class="gray3">Status</td>
                            <td class="text-right" x-text="formData.deactivate_at == null ? 'Active' : 'Inactive'"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div x-show="formData.edit">
                <div class="form-group">
                    <x-dropzone name="profile_media_id" id="edit_media_id" ::media="formData.profile"/>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Manager First Name" required="true"/>
                    <x-input type="text" class="form-control" x-model="formData.manager_first_name" id="manager_first_name" name="manager_first_name" x-bind:class="errorMessages.manager_first_name ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.manager_first_name"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Manager Last Name" required="true"/>
                    <x-input type="text" class="form-control" x-model="formData.manager_last_name" id="manager_last_name" name="manager_last_name" x-bind:class="errorMessages.manager_last_name ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.manager_last_name"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Company Name" required="true"/>
                    <x-input type="text" class="form-control" x-model="formData.name" id="name" name="name" x-bind:class="errorMessages.name ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.name"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Designation" required="true"/>
                    <x-input type="text" class="form-control" x-model="formData.designation" id="designation" name="designation" x-bind:class="errorMessages.designation ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.designation"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Manager Phone" required="true"/>
                    <x-input type="text" class="form-control" x-model="formData.manager_phone" id="manager_phone" name="manager_phone" x-bind:class="errorMessages.manager_phone ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.manager_phone"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Manager Email" required="true"/>
                    <x-input type="email" class="form-control" x-model="formData.manager_email" id="manager_email" name="manager_email" x-bind:class="errorMessages.manager_email ? 'invalid' : ''" readonly/>
                    <span class="invalid" x-text="errorMessages.manager_email"></span>
                </div>
                <div class="form-group">
                    <x-label for="status">Status</x-label>
                    <x-select class="w-full" id="status" name="status">
                        ::disabled="formData.id == {{auth()->Id()}} || formData.status == 'super-admin'" x-bind:class="errorMessages.status ? 'invalid' : ''">
                        <option value="1" :selected="formData.deactivate_at == null">Active</option>
                        <option value="0" :selected="formData.deactivate_at != null">Inactive</option>
                    </x-select>
                    <span class="invalid" x-text="errorMessages.Status"></span>
                </div>
                <x-button type="submit" class="btn-primary">
                    <em class="fa-solid fa-check"></em> EDIT COMPANY
                </x-button>
            </div>
        </form>
    </x-right-modal>
    <x-right-modal id="add-company" heading="Add New Company">
        <form action="{{ route('admin.companies.store') }}" method="post" x-data="submitForm()" @submit.prevent="onSubmitPost" id="company-post-form">
            <div class="form-group">
                <x-dropzone name="profile_media_id"/>
            </div>
            <div class="form-group">
                <x-label for="email" value="Manager First Name" required="true"/>
                <x-input type="text" class="form-control" id="manager_first_name" name="manager_first_name" x-bind:class="errorMessages.manager_first_name ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.manager_first_name"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Manager Last Name" required="true"/>
                <x-input type="text" class="form-control" id="manager_last_name" name="manager_last_name" x-bind:class="errorMessages.manager_last_name ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.manager_last_name"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Company Name" required="true"/>
                <x-input type="text" class="form-control" id="name" name="name" x-bind:class="errorMessages.name ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.name"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Designation" required="true"/>
                <x-input type="text" class="form-control" id="designation" name="designation" x-bind:class="errorMessages.designation ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.designation"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Manager Phone" required="true"/>
                <x-input type="number" class="form-control" id="phone" name="manager_phone" x-bind:class="errorMessages.manager_phone ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.manager_phone"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Manager Email" required="true"/>
                <x-input type="text" class="form-control" id="manager_email" name="manager_email" x-bind:class="errorMessages.manager_email ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.manager_email"></span>
            </div>
            <x-button type="submit" class="btn-primary">
                <em class="fa-solid fa-check"></em> ADD COMPANY
            </x-button>
        </form>
    </x-right-modal>
</x-app-layout>
