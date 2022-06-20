<!DOCTYPE html>
<html lang="en">

<head>
    <title>Front Page</title>
    <style>
        body {
            font-family: "Axiforma", sans-serif !important;
            margin: 0 !important;
        }

        .w-100{
            width: 100%;
            max-width: 100%;
        }

        .w-25{
            width: 25%;
            max-width: 25%;
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
    <div class="front-page" style="background-color: #14212b; height:1300px;  position: relative;">
        <div class="front-page-content">
            <div class="logo-image">
                <img src="{{ public_path('/assets/images/apg-big-logo.png'); }}" alt="">
                <h1>Asset Protection Group</h1>
                <h2>{{ (count($data) > 0 && $data) ? $data[0]->company?->name : "Master" }}</h2>
                @php
                    unset($searchTerm['asset_type'])
                @endphp
                @forelse ($searchTerm as $key => $search)
                    @if (is_array($search))
                        @foreach ($search as $arrKey => $values)
                            <h2>{{ Str::title(Str::replace('_', ' ', $arrKey)). ': ' }} {{ $values }}</h2>
                        @endforeach
                    @else
                        <h2>{{ Str::title(Str::replace(['_', 'custom'], [' ', ' '], $key)). ': ' }} {{ $search }}</h2>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
    </div>
    <div class="page"></div>
    @forelse ($data as $asset)
    <div class="main-wrap">
        <div class="main-content">
            <div class="clearfix">
                <div class="logo float-left">
                    <img src="{{ public_path('assets/images/logo.svg') }}" style="background-size: contain;object-fit: cover;" alt="">
                </div>
                @if($asset->company_id && $asset->company?->profile_media_id)
                    <div class="logo float-right">
                        <img src="{{ storage_path('app/public/' . $asset->company?->profile?->hash) }}" style="background-size: contain;object-fit: cover;" height="100" width="100" alt="">
                    </div>
                @endif
            </div>
            <div class="mt-4 py-4 rounded" style="vertical-align: middle;display:block;background-color: #14212b;color:#ffffff;">
                <h3 class="text-center">{{ $asset->name }}</h3>
            </div>
            <div class="border-top mt-4">
                <div class="table py-4">
                    <table>
                        <tbody>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">APG Asset ID:</td>
                                <td class="pl-4 w-100">{{ $asset->number }}</td>
                            </tr>
                            @if ($asset->company_number)
                                <tr class="m-4">
                                    <td class="pr-4 gray-text p-4 w-25">Company Asset ID:</td>
                                    <td class="pl-4 w-100">{{ $asset->company_number }}</td>
                                </tr>
                            @endif
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Asset Name:</td>
                                <td class="pl-4 w-100">{{ $asset->name }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Status:</td>
                                <td class="pl-4 w-100">{{ ($asset->status) ? 'Active' : 'InActive' }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Manufacturer:</td>
                                <td class="pl-4 w-100">{{ $asset->manufacturer }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Model Name:</td>
                                <td class="pl-4 w-100">{{ $asset->model }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Asset Type:</td>
                                <td class="pl-4 w-100">{{ $asset->assetType?->name }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Purchase Date:</td>
                                <td class="pl-4 w-100">{{ customDateFormat($asset->purchase_date); }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Installation Date:</td>
                                <td class="pl-4 w-100">{{ customDateFormat($asset->installation_date); }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Warranty Expiration:</td>
                                <td class="pl-4 w-100">{{ customDateFormat($asset->warranty_expiry_date); }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Total Useful Life:</td>
                                <td class="pl-4 w-100">{{ !empty($asset->total_useful_life) ? totalUseFulLife($asset->total_useful_life) : '' }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Remaining useful life:</td>
                                <td class="pl-4 w-100">{{ !empty($asset->total_useful_life_date) ? remainingDays($asset->total_useful_life_date) : '' }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Creation Date:</td>
                                <td class="pl-4 w-100">{{ customDateFormat($asset->created_at); }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Location:</td>
                                <td class="pl-4 w-100">{{ $asset->location?->name }}</td>
                            </tr>
                            <tr class="m-4">
                                <td class="pr-4 gray-text p-4 w-25">Replacement Cost:</td>
                                <td class="pl-4 w-100">{{ currency($asset->replacement_cost) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="page"></div>
        </div>
    </div>
    @empty
    @endforelse
</body>
</html>
