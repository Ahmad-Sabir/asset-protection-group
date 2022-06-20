<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>PROFILE DETAILS</h1>
            </div>
        </div>
        <div class="main-content">
            <div class="main-wrapper">
                <div class="admin-tabs">
                    <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <x-nav-link href="#profile-detail" class="nav-link active" id="profile-detail-tab"
                                data-bs-toggle="pill" data-bs-target="#profile-detail" role="tab"
                                aria-controls="profile-detail" aria-selected="true">
                                PROFILE DETAILS
                            </x-nav-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <x-nav-link href="#email-setting" class="nav-link" id="email-setting-tab"
                                data-bs-toggle="pill" data-bs-target="#email-setting" role="tab"
                                aria-controls="email-setting" aria-selected="true">
                                NOTIFICATION SETTING
                            </x-nav-link>
                        </li>
                    </ul>
                    <form action="{{ route('employee.update-profile', $user->id) }}" method="put" x-data="submitForm()"
                        @submit.prevent="onSubmitPut" id="profile-post-form">
                        <div class="tab-content relative" id="tabs-tabContent">
                            <div class="md:absolute relative md:top-10 md:right-5 md:mb-0 mb-3">
                                <x-nav-link href="{{ route('employee.get-profile', ['is_edit' => request()->get('is_edit') ? false : true]) }}" class="btn btn-primary anchor-btn w-full-btn">
                                    <em class="fa-solid fa-check"></em>
                                    {{ request()->get('is_edit') ? 'VIEW PROFILE' : 'EDIT PROFILE' }}
                                </x-nav-link>
                            </div>
                            <div class="tab-pane fade show active" id="profile-detail" role="tabpanel"
                                aria-labelledby="profile-detail-tab">
                                <div class="tab-content-wrapper tab-content-full">
                                    <div class="grid md:grid-cols-2 grid-cols-1 gap-4">
                                        <div>
                                            <div class="form-group">
                                                @if (request()->get('is_edit'))
                                                    <div class="image-upload">
                                                        <x-dropzone name="profile_media_id"
                                                        :media="$user->profile()->first()" id="profile_media_id" />
                                                    </div>
                                                @else
                                                    <div class="upload-image">
                                                        <div class="image">
                                                            <img src="{{ $user->profile()->first()?->url }}" alt="">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <x-label for="first_name">First Name</x-label>
                                                <x-input type="text" id="first_name" value="{{$user->first_name}}"
                                                    name="first_name"
                                                    placeholder="First Name"
                                                    x-bind:class="errorMessages.first_name ? 'invalid' : ''"
                                                    disabled="{{ request()->get('is_edit') ? false : true }}">
                                                </x-input>
                                                <span class="invalid" x-text="errorMessages.first_name"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="last_name">Last Name</x-label>
                                                <x-input type="text" id="last_name" value="{{$user->last_name}}"
                                                    name="last_name" placeholder="Last Name"
                                                    x-bind:class="errorMessages.last_name ? 'invalid' : ''"
                                                    disabled="{{ request()->get('is_edit') ? false : true }}">
                                                </x-input>
                                                <span class="invalid" x-text="errorMessages.last_name"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="email">Email</x-label>
                                                <x-input type="email" id="email" name="email" value="{{$user->email}}"
                                                    placeholder="Email"
                                                    x-bind:class="errorMessages.email ? 'invalid' : ''" readonly>
                                                </x-input>
                                                <span class="invalid" x-text="errorMessages.email"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="password">Enter current password</x-label>
                                                <x-input type="password" id="current_password" name="current_password"
                                                    placeholder="Enter current password"
                                                    x-bind:class="errorMessages.current_password ? 'invalid' : ''"
                                                    disabled="{{ request()->get('is_edit') ? false : true }}">
                                                </x-input>
                                                <span class="invalid" x-text="errorMessages.current_password"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="password">Enter new password</x-label>
                                                <x-input type="password" id="password" placeholder="Enter new password"
                                                    class="form-control" name="password"
                                                    x-bind:class="errorMessages.password ? 'invalid' : ''"
                                                    disabled="{{ request()->get('is_edit') ? false : true }}">
                                                </x-input>
                                                <span class="invalid" x-text="errorMessages.password"></span>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="password">Enter password confirmation</x-label>
                                                <x-input type="password" id="confirm_password"
                                                    class="form-control col-md-7 col-xs-12"
                                                    placeholder="Enter password confirmation" name="confirm_password"
                                                    x-bind:class="errorMessages.confirm_password ? 'invalid' : ''"
                                                    disabled="{{ request()->get('is_edit') ? false : true }}">
                                                </x-input>
                                                <span class="invalid" x-text="errorMessages.confirm_password"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="email-setting" role="tabpanel"
                                aria-labelledby="email-setting-tab">
                                <div class="grid grid-cols-2 gap-5 mb-10">
                                    <div>
                                        <table class="admin-table mt-4" aria-label="">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Notification</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="border-b">
                                                    <td>WORK ORDER ASSIGNED TO EMPLOYEE</td>
                                                    <td>
                                                        <x-toggle-checkbox name="email_setting[assigned_workorder]" value=1
                                                            :checked="Arr::get($user->email_setting, 'assigned_workorder') == 1 ? 'checked' : ''"
                                                            :disabled="request()->get('is_edit') ? '' : 'disabled'"
                                                        >
                                                        </x-toggle-checkbox>
                                                    </td>
                                                    <td>
                                                        <x-toggle-checkbox name="notification_setting[assigned_workorder]"
                                                            value=1
                                                            :checked="Arr::get($user->notification_setting, 'assigned_workorder') == 1 ? 'checked' : ''"
                                                            :disabled="request()->get('is_edit') ? '' : 'disabled'"
                                                        >
                                                        </x-toggle-checkbox>
                                                    </td>
                                                </tr>
                                                <tr class="border-b">
                                                    <td>WORK ORDER REMINDER TO EMPLOYEE</td>
                                                    <td>
                                                        <x-toggle-checkbox name="email_setting[reminder_workorder]" value=1
                                                            :checked="Arr::get($user->email_setting, 'reminder_workorder') == 1 ? 'checked' : ''"
                                                            :disabled="request()->get('is_edit') ? '' : 'disabled'"
                                                        >
                                                        </x-toggle-checkbox>
                                                    </td>
                                                    <td>
                                                        <x-toggle-checkbox name="notification_setting[reminder_workorder]"
                                                            value=1
                                                            :checked="Arr::get($user->notification_setting, 'reminder_workorder') == 1 ? 'checked' : ''"
                                                            :disabled="request()->get('is_edit') ? '' : 'disabled'"
                                                        >
                                                        </x-toggle-checkbox>
                                                    </td>
                                                </tr>
                                                <tr class="border-b">
                                                    <td>WORK ORDER OVERDUE TO EMPLOYEE</td>
                                                    <td class="text-right">
                                                        <x-toggle-checkbox name="email_setting[overdue_workorder]" value=1
                                                            :checked="Arr::get($user->email_setting, 'overdue_workorder') == 1 ? 'checked' : ''"
                                                            :disabled="request()->get('is_edit') ? '' : 'disabled'"
                                                        >
                                                        </x-toggle-checkbox>
                                                    </td>
                                                    <td>
                                                        <x-toggle-checkbox name="notification_setting[overdue_workorder]"
                                                            value=1
                                                            :checked="Arr::get($user->notification_setting, 'overdue_workorder') == 1 ? 'checked' : ''"
                                                            :disabled="request()->get('is_edit') ? '' : 'disabled'"
                                                        >
                                                        </x-toggle-checkbox>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if (request()->get('is_edit'))
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div class="form-group">
                                    <x-button type="submit" class="btn-primary w-full">
                                        <em class="fa-solid fa-check"></em> EDIT PROFILE
                                    </x-button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </form>
                    {{-- tabs end --}}
                </div>
            </div>
            {{-- tabs end --}}
        </div>
    </div>

    </div>
    </div>
</x-app-layout>
