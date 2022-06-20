<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">

        <!-- Validation Errors -->
        <x-alert-message class="mb-4" :errors="$errors" />

        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>Manage Admin Users</h1>
            </div>
            <div class="top-buttons gap-3">
                <form class="md:w-auto w-full" action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="CSVFile" onchange="form.submit()" name="file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" style="display: none">
                    <x-button type="button" class="btn btn-outline-primary" onclick="document.getElementById('CSVFile').click()">
                        <em class="fa-solid fa-cloud-arrow-up"></em> Import Users
                    </x-button>
                    <x-button type="submit" class="btn btn-outline-primary" style="display: none">
                        <em class="fa-solid fa-cloud-arrow-up"></em>
                    </x-button>
                </form>
                <a class="md:w-auto w-full" href="{{ route('admin.users.export') }}">
                    <x-button type="button" class="btn btn-outline-primary">
                        <em class="fa-solid fa-cloud-arrow-down"></em> CSV Template
                    </x-button>
                </a>
                <x-button type="submit" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#add-user">
                    <em class="fa-solid fa-user-plus"></em> ADD USER
                </x-button>
            </div>
        </div>
        <div class="main-content">
                <livewire:table
                    :model="App\Models\User::class"
                    :where="[['company_id', '=', null]]"
                    view-file="admin.user.table"
                    :relations="['profile']"
                    />

                <livewire:sweet-alert component="table" entityTitle="user"/>
        </div>
    </div>
    <x-right-modal id="edit-user" heading="User Details">
        <form action="" method="post" x-data="submitForm()" @submit.prevent="onSubmitPut" id="user-patch-form">
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
                    <x-label for="email" value="First Name" required="true"/>
                    <x-input type="text" class="form-control" x-model="formData.first_name" id="first_name" name="first_name" x-bind:class="errorMessages.first_name ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.first_name"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Last Name" required="true"/>
                    <x-input type="text" class="form-control" x-model="formData.last_name" id="last_name" name="last_name" x-bind:class="errorMessages.last_name ? 'invalid' : ''"/>
                    <span class="invalid" x-text="errorMessages.last_name"></span>
                </div>
                <div class="form-group">
                    <x-label for="email" value="Email" required="true"/>
                    <x-input type="email" class="form-control" x-model="formData.email" id="email" name="email" x-bind:class="errorMessages.email ? 'invalid' : ''" readonly/>
                    <span class="invalid" x-text="errorMessages.email"></span>
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
                    <em class="fa-solid fa-check"></em> EDIT USER
                </x-button>
            </div>
        </form>
    </x-right-modal>
    <x-right-modal id="add-user" heading="Add User">
        <form action="{{ route('admin.users.store') }}" method="post" x-data="submitForm()" @submit.prevent="onSubmitPost" id="user-post-form">
            <div class="form-group">
                <x-dropzone name="profile_media_id"/>
            </div>
            <div class="form-group">
                <x-label for="email" value="First Name" required="true"/>
                <x-input type="text" class="form-control" id="first_name" name="first_name" x-bind:class="errorMessages.first_name ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.first_name"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Last Name" required="true"/>
                <x-input type="text" class="form-control" id="last_name" name="last_name" x-bind:class="errorMessages.last_name ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.last_name"></span>
            </div>
            <div class="form-group">
                <x-label for="email" value="Email" required="true"/>
                <x-input type="email" class="form-control" id="email" name="email" x-bind:class="errorMessages.email ? 'invalid' : ''"/>
                <span class="invalid" x-text="errorMessages.email"></span>
            </div>
            <x-button type="submit" class="btn-primary">
                <em class="fa-solid fa-check"></em> ADD USER
            </x-button>
        </form>
    </x-right-modal>
</x-app-layout>
