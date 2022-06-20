<!DOCTYPE html>
<html lang="en">

<head>
    <title>Front Page</title>
    <style>
        body {
            font-family: "Axiforma", sans-serif !important;
            margin: 0 !important;
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
            padding-top: 0.625rem !important;
            padding-bottom: 0.625rem !important;
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

        .pr-10{
            padding-right: 4rem !important;
        }

        .pl-10{
            padding-left: 4rem !important;
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
            width: 100% !important;
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
            }

            @page {
                margin: 0 !important;
            }
        }
    </style>
</head>

<body>
    <div class="front-page" style="background-color: #14212b; height:880px;  position: relative;">
        <div class="front-page-content">
            <div class="logo-image">
                <img src="{{ public_path('/assets/images/apg-big-logo.png'); }}" alt="">
                <h1>Asset Protection Group</h1>
                <h2>{{ (count($data) > 0 && $data) ? $data[0]->company?->name : "Master" }}</h2>
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
    <div class="main-wrap">
        <div class="main-content">
            <div class="clearfix items-center">
                <div class="logo float-left">
                    <img src="{{ public_path('/assets/images/logo.svg') }}" alt="">
                </div>
            </div>
            <div class="table-border mt-4">
                <table class="admin-table" aria-label="">
                    <thead>
                        <tr>
                            @if ($fields['id'])
                                <th>Company ID</th>
                            @endif
                            @if ($fields['name'])
                                <th>Company Name</th>
                            @endif
                            @if ($fields['manager_email'])
                                <th>Company Email</th>
                            @endif
                            @if ($fields['company_manager_name'])
                                <th>Company Manager Name</th>
                            @endif
                            @if ($fields['deactivate_at'])
                                <th>Status</th>
                            @endif
                            @if ($fields['created_at'])
                                <th>Created On</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $reports)
                            <tr class="border-b border-t">
                                @if ($fields['id'])
                                    <td class="gray3">{{ $reports->id }}</td>
                                @endif
                                @if ($fields['name'])
                                    <td class="gray3">{{ $reports->name }}</td>
                                @endif
                                @if ($fields['manager_email'])
                                    <td class="gray3">{{ $reports->manager_email }}</td>
                                @endif
                                @if ($fields['company_manager_name'])
                                    <td class="gray3">{{ $reports->fullname }}</td>
                                @endif
                                @if ($fields['deactivate_at'])
                                    <td class="gray3">{{ is_null($reports->deactivate_at) ? 'Active' : 'Inactive' }}</td>
                                @endif
                                @if ($fields['created_at'])
                                    <td class="gray3">{{ customDateFormat($reports->created_at) }}</td>
                                @endif
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
