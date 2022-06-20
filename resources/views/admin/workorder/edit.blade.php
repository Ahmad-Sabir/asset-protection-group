<x-app-layout>
    <!-- Content -->
      <div class="main-wrap" x-data="TaskData()">
        <div class="main-fixed-wrap md:mt-0 mt-[3.5rem]">
            <div class="heading">
                <h1>{{ $workOrder->title }}</h1>
                <h1>WORK ORDERS DETAILS</h1>
                <p class="gray1">Work Orders > {{$workOrder->number}}</p>
            </div>
        </div>
        <div class="main-content">
            <form action="{{ route('admin.work-orders.update', [$workOrder->id, 'is_compliance' => request()->get('is_compliance')]) }}" method="post" x-data="submitForm()" @submit.prevent="onSubmitPut" id="work-order-put-form">
                <div id="alpine_work_order" class="work-order-details-section" x-data="{ workOrder: {{json_encode($workOrder->only([
                        'id',
                        'assignee_user_id',
                        'asset_id',
                        'work_order_type',
                        'work_order_frequency',
                        'work_order_status',
                        'qualification',
                        ]))}} }">
                    @if ($workOrder->media?->url)
                    <section class="banner-image">
                        <img src="{{$workOrder->media?->url}}" alt="">
                    </section>
                    @endif
                    <div class="main-wrapper">
                        <div class="sm:flex items-center">
                            <p class="gray1">ID {{$workOrder->number}}</p>
                            <div class="sm:ml-auto gray1">
                                <div class="form-group">
                                    <x-button type="submit" class="btn-primary">
                                        <em class="fa-solid fa-check"></em> Save Changes
                                    </x-button>
                                </div>
                            </div>
                        </div>
                        <div class="heading mt-2">
                            <h3>{{$workOrder->title}}</h3>
                        </div>
                        <div class="sm:flex items-center my-3">
                            <div class="form-group">
                                <label class="mt-2">&nbsp;</label>
                                <select class="form-select md:w-auto w-full form-select-green" id= "status_order" name="work_order_status">
                                    @forelse(config('apg.work_order_status') as $status)
                                    <option value="{{$status}}" @selected($status==$workOrder->work_order_status)>{{$status}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group md:ml-3 ml-0">
                                <label class="mt-2">&nbsp;</label>
                                <x-select class="form-select form-select-outline-gray md:w-auto w-full" name="priority">
                                    <option disabled>Select Priority</option>
                                    @forelse(config('apg.priority') as $priority)
                                    <option value="{{$priority}}" @selected($priority==$workOrder->priority)>{{$priority}}</option>
                                    @empty
                                    @endforelse
                                </x-select>
                            </div>
                            <div class="form-group md:ml-3 ml-0" id="on_hold_reason" x-show="workOrder.work_order_status == '{{ config('apg.work_order_status.on_hold') }}'">
                                <label for="hold_reason">On Hold Reason</label>
                                <input type="text" class="form-control w-full md:w-auto" placeholder="Reason" id="hold_reason" name="on_hold_reason" value="{{$workOrder->on_hold_reason}}">
                            </div>
                            <div class="form-group ml-3">
                                <x-label for="flag">Flag</x-label>
                                <label for="flag">
                                    <x-input type="checkbox" id="flag" class="form-check-input" name="flag" x-bind:class="errorMessages.flag ? 'invalid' : ''" style="display:none;"></x-input>
                                    <em class="fa-bookmark @if($workOrder->flag == 'on') fa-solid @else fa-regular @endif"></em>

                                </label>
                                 <span class="invalid" x-text="errorMessages.flag"></span>
                            </div>
                             <div class="sm:ml-auto gray1">
                                <div class="popover-box">
                                    <x-button type="button" class="btn-outline-primary btn-outline-primary-timer popover-trigger0">
                                        <em class="fa-solid fa-stopwatch"></em>
                                         Start Timer
                                    </x-button>
                                    <x-button type="button" class="d-none btn-outline-primary btn-outline-primary-timer popover-trigger0">
                                        <em class="fa-solid fa-stopwatch"></em>
                                        End Timer
                                    </x-button>
                                    <div class="popover-content">
                                        <span class="start-timer">
                                            <em class="fa-solid fa-play" id="start-timer"></em>
                                            <em class="fa-solid fa-pause" id="pause-timer" style="display: none"></em>
                                            <span id="timer">
                                                @if(isset($workOrder->work_order_log_timer)) {{$workOrder->work_order_log_timer}} @else hh:mm:ss @endif
                                            </span>
                                            <br>
                                            <span class="cursor-pointer" id="reset-btn">Reset</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="popover-box ml-2">
                                    <x-button type="button" class="btn-outline-gray-timer popover-trigger"><em class="fa-solid fa-clock"></em>Log Time</x-button>
                                    <div class="popover-content">
                                        <div class="form-group">
                                            <x-input type="text" class="form-control w-full text-lg" id="log-input" placeholder="hh:mm:ss" name="work_order_log_timer" value="{{$workOrder->work_order_log_timer}}"></x-input>
                                        </div>
                                        <span id="log-time">
                                            @if(isset($workOrder->timerlogs))
                                            @foreach ($workOrder->timerlogs as $logs)
                                                {{$logs->total_log}}
                                            @endforeach
                                            @else
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="grid md:grid-cols-2 grid-cols-1 gap-6">
                            <div class="form-group">
                                <x-label for="description">Description</x-label>
                                <x-textarea id="description" class="w-full" name="description" rows="4" cols="35">{{$workOrder->description}}</x-textarea>
                                <span class="invalid" x-text="errorMessages.description"></span>
                            </div>
                            <div>
                                <h4 class="text-base">Attachments</h4>
                                <div class="flex flex-wrap gap-3 mt-3">
                                    <div class="image-upload">
                                        <x-dropzone name="media_ids" id="media_ids" multiFiles="50" :medias="$workOrder->medias" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-3 grid-cols-1 gap-6 mt-4">
                            <div class="work_order_table">
                                <table class="admin-table" aria-label="">
                                    <th></th>
                                    <tbody>
                                        <tr class="border-b border-t">
                                            <td for="title" class="gray3">Work Order Title:</td>
                                            <td>
                                                <div class="form-group">
                                                    <x-input type="text" id="title" value="{{$workOrder->title}}" class="w-full" name="title" placeholder="Title" x-bind:class="errorMessages.title ? 'invalid' : ''"></x-input>
                                                    <span class="invalid" x-text="errorMessages.title"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="gray3">Asset Type:</td>
                                            <td>
                                                <div class="form-group">
                                                    <livewire:dynamic-dropdown
                                                    name="asset_type_id"
                                                    :where="[
                                                        ['type', '=', config('apg.type.master')],
                                                        ]"
                                                        entity="\App\Models\Admin\Asset\AssetType"
                                                        entity-select-fields="id, name"
                                                        :entity-search-fields="['name']"
                                                        entity-field="id"
                                                        entity-display-field="name"
                                                        :entity_id="$workOrder->asset_type_id"
                                                        >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3" required="true">Asset:</td>
                                                <td>
                                                    <div class="form-group">
                                                        <x-select class="w-full" name="asset_id" id="asset"
                                                        x-bind:class="errorMessages.asset_id ? 'invalid' : ''"
                                                        x-model="workOrder.asset_id">
                                                            <option value="{{$workOrder->asset_id}}">{{$workOrder->asset?->name}}</option>
                                                        </x-select>
                                                        <span class="invalid" x-text="errorMessages.asset_id"></span>
                                                    </div>
                                                </td>
                                            </tr>
                                        <tr class="border-b">
                                            <td class="gray3">Assigned To:</td>
                                            <td>
                                                @php
                                                    $concat = "concat(first_name, ' ', last_name)";
                                                @endphp
                                                <div class="form-group">
                                                    <livewire:dynamic-dropdown
                                                        name="assignee_user_id"
                                                        :where="[
                                                            ['company_id', '=', null],
                                                        ]"
                                                        entity="\App\Models\User"
                                                        entity-select-fields="id, first_name, last_name"
                                                        :entity-search-fields="[$concat]"
                                                        entity-field="id"
                                                        entity-display-field="full_name"
                                                        :entity_id="$workOrder->assignee_user_id"
                                                        xModel="workOrder.assignee_user_id"
                                                        onChangeFunc="changeAssignee"
                                                    >
                                                    <span class="invalid" x-text="errorMessages.assignee_user_id"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="work_order_table">
                                <table class="admin-table" aria-label="">
                                    <th></th>
                                    <tbody>
                                        <tr class="border-b border-t" id="due_d">
                                            <td class="gray3">Due Date</td>
                                            <td>
                                                <div class="form-group">
                                                    <x-date-picker id="due_date" class="w-full" name="due_date" placeholder="Select Due Date" x-bind:class="errorMessages.due_date ? 'invalid' : ''" autocomplete="off" data-input value="{{$workOrder->due_date ? customDateFormat($workOrder->due_date) : '' }}"></x-date-picker>
                                                    <span class="invalid" x-text="errorMessages.due_date"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="gray3">Location:</td>
                                            <td class="text-right">
                                                <div class="form-group ">
                                                    <x-input name="location_id" type="hidden" value="{{$workOrder->asset?->location?->id}}" id="location"></x-input>
                                                    <x-input name="asset_warranty" type="hidden" id="warranty"></x-input>
                                                    <x-input disabled id="locationName" value="{{$workOrder->asset?->location?->name}}" class="w-full" x-bind:class="errorMessages.location ? 'invalid' : ''"></x-input>
                                                    <span class="invalid" x-text="errorMessages.location"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="gray3">Employee Qualification:</td>
                                            <td class="text-right">
                                                <div class="form-group">
                                                    <x-select id="qualification" name="qualification"
                                                        x-bind:class="errorMessages.qualification ? 'invalid' : ''"
                                                        x-model="workOrder.qualification">
                                                        <option value="">Select Qualification</option>
                                                        @forelse (config('apg.qualification') as $qualification)
                                                            <option @selected($qualification == $workOrder->qualification) value="{{ $qualification }}">
                                                                {{$qualification}}
                                                            </option>
                                                        @empty
                                                        @endforelse
                                                    </x-select>
                                                    <span class="invalid" x-text="errorMessages.qualification"></span>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="work_order_table">
                                <table class="admin-table" aria-label="">
                                    <th></th>
                                    <tbody>
                                        <tr class="border-b border-t">
                                            <td for="work_order_type" class="gray3">Work Order Type</td>
                                            <td>
                                                <div class="form-group">
                                                    <x-select x-model="workOrder.work_order_type" id="work_order_type" class="w-full"
                                                        name="work_order_type"
                                                        x-bind:class="errorMessages.work_order_type ? 'invalid' : ''">
                                                        @forelse (config('apg.work_order_type') as $work_order_type)
                                                        <option @selected($work_order_type==$workOrder->work_order_type) value="{{$work_order_type}}">{{$work_order_type}}</option>
                                                        @empty
                                                        @endforelse
                                                    </x-select>
                                                    <span class="invalid" x-text="errorMessages.work_order_type"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border-b border-t" id="work_type" x-show="workOrder.work_order_type == '{{ config('apg.recurring_status.recurring') }}'">
                                            <td for="work_order_frequency" class="gray3">Work Order Frequency</td>
                                            <td>
                                                <div class="form-group w-full">
                                                    <x-select id="work_order_frequency" name="work_order_frequency"
                                                        x-bind:class="errorMessages.work_order_frequency ? 'invalid' : ''"
                                                        x-model="workOrder.work_order_frequency">
                                                        <option selected disabled>Select Frequency</option>
                                                        @forelse (config('apg.frequency') as $frequency)
                                                        <option @selected($frequency==$workOrder->work_order_frequency) value="{{$frequency}}">{{$frequency}}</option>
                                                        @empty
                                                        @endforelse
                                                    </x-select>
                                                    <span class="invalid" x-text="errorMessages.work_order_frequency"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" name="is_update_frequency"
                                :value='workOrder.work_order_type == "{{ config('apg.recurring_status.recurring') }}" &&
                                    workOrder.asset_id == "{{ $workOrder->asset_id }}" &&
                                    (
                                        workOrder.work_order_status == "{{ config('apg.work_order_status.open') }}" ||
                                        workOrder.work_order_status == "{{ config('apg.work_order_status.on_hold') }}"
                                    )
                                && (
                                    (
                                        workOrder.work_order_frequency != null &&
                                        workOrder.work_order_frequency != "{{ $workOrder->work_order_frequency }}"
                                    ) || (
                                            workOrder.qualification != null &&
                                            workOrder.qualification != "{{ $workOrder->qualification }}"
                                        )
                                    ||  (
                                            workOrder.assignee_user_id != null &&
                                            workOrder.assignee_user_id != "{{ $workOrder->assignee_user_id }}"
                                        )
                                ) ? true : false'/>

                                <div class="border-b border-t py-4 px-2"
                                    x-show='workOrder.work_order_type == "{{ config('apg.recurring_status.recurring') }}" &&
                                        workOrder.asset_id == "{{ $workOrder->asset_id }}" &&
                                        (
                                            workOrder.work_order_status == "{{ config('apg.work_order_status.open') }}" ||
                                            workOrder.work_order_status == "{{ config('apg.work_order_status.on_hold') }}"
                                        )
                                    && (
                                        (
                                            workOrder.work_order_frequency != null &&
                                            workOrder.work_order_frequency != "{{ $workOrder->work_order_frequency }}"
                                        ) || (
                                                workOrder.qualification != null &&
                                                workOrder.qualification != "{{ $workOrder->qualification }}"
                                            )
                                        ||  (
                                                workOrder.assignee_user_id != null &&
                                                workOrder.assignee_user_id != "{{ $workOrder->assignee_user_id }}"
                                            )
                                    ) ? true : false'>
                                    <div class="form-group w-full items-center mb-0">
                                        @foreach (config('apg.update_frequency_cases') as $key => $value)
                                            <div class="form-check flex  items-center">
                                                <input  type="radio" class="form-check-input"
                                                name="update_frequency_type" id="update_frequency_type_{{ $value['key'] }}"
                                                value="{{ $value['key'] }}"/>
                                                <x-label class="form-check-label pt-1" for="update_frequency_type_{{ $value['key'] }}">
                                                    {{ $value['text'] }}
                                                </x-label>
                                            </div>
                                        @endforeach
                                        <span class="invalid" x-text="errorMessages.update_frequency_type"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-2 mt-4">
                            <div class="gray3">Notes</div>
                            <div class="text-right w-full">
                                <div class="form-group">
                                    <x-textarea class="form-control w-full" name="additional_info" rows="4" cols="5" placeholder="Additional Information">{{{$workOrder->additional_info}}}</x-textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 grid-cols-1 gap-4">
                        <div class="main-wrapper tasks-box">
                            <div class="flex items-center border-b pb-4">
                                <h3 class="text-lg">TASKS</h3>
                                <a class="primary ml-auto font-semibold" data-bs-toggle="offcanvas" data-bs-target="#add-additional-task"><em class="fa-solid fa-plus"></em> ADD TASK</a>
                            </div>
                            <div id="append_tasks">
                                <template x-for="(task,index) in tasks" :key="index">
                                    <div class="flex justify-between mb-4 border-b py-4">
                                        <div>
                                            <h3 x-text="task.name"></h3>
                                            <input type="hidden" name="task_status[]" x-model="task.status">
                                            <input type="hidden" name="task_id[]" x-model="task.id">
                                            <p class="gray1 mb-4" x-text="task.task_detail" x-bind:class="task.status == 'Completed' ? 'line-through' : ''"></p>
                                            <label class="primary" for="due_date">Due Date:</label>
                                            <p class="inline-block primary" id="due_date" x-text="task.due_date ? (new Date(task.due_date)).toLocaleDateString() : ''"></p>
                                        </div>
                                        <div class="ml-4">
                                            <button class="gray1" @click.prevent="editData(task,index)" data-bs-toggle="offcanvas" data-bs-target="#edit-additional-task">
                                            <em class="fa-solid fa-pen" aria-hidden="true"></em></button>
                                            <a class="gray1" @click.prevent="deleteData(task,index)"><em class="fa-solid fa-trash" aria-hidden="true"></em></a>
                                         </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <x-input type="hidden" value="{{$workOrder->id}}" id="work-order-id"></x-input>
            <div class="main-wrapper expense-wrap {{ ($workOrder->media?->url) ? 'expense-wrap-company' : '' }}">
                <div class="flex items-center">
                    <x-button type="submit" class="primary ml-auto font-semibold" data-bs-toggle="offcanvas" data-bs-target="#add-expenses">
                        <em class="fa-solid fa-plus"></em> ADD EXPENSE
                    </x-button>
                    <x-right-modal id="add-expenses" heading="Add Expense">
                        <form action="{{ route('admin.master.expenses.store') }}" method="post" x-data="submitForm()"
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
                                <span class="invalid" x-text="errorTaskMessages.description"></span>
                            </div>
                            <div class="form-group">
                                <x-label for="amount" value="Amount" required="true"/>
                                <x-input type="number" class="form-control" id="amount" name="amount" x-bind:class="errorMessages.amount ? 'invalid' : ''"/>
                                <span class="invalid" x-text="errorMessages.amount"></span>
                            </div>
                            <div class="form-group ">
                                <x-input type="hidden" value="{{$workOrder->id}}" class="form-control" id="work_order_id" name="work_order_id"/>
                            </div>
                            <div class="form-group">
                                <x-input type="hidden" class="form-control" id="asset_id" name="asset_id"/>
                            </div>
                            <x-button type="submit" class="btn-primary">
                                <em class="fa-solid fa-check"></em> ADD Expense
                            </x-button>
                        </form>
                    </x-right-modal>
                </div>
                <table class="admin-table expense-table mt-4" aria-label="">
                    <thead>
                        <tr>
                            <th>Payment Type</th>
                            <th>Logged Time</th>
                            <th class="expense-amount">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-t">
                            @forelse ($expense as $each_expense)
                        <tr>
                            <td>{{ ucfirst(str_replace('-',' ',$each_expense->type)) }}</td>
                            <td>{{ ($each_expense->expense_log_time) }}</td>
                            <td class="text-right">{{ currency($each_expense->amount) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No Record Found</td>
                        </tr>
                        @endforelse
                    </tr>
                    <tr class="border-b">
                        <td class="font-bold">Total Cost</td>
                        <td></td>
                        <td class="text-right font-bold">
                            {{currency($sum)}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <form class="d-none" action="{{ route('admin.work-orders.update.log') }}" method="post" @submit.prevent="saveLogData">
                <x-input type="hidden" value="{{$workOrder->id}}" id="work_order_id" name="work_order_id"></x-input>
                <x-input type="hidden" value="" id="log_time" name="updated_time"></x-input>
                <x-input type="hidden" value="" id="timer_status" name="type"></x-input>
                <button type="submit" id="log-submit" class="d-none"></button>
            </form>
            <x-right-modal id="add-additional-task" heading="Add Task">
                <form action="{{ route('admin.work-orders.additional-task.store') }}" method="post" @submit.prevent="saveData" id="additional-task-post-form">
                    <x-input type="hidden" value="{{$workOrder->id}}" name="work_order_id" id="work-order-id"></x-input>
                    <div class="form-group">
                        <x-label for="name" value="Task Name" required="true" />
                        <x-input type="text" class="form-control" x-model="form.name" id="name" name="name" x-bind:class="errorTaskMessages.name ? 'invalid' : ''" placeholder="Name"/>
                        <span class="invalid" x-text="errorTaskMessages.name"></span>
                    </div>
                    <div class="form-group">
                        <x-label for="date_due">Due Date</x-label>
                        <x-date-picker id="date_due" name="due_date" class="form-control" value="{{$workOrder->due_date ? customDateFormat($workOrder->due_date) : '' }}" x-model="form.due_date" x-bind:class="errorTaskMessages.due_date ? 'invalid' : ''" placeholder="{{$workOrder->due_date ? customDateFormat($workOrder->due_date) : '' }}" />
                        <span class="invalid" x-text="errorTaskMessages.due_date"></span>
                    </div>
                    <div class="form-group w-full">
                        <x-label for="task_detail">Task Details</x-label>
                        <x-textarea id="task_detail" class="form-control w-full" x-model="form.task_detail" name="task_detail" rows="4" cols="20"></x-textarea>
                        <span class="invalid" x-text="errorTaskMessages.task_detail"></span>
                    </div>
                    <x-button type="submit" class="btn-primary">
                        <em class="fa-solid fa-check"></em> ADD Task
                    </x-button>

                </form>
            </x-right-modal>
            <x-right-modal id="edit-additional-task" heading="Edit Task">
                <form action="" method="post" @submit.prevent="updateData" id="additional-task-patch-form">
                    <div>
                        <div class="form-group">
                            <x-label for="name" value="Task Name" required="true" />
                            <x-input type="text" class="form-control" id="edit-name" x-model="form.name" name="name" x-bind:class="errorTaskMessages.name ? 'invalid' : ''" />
                            <span class="invalid" x-text="errorTaskMessages.name"></span>
                        </div>
                        {{-- <input type="hidden" name="id" x-model="form.id"> --}}
                        <div class="form-group">
                            <x-label for="date_due">Due Date</x-label>
                            <x-date-picker id="edit-date_due" x-model="form.due_date" name="due_date" class="form-control" x-bind:class="errorTaskMessages.due_date ? 'invalid' : ''" placeholder="Due Date" />
                            <span class="invalid" x-text="errorTaskMessages.due_date"></span>
                        </div>
                        <div class="form-group w-full">
                            <x-label for="task_detail">Task Details</x-label>
                            <x-textarea id="edit-task_detail" x-model="form.task_detail" class="form-control w-full" name="task_detail" rows="4" cols="20"></x-textarea>
                        </div>
                        <x-button type="submit" class="btn-primary">
                            <em class="fa-solid fa-check"></em> EDIT Task
                        </x-button>
                    </div>
                </form>
            </x-right-modal>
        </div>
        {{-- tabs end --}}
        <?php
            $pause =$workOrder->is_pause;
            $timer_status =$workOrder->timer_status;
            if (isset($workOrder->work_order_log_timer) && $workOrder->work_order_log_timer != null) {
                $timer = explode(':', $workOrder->work_order_log_timer);
                $hour = $timer[0];
                $minute = $timer[1];
                $sec = $timer[2];
            } else {
                $hour = 00;
                $minute = 00;
                $sec = 00;
            }
        ?>
    </div>
    @include('custom-edit-js');
</x-app-layout>
