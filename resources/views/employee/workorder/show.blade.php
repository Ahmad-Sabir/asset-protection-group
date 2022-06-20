<x-app-layout>
    <!-- Content -->
    <div class="main-wrap" x-data="TaskData()">
        <x-alert-message class="mb-4" />
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>WORK ORDERS DETAILS</h1>
                <p class="gray1">Work Orders > {{$workOrder->number}}</p>
            </div>
            <div class="form-group">
                <a class="w-full-btn md:mb-0 mb-3" href="{{ route('employee.work-orders.export.pdf', [$workOrder->id]) }}">
                    <x-button type="submit" class="btn-outline-primary">
                        <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
                    </x-button>
                </a>
                <a href="{{ route('employee.work-orders.export.csv', [$workOrder->id]) }}">
                    <x-button type="submit" class="btn-outline-primary md:ml-2 ml-0">
                        <em class="fa-solid fa-cloud-arrow-down"></em> Download CSV
                    </x-button>
                </a>
            </div>
        </div>
        <div class="form-group">
            @if($workOrder->flag == 'on')
            <em class="fa-solid fa-bookmark"></em>
            @else
            <em class="fa-regular fa-bookmark"></em>
            @endif
        </div>
        <div class="main-content">
            <div class="work-order-details-section" x-data="{ workOrder: {{json_encode($workOrder->only([
                'id',
                'assignee_user_id',
                'asset_id',
                'work_order_type',
                'work_order_frequency',
                'work_order_status',
                ]))}} }">
                @if ($workOrder->media?->url)
                <section class="banner-image">
                    <img src="{{$workOrder->media?->url}}" alt="">
                </section>
                @endif
                    <div class="main-wrapper">
                        <div class="sm:flex items-center">
                            <p class="gray1">ID {{$workOrder->number}}</p>
                        </div>
                        <div class="heading mt-2">
                            <h3>{{$workOrder->title}}</h3>
                        </div>
                        <div class="sm:flex items-center my-3">
                            <div class="form-group">
                                <select class="form-select form-select-green md:w-auto w-full" id= "status_order" onchange="statusChange()" name="work_order_status">
                                    @forelse(config('apg.work_order_status') as $status)
                                    <option value="{{$status}}" @selected($status==$workOrder->work_order_status)>{{$status}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group md:ml-3 ml-0">
                                <x-select class="form-select form-select-outline-gray md:w-auto w-full" id="order_priority" name="priority" onchange="statusChange()">
                                    <option disabled>Select Priority</option>
                                    @forelse(config('apg.priority') as $priority)
                                    <option value="{{$priority}}" @selected($priority==$workOrder->priority)>{{$priority}}</option>
                                    @empty
                                    @endforelse
                                </x-select>
                            </div>
                            <div class="form-group md:ml-3 ml-0" id="haveReason" x-show="workOrder.work_order_status == '{{ config('apg.work_order_status.on_hold') }}' && workOrder.on_hold_reason != ''">
                                <label for="hold_reason">On Hold Reason</label>
                                <p>{{$workOrder->on_hold_reason}}</p>
                            </div>
                            <div class="form-group md:ml-3 ml-0" id="on_hold_reason" x-show="workOrder.work_order_status == '{{ config('apg.work_order_status.on_hold') }}' && workOrder.on_hold_reason == ''">
                                <label for="hold_reason">On Hold Reason</label>
                                <input type="text" class="form-control w-full md:w-auto" placeholder="Reason" id="hold_reason" name="on_hold_reason" value="{{$workOrder->on_hold_reason}}">
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
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-base">Description</h4>
                                <p class="gray1 mt-3">{{$workOrder->description}}</p>
                            </div>
                            <div>
                                @if(isset($workOrder->medias) && count($workOrder->medias) > 0)
                                <h4 class="text-base">Attachments</h4>
                                <div class="flex flex-wrap gap-3 mt-3">
                                    @foreach ($workOrder->medias as $image)
                                    <div class="image-box" data-bs-toggle="modal" data-bs-target="#ImageModal-{{$image->id}}">
                                        <img src="{{$image->url}}" data-action="zoom" alt="{{$image->name}}" class="image">
                                    </div>
                                    <x-modal id="ImageModal-{{$image->id}}">
                                        <img src="{{$image->url}}" alt="{{$image->name}}"/>
                                        </x-modal>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6 mt-6">
                            <div>
                                <table class="admin-table" aria-label="">
                                    <th></th>
                                    <tbody>
                                        <tr class="border-b border-t">
                                            <td class="gray3">Title:
                                            </td>
                                            <td class="text-right">
                                                {{$workOrder->title}}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-t">
                                            <td class="gray3">Asset:
                                            </td>
                                            <td class="text-right">
                                                {{$workOrder->asset?->name}}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-t">
                                            <td class="gray3">Asset Type:
                                            </td>
                                            <td class="text-right">
                                                {{$workOrder->assetType?->name}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <table class="admin-table" aria-label="">
                                    <th></th>
                                    <tbody>
                                        <tr class="border-b border-t">
                                            <td class="gray3">Due Date</td>
                                            <td class="text-right">
                                                {{$workOrder->due_date ? customDateFormat($workOrder->due_date) : '' }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-t">
                                            <td class="gray3">Last Updated</td>
                                            <td class="text-right">
                                                {{ $workOrder->updated_at ? customDateFormat($workOrder->updated_at) : '' }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-t">
                                            <td class="gray3">Created On</td>
                                            <td class="text-right">
                                                {{ $workOrder->created_at ? customDateFormat($workOrder->created_at) : '' }}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-t">
                                            <td class="gray3">Location:</td>
                                            <td class="text-right">
                                                {{$workOrder->location?->name}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <table class="admin-table" aria-label="">
                                    <th></th>
                                    <tbody>
                                        <tr class="border-b border-t">
                                            <td class="gray3">Work Order Type</td>
                                            <td class="text-right">
                                                {{$workOrder->work_order_type}}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-t">
                                            <td class="gray3">Work Order Freq.</td>
                                            <td class="text-right">
                                                {{$workOrder->work_order_frequency}}
                                            </td>
                                        </tr>
                                        <tr class="border-b border-t">
                                            <td class="gray3">Notes</td>
                                            <td class="text-right">
                                                {{$workOrder->additional_info}}
                                                <div class="flex items-center justify-end mt-4"><a class="primary" href="#">Read More</a></div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="assignee_user_id" value="{{$workOrder->user?->id}}">
                <form class="d-none" action="{{ route('admin.work-orders.update.log') }}" method="post" @submit.prevent="saveLogData">
                    <x-input type="hidden" value="{{$workOrder->id}}" id="work_order_id" name="work_order_id"></x-input>
                    <x-input type="hidden" value="" id="log_time" name="updated_time"></x-input>
                    <x-input type="hidden" value="" id="timer_status" name="type"></x-input>
                    <button type="submit" id="log-submit" class="d-none"></button>

                </form>
            </div>
            {{-- Tasks --}}
            <div class="grid md:grid-cols-2 grid-cols-1 gap-4">
                <div class="main-wrapper">
                    <div class="flex items-center pb-2 mb-4">
                        <h3 class="text-lg">TASKS</h3>
                        {{-- <a class="primary ml-auto font-semibold"><em class="fa-solid fa-plus"></em> ADD TASK</a> --}}
                    </div>
                    <hr>
                        @forelse ($workOrder->additionaltasks as $task)
                        <form method="post" action="{{route('admin.work-orders.additional-task.update', $task->id)}}" @submit.prevent="changeTaskStatus" id="task-update-{{$task->id}}">
                            <div class="border-b py-4 relative">
                                <h3 class="ml-[2.2rem]">{{$task->name}}</h3>
                                <div class="form-check flex items-center">
                                    <input class="form-check-input" onclick="taskStatus({{$task->id}})" name="status" @checked($task->status == config('apg.task_status.completed')) type="checkbox" id="{{$task->id}}" id="taskCheckbox">
                                    <label id="line-{{$task->id}}" class="gray1 ml-3 @if($task->status == config('apg.task_status.completed')) line-through @else @endif" for="taskCheckbox">{{$task?->task_detail}}</label>
                                </div>
                                <p class="primary ml-[2.2rem] mt-3">Due On: {{$task->due_date ? $task->due_date->format('m/d/Y') : null}}</p>
                                <div class="ml-[2.2rem] mt-3 single-image-upload">
                                    <label>{!! nl2br(e($task->comment)) !!}</label>
                                    <div class="task-image my-5" x-show="`{{$task->media?->url}}`">
                                        <img src="{{$task->media?->url}}" alt="image">
                                    </div>
                                </div>
                                <div class="ml-[2.2rem]" x-data="{ task_comment: false, task_image:false, comment_image:`{{$task->media?->url}}`, comment_textarea:`{{$task->comment}}`}">
                                    <div class="flex items-center gray1 my-5 absolute top-0 right-0">
                                        <em x-on:click="task_comment = ! task_comment" class="fa-solid fa-comment cursor-pointer"></em>
                                        <em x-on:click="task_image = ! task_image" class="fa-solid fa-image cursor-pointer ml-2"></em>
                                    </div>
                                    <div class="comment-box mt-4" x-show="task_comment" x-transition.duration.500ms>
                                        <div class="flex justify-between mb-4 py-4">
                                                <label for="" x-show="comment_textarea">{!! nl2br(e($task->comment)) !!}</label>
                                            <div x-show="comment_textarea" class="ml-4">
                                                <em class="fa-solid fa-pen" x-on:click="comment_textarea = ! comment_textarea" aria-hidden="true"></em>
                                                <a class="gray1" @click.prevent="deleteData({{$task->id}}, `{{config('apg.task_type.comment')}}`)"><em class="fa-solid fa-trash" aria-hidden="true"></em></a>
                                             </div>
                                        </div>

                                        <div x-show="!comment_textarea" class="form-group mt-3">
                                            <textarea class="form-control w-full" name="comment" placeholder="Enter your Comments...">{!! ($task->comment) !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="single-image-upload" x-show="task_image" x-transition.duration.500ms>
                                        <div class="flex justify-between mb-4 py-4">
                                            <div class="task-image my-5 cursor-zoom-in" data-bs-toggle="modal" data-bs-target="#TaskImage-{{$task->id}}" x-show="comment_image">
                                                <img src="{{$task->media?->url}}" alt="image">
                                            </div>
                                            <div x-show="comment_image" class="ml-4">
                                                <em class="fa-solid fa-pen" x-on:click="comment_image = ! comment_image" aria-hidden="true"></em>
                                                <a class="gray1" @click.prevent="deleteData({{$task->id}}, `{{config('apg.task_type.image')}}`)"><em class="fa-solid fa-trash" aria-hidden="true"></em></a>
                                             </div>
                                        </div>

                                        <div x-show="!comment_image" class="form-group mt-3">
                                            <x-dropzone name="media_id" id="task-media-{{$task->id}}" x-show="comment_image"/>
                                        </div>
                                        <x-modal id="TaskImage-{{$task->id}}">
                                            <img src="{{$task->media?->url}}" alt="Image"/>
                                        </x-modal>
                                    </div>
                                    <div class="comment-btns mt-5" x-show="task_comment || task_image">
                                        <x-button type="submit" id="task-submit-{{$task->id}}" class="btn-secondary">Submit</x-button>
                                    </div>
                                </div>

                            </div>
                                <x-input type="hidden" value="{{$task->name}}" name="name"></x-input>
                                <x-input type="hidden" value="{{$task->due_date ? $task->due_date->format('m-d-Y'): null}}" name="due_date"></x-input>
                        </form>
                        @empty
                        @endforelse
                </div>
                <div class="main-wrapper">
                    <div class="flex items-center">
                        <h3 class="text-lg">ADDITIONAL COST</h3>
                        <x-button type="submit" class="primary ml-auto font-semibold" data-bs-toggle="offcanvas" data-bs-target="#add-expenses">
                            <em class="fa-solid fa-plus"></em> ADD EXPENSE
                        </x-button>
                        <x-right-modal id="add-expenses" heading="Add Expense">
                            <form action="{{ route('employee.expenses.store', $workOrder->company_id) }}" method="post" x-data="submitForm()"
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
                                    <x-textarea id="description" class="form-control w-full"  name="description"
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
                                <x-button type="submit" class="btn-primary">
                                    <em class="fa-solid fa-sliders"></em> ADD Expense
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
                </div>
            </div>
        </div>
    </div>
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
@include('custom-view-js', ['work_order_base_url' => route('employee.work-orders.index')]);
</x-app-layout>
