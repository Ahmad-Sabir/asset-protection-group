<x-app-layout>
    <!-- Content -->
    <div class="main-wrap" x-data="TaskData()">
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>ADD NEW WORK ORDER</h1>
            </div>
        </div>
        <div class="main-content">
            <div class="main-wrapper">
                <div class="admin-tabs">
                    <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <x-nav-link href="#work-order-detail" class="nav-link active" id="work-order-detail-tab" data-bs-toggle="pill" data-bs-target="#work-order-detail" role="tab" aria-controls="work-order-detail" aria-selected="true">
                                CREATE NEW WORK ORDER
                            </x-nav-link>
                        </li>
                    </ul>
                    <form action="{{ route('admin.companies.work-orders.store', [$company->id, 'is_compliance' => $isCompliance ?? null]) }}" method="post" x-data="submitForm()" @submit.prevent="onSubmitPost" id="work-order-post-form">
                        <div class="tab-content" id="tabs-tabContent">
                            <div class="tab-pane fade show active" id="work-order-detail" role="tabpanel" aria-labelledby="work-order-detail-tab">
                                <div class="tab-content-wrapper">
                                    <div class="form-group">
                                        <div class="image-upload">
                                            <x-dropzone name="work_order_profile_id" id="work_order_profile_id"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <x-label for="flag">Flag</x-label>
                                        <label for="flag">
                                            <x-input type="checkbox" id="flag" class="form-check-input" name="flag" x-bind:class="errorMessages.flag ? 'invalid' : ''" style="display:none;width: 25px;height: 25px;"></x-input>
                                            <i class="fa-regular fa-bookmark"></i>
                                        </label>
                                        <span class="invalid" x-text="errorMessages.flag"></span>
                                    </div>
                                    <div class="form-group">
                                        <x-label for="title" required="true">Work Order Title</x-label>
                                        <x-input type="text" id="title" name="title" placeholder="Title" x-bind:class="errorMessages.title ? 'invalid' : ''"></x-input>
                                        <span class="invalid" x-text="errorMessages.title"></span>
                                    </div>
                                    <div class="form-group">
                                        <x-label for="description">Description</x-label>
                                        <x-textarea id="description" name="description"
                                                    rows="4" cols="5" placeholder="Description"></x-textarea>
                                        <span class="invalid" x-text="errorMessages.description"></span>
                                    </div>
                                    @if (isset($asset) && !empty($asset))
                                        <x-input type="hidden" name="asset_type_id" value="{{ $asset->asset_type_id }}"></x-input>
                                        <x-input type="hidden" name="asset_id" value="{{ $asset->id }}"></x-input>
                                        <x-input type="hidden"  name="location_id" id="location"></x-input>
                                        <x-input type="hidden" name="asset_warranty" value="{{ $asset->warranty_expiry_date }}"></x-input>
                                    @else
                                        <div class="form-group">
                                            <x-label for="asset-type" required="true">Asset Type</x-label>
                                            <livewire:dynamic-dropdown
                                                name="asset_type_id"
                                                :where="[
                                                    ['type', '=', config('apg.type.company')],
                                                    ['company_id', '=', $company->id],
                                                ]"
                                                entity="\App\Models\Admin\Asset\AssetType"
                                                entity-select-fields="id, name"
                                                :entity-search-fields="['name']"
                                                entity-field="id"
                                                entity-display-field="name"
                                                >
                                                <span class="invalid" x-text="errorMessages.asset_type_id"></span>
                                        </div>
                                        <div class="form-group">
                                            <x-label for="asset" required="true">Asset</x-label>
                                            <x-select id="asset" name="asset_id" onchange="handleSelectAsset(event)" x-bind:class="errorMessages.asset_id ? 'invalid' : ''">
                                                <option selected disabled>Select Asset Type First</option>
                                            </x-select>
                                            <span class="invalid" x-text="errorMessages.asset_id"></span>
                                        </div>
                                        <div class="form-group">
                                            <x-label for="priority">Set Priority</x-label>
                                            <x-select id="priority" name="priority"  x-bind:class="errorMessages.priority ? 'invalid' : ''">
                                                <option selected disabled>Select Priority</option>
                                                @forelse (config('apg.priority') as $priority)
                                                <option value="{{$priority}}">{{$priority}}</option>
                                                @empty
                                                @endforelse
                                            </x-select>
                                            <span class="invalid" x-text="errorMessages.priority"></span>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                        <x-label for="work_order_type" required="true">Work Order Type</x-label>
                                        <x-select id="work_order_type" onchange="handleOrderType(event)" name="work_order_type" x-bind:class="errorMessages.work_order_type ? 'invalid' : ''">
                                            @forelse (config('apg.work_order_type') as $work_order_type)
                                            <option value="{{$work_order_type}}">{{$work_order_type}}</option>
                                            @empty
                                            @endforelse
                                        </x-select>
                                        <span class="invalid" x-text="errorMessages.work_order_type"></span>
                                    </div>
                                    <div class="form-group" id="work_type">
                                        <x-label for="work_order_frequency" required="true">Work Order Frequency</x-label>
                                        <x-select id="work_order_frequency" name="work_order_frequency" x-bind:class="errorMessages.work_order_frequency ? 'invalid' : ''">
                                            <option selected disabled>Select Frequency</option>
                                            @forelse (config('apg.frequency') as $frequency)
                                            <option value="{{$frequency}}">{{$frequency}}</option>
                                            @empty
                                            @endforelse
                                        </x-select>
                                        <span class="invalid" x-text="errorMessages.work_order_frequency"></span>
                                    </div>
                                    <div class="form-group" id="due_d">
                                        <x-label for="due_date" required="true">Due Date</x-label>
                                        <x-date-picker id="due_date" name="due_date" placeholder="Select Due Date"
                                        x-bind:class="errorMessages.due_date ? 'invalid' : ''" autocomplete="off" data-input></x-date-picker>
                                        <span class="invalid" x-text="errorMessages.due_date"></span>
                                    </div>
                                        <div class="form-group">
                                        @php
                                            $concat = "concat(first_name, ' ', last_name)";
                                        @endphp
                                        <x-label for="" required="true">Assigned Employee</x-label>
                                         <livewire:dynamic-dropdown
                                            name="assignee_user_id"
                                            :where="[
                                                ['company_id', '=', $company->id],
                                            ]"
                                            entity="\App\Models\User"
                                            entity-select-fields="id, first_name, last_name"
                                            :entity-search-fields="[$concat]"
                                            entity-field="id"
                                            entity-display-field="full_name"
                                            :entity_id="$companyUser->id ?? ''"
                                            >
                                        <span class="invalid" x-text="errorMessages.assignee_user_id"></span>
                                    </div>
                                    <div class="form-group">
                                        <x-label for="qualification">Employee Qualification</x-label>
                                        <x-select id="qualification" name="qualification" placeholder="Assigned Employee"
                                                  x-bind:class="errorMessages.qualification ? 'invalid' : ''">
                                            <option selected disabled>Select Qualification</option>
                                            @forelse (config('apg.qualification') as $qualification)
                                                <option value="{{$qualification}}">{{$qualification}}</option>
                                                @empty
                                                @endforelse
                                            </x-select>
                                            <span class="invalid" x-text="errorMessages.qualification"></span>
                                        </div>
                                        <div class="form-group">
                                            <x-label for="location">Location</x-label>
                                            <x-input name="location_id" type="hidden" id="location"></x-input>
                                            <x-input name="asset_warranty" type="hidden" id="warranty"></x-input>
                                            <x-input disabled id="locationName" x-bind:class="errorMessages.location ? 'invalid' : ''"></x-input>
                                            <span class="invalid" x-text="errorMessages.location"></span>
                                        </div>
                                    <x-label class="text-sm gray1" for="media_ids">Attached Files</x-label>
                                    <div class="image-upload mb-4">
                                        <x-dropzone name="media_ids" id="media_ids" multiFiles="50"/>
                                    </div>
                                    <div class="form-group">
                                        <x-label for="additional_info">Additional Information</x-label>
                                        <x-textarea id="additional_info" name="additional_info"
                                                    rows="4" cols="5" placeholder="Additional Information"></x-textarea>
                                        <span class="invalid" x-text="errorMessages.additional_info"></span>
                                    </div>
                                    <div class="additional-task" style="display: flex;align-items: baseline;justify-content: space-between;">
                                        <h5>ADDITIONAL TASKS</h5> <a data-bs-toggle="offcanvas" data-bs-target="#add-additional-task">+ Add Task</a>
                                    </div>
                                    <hr>
                                    <div class="form-group" id="append_tasks" >
                                            <template x-for="(task,index) in tasks" :key="index">
                                            <div class="mb-4 border-b pb-3">
                                                <div class="ml-4">
                                                    <input type="hidden" name="task_id[]" x-model="task.id">
                                                    <button class="primary" @click.prevent="editData(task,index)" data-bs-toggle="offcanvas" data-bs-target="#edit-additional-task">
                                                        <em class="fa-solid fa-pen" aria-hidden="true"></em></button>
                                                        <input type="hidden" :name="`task_data[${index}][name]`" x-model="task.name">
                                                        <input type="hidden" :name="`task_data[${index}][task_detail]`" x-model="task.task_detail">
                                                        <input type="hidden" :name="`task_data[${index}][due_date]`" x-model="task.due_date">
                                                    <h3 x-text="task.name"></h3>
                                                    <p x-text="task.task_detail"></p>
                                                    <label for="due_date">Due Date:</label>
                                                    <p id="due_date" x-text="task.due_date"></p>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="form-group">
                                        <x-button type="submit" class="btn-primary">
                                            <em class="fa-solid fa-check"></em>  ADD WORK ORDER
                                        </x-button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- tabs end --}}
                </div>
                <x-right-modal id="add-additional-task" heading="Add Task">
                    <form @submit.prevent="saveData" id="additional-task-post-form">
                        <div class="form-group">
                            <x-label for="name" value="Task Name" required="true"/>
                            <x-input type="text" class="form-control" x-model="form.name" id="name" name="name" x-bind:class="errorTaskMessages.name ? 'invalid' : ''" placeholder="Name"/>
                            <span class="invalid" x-text="errorTaskMessages.name"></span>
                        </div>
                        <div class="form-group">
                            <x-label for="date_due">Due Date</x-label>
                            <x-date-picker id="date_due" name="due_date" class="form-control" x-model="form.due_date" x-bind:class="errorTaskMessages.due_date ? 'invalid' : ''" placeholder="Due Date" />
                            <span class="invalid" x-text="errorTaskMessages.due_date"></span>
                        </div>
                        <div class="form-group w-full">
                            <x-label for="task_detail">Task Details</x-label>
                            <x-textarea id="task_detail" class="form-control w-full" x-model="form.task_detail" name="task_detail"
                                        rows="4" cols="20"></x-textarea>
                            <span class="invalid" x-text="errorTaskMessages.task_detail"></span>
                        </div>
                        <x-button type="submit" class="btn-primary">
                            <em class="fa-solid fa-check"></em>  ADD Task
                        </x-button>

                    </form>
                </x-right-modal>
                <x-right-modal id="edit-additional-task" heading="Edit Task">
                    <form @submit.prevent="updateData" id="additional-task-patch-form">
                        <div>
                            <div class="form-group">
                                <x-label for="name" value="Task Name" required="true"/>
                                <x-input type="text" class="form-control" id="edit-name" x-model="form.name" name="name" x-bind:class="errorTaskMessages.name ? 'invalid' : ''"/>
                                <span class="invalid" x-text="errorTaskMessages.name"></span>
                            </div>
                            <input type="hidden" name="id" x-model="form.id">
                            <div class="form-group">
                                <x-label for="date_due">Due Date</x-label>
                                <x-date-picker id="edit-date_due" x-model="form.due_date" name="due_date" class="form-control" x-bind:class="errorTaskMessages.due_date ? 'invalid' : ''" placeholder="Due Date"/>
                                <span class="invalid" x-text="errorTaskMessages.due_date"></span>
                            </div>
                            <div class="form-group w-full">
                                <x-label for="task_detail">Task Details</x-label>
                                <x-textarea id="edit-task_detail" x-model="form.task_detail" class="form-control w-full" name="task_detail"
                                            rows="4" cols="20"></x-textarea>
                            </div>
                            <x-button type="submit" class="btn-primary">
                                <em class="fa-solid fa-check"></em> EDIT Task
                            </x-button>
                        </div>
                    </form>
                </x-right-modal>
            </div>
        </div>
    </div>
    @include('custom-create-task-js');
</x-app-layout>
