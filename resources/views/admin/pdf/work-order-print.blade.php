<!DOCTYPE html>
<html lang="en">

<head>
    <title>Front Page</title>
    <style>
        body {
            font-family: "Axiforma", sans-serif !important;
            margin: 0 !important;
        }
        .flex {
            display: flex;
            display: -webkit-flex !important;
            display: -webkit-box;
        }
        .float-right{
            float: right
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .float-left{
            float: left
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .mt-4 {
            margin-top: 1rem !important;
        }

        .my-4 {
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
        }
        .p-4{
            padding: 1rem !important;
        }
        .m-4{
            margin: 1rem !important;
        }
        .px-4 {
            padding-right: 1rem !important;
            padding-left: 1rem !important;
        }

        .py-4 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .border-y {
            border-bottom: 1px solid #DADEE4 !important;
            border-top: 1px solid #DADEE4 !important;
        }

        .border-bottom {
            border-bottom: 1px solid #DADEE4 !important;
        }

        .border-top {
            border-top: 1px solid #F7F8FA !important;
        }

        .border-top-black {
            border-top: 1px solid black !important;
            width: 20% !important;
            margin-top: 10% !important;
        }

        .d-inline-block {
            display: inline-block;
        }

        .rounded {
            border-radius: 8px !important;
        }

        .gray-bg-color {
            background-color: #F7F8FA !important;
            -webkit-print-color-adjust: exact !important;
        }

        .front-page-content {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .logo-image {
            text-align: center !important;
        }

        .logo-image h1,
        .logo-image h2 {
            color: white !important;
        }


        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .pr-4 {
            padding-right: 1rem !important;
        }

        .pl-4 {
            padding-left: 1rem !important;
        }

        .form-control {
            border: 1px solid #DADEE4 !important;
            border-radius: 8px !important;
            padding: 10px !important;
            outline: none !important;
            width: 97% !important;
        }

        .gray-text {
            color: #A3A9B4 !important;
        }

        .primary {
            color: #FF4A17 !important;
        }

        textarea {
            height: 100px !important;
        }

        .admin-table {
            min-width: 100% !important;
        }

        .admin-table thead {
            background-color: #f7f8fa !important;
            padding: 6px !important;
        }

        .admin-table thead tr th {
            padding: 15px !important;
            text-align: left !important;
            font-size: 14px !important;
            text-transform: uppercase !important;
            color: #788090 !important;
            font-weight: 400 !important;
            position: relative !important;
        }

        .admin-table td {
            padding: 15px !important;
            font-size: 14px !important;
        }

        .admin-table tbody tr {
            border-bottom: 1px solid #dadee4 !important;
        }

        .admin-table tbody tr:last-child {
            border: none !important;
        }

        .admin-table tbody tr em {
            color: #a3a9b4 !important;
        }

        .table-border {
            padding: 0.5rem !important;
            border: 1px solid #dadee4 !important;
            border-radius: 5px !important;
        }
        div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }

        .form-check-input {
            background-color:#f7f8fa !important;
            border-color:pink !important;
            border-radius: 6px !important;
            outline: 0;
            padding: 10px;
        }

        .checkbox{
            width: 15px;
            height: 15px;
            background-color:#bec2c8;
            border-color: #262626;
            -webkit-border-color: #262626;
            border-radius: 2px;
        }

        .center-align {
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        .w-100 {
            width: 100%;
            max-width: 100%;
        }
        .w-80{
            width: 80%;
            max-width: 80%;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            h2,
            h3 {
                page-break-after: avoid !important;
            }

            .page {
                page-break-after: always !important;
            }

            .front-page {
                margin: 0;
                background-color: #14212b !important;
                height: 100%;
                 -webkit-print-color-adjust: exact !important;
                page-break-after: always !important;
                position: relative;
                width: 100% !important;
            }

            .admin-table {
                min-width: 100% !important;
            }

            .admin-table thead {
                background-color: #f7f8fa !important;
                padding: 6px !important;
            }

            .admin-table thead tr th {
                padding: 15px !important;
                text-align: left !important;
                font-size: 14px !important;
                text-transform: uppercase !important;
                color: #788090 !important;
                font-weight: 400 !important;
                position: relative !important;
            }
            .relative{
                position: relative;
            }

            .admin-table td {
                padding: 15px !important;
                font-size: 14px !important;
            }

            .admin-table tbody tr {
                border-bottom: 1px solid #dadee4 !important;
            }

            .admin-table tbody tr:last-child {
                border: none !important;
            }

            .admin-table tbody tr em {
                color: #a3a9b4 !important;
            }

            .table-border {
                padding: 0.5rem !important;
                border: 1px solid #dadee4 !important;
                border-radius: 5px !important;
            }

            .main-wrap {
                page-break-after: always !important;
                padding: 30px !important;
                margin: 30px;
            }

            @page {
                margin: 0 !important;
            }
        }
    </style>
</head>

<body>

    <div class="front-page" style="background-color: #14212b; height:1300px;  position: relative;">
        <div class="front-page-content">
            <div class="logo-image">
                <img src="{{ public_path('/assets/images/apg-big-logo.png'); }}" alt="">
                <h1>{{ (count($data) == 1) ? Str::title($data[0]->title) : "Work Orders" }}</h1>
                @forelse ($searchTerm as $key => $search)
                    @if (is_array($search))
                        @foreach ($search as $arrKey => $values)
                            <h2>{{ Str::title(Str::replace('_', ' ', $arrKey)). ': ' }} {{ $values }}</h2>
                        @endforeach
                    @else
                        <h2>{{ Str::title(Str::replace('_', ' ', $key)). ': ' }} {{ $search }}</h2>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
    </div>
    <div class="page"></div>
    @forelse ($data as $workOrder)
    <div class="main-wrap">
        <div class="main-content">
            <div class="clearfix">
                <div class="logo float-left">
                    <img src="{{ public_path('assets/images/logo.svg') }}" alt="">
                </div>
                @if ($workOrder->company_id && $workOrder->company?->profile_media_id)
                    <div class="logo float-right">
                        @if($workOrder->company?->profile?->hash)
                        <img src="{{ storage_path('app/public/' . $workOrder->company?->profile?->hash) }}" height="100" width="100" alt="">
                        @endif
                    </div>
                @endif
            </div>
            <div class="mt-4 clearfix px-4 rounded" style="background-color: #14212b;color:#ffffff;">
                <h2 class="float-left">Monthly Inspection</h2>
                <h2 class="float-right" style="font-weight: normal;">{{ $workOrder->id; }}</h2>
            </div>
            <p>{{ $workOrder->description; }}</p>
            <div class="clearfix border-y py-4">
                <table style="width:100%">
                    <tr>
                        <th></th>
                    </tr>
                    <tbody>
                        <tr>
                            <td valign="top" style="width:50%">
                                <table align="left" style="width:100%;">
                                    <tr>
                                        <th></th>
                                    </tr>
                                    <tbody>
                                        <tr>
                                            <td style="width:100px;" class="pr-4 gray-text">Assigned to:</td>
                                            <td>{{ $workOrder->user?->fullname }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pr-4 gray-text">Priority</td>
                                            <td class="primary">{{ $workOrder->priority }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pr-4 gray-text">Asset:</td>
                                            <td>{{ $workOrder->asset?->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pr-4 gray-text">Asset Type:</td>
                                            <td>{{ $workOrder->assetType?->name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td valign="top" style="width:50%">
                                <table align="right" style="width:100%;">
                                    <tr>
                                        <th></th>
                                    </tr>
                                    <tbody>
                                        <tr>
                                            <td style="width:100px;" class="pr-4 gray-text">Due Date:</td>
                                            <td>{{ customDateFormat($workOrder->due_date); }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pr-4 gray-text">Location:</td>
                                            <td>{{ $workOrder->location?->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pr-4 gray-text">Notes:</td>
                                            <td>{!! nl2br(e($workOrder->additional_info)) !!}</td>
                                        </tr>
                                        <tr>
                                            <td class="pr-4 gray-text">Type:</td>
                                            <td style="text-transform:capitalize">{{ $workOrder->type }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="Tasks">
                @if (count($workOrder->additionaltasks))
                    <h2>Tasks</h2>
                    @foreach ($workOrder->additionaltasks as $task)
                        <div class="form-check mt-2" style="margin-bottom:20px">
                            @if ($task->status == 'Completed') 
                                <img style="width:16px" alt="checkbox" src="{{ public_path('/assets/images/checkbox.png'); }}" />
                            @else
                                <div style="width:16px; height:16px; background-color: #efefef; display:inline-block; margin-top:3px;"></div>
                            @endif
                            <label class="form-check-label" for="flexCheckDefault" style="display: inline; margin-left:5px;">{{ $task->name }}</label>
                            @if ($task->comment) 
                                <div class="form-group mt-4">
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="">{{ $task->comment }}</textarea>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif;
                <h2>Comments</h2>
                <div class="form-group mt-4">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="">
                    </textarea>
                </div>
            </div>
            <div class="mt-4 clearfix" style="margin-top:20px">
                <div class="border-top-black text-center py-4 float-left">Signature</div>
                <div class="border-top-black text-center py-4 float-right">Date</div>
            </div>
        </div>
        <div class="page"></div>
    </div>
    @empty
    @endforelse
</body>
</html>
