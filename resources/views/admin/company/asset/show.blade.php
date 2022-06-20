<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <x-alert-message class="mb-4" />
        <div class="main-wrapper lg:mt-0 mt-[3.5rem]">
            <div class="admin-tabs">
                <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-info" @class(['nav-link', 'active' => !session()->has('is_upload_media')]) id="tabs-info-tab" data-bs-toggle="pill" data-bs-target="#tabs-info" role="tab" aria-controls="tabs-info" aria-selected="true">INFORMATION</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-file" @class(['nav-link', 'active' => session()->has('is_upload_media')]) id="tabs-file-tab" data-bs-toggle="pill" data-bs-target="#tabs-file" role="tab" aria-controls="tabs-file" aria-selected="false">ADDITIONAL FILES</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-comp" class="nav-link" id="tabs-comp-tab" data-bs-toggle="pill" data-bs-target="#tabs-comp" role="tab" aria-controls="tabs-comp" aria-selected="false">COMPLIANCE PLAN</a>
                    </li>
                </ul>
                <div class="tab-content" id="tabs-tabContent">
                    <div class="tab-pane fade {{ !session()->has('is_upload_media') ? 'show active' : '' }}" id="tabs-info" role="tabpanel" aria-labelledby="tabs-info-tab">
                        <div class="flex md:flex-row flex-col justify-end items-center gap-3">
                            <x-nav-link href="{{ route('admin.companies.assets.edit', [$company->id, $asset->id]) }}" class="btn btn-outline-primary text-center">
                                <em class="fa-solid fa-pen"></em> EDIT DETAILS
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.companies.company-asset.export.pdf', [$company->id, $asset->id]) }}" class="btn btn-outline-primary text-center">
                                <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
                            </x-nav-link>
                        </div>
                        <!-- Image Carousel -->

                        <x-carousel :medias="$asset->medias"></x-carousel>

                        <!-- Image Carousel  end-->
                        <div class="flex md:flex-row flex-col justify-between items-center mb-4">
                            <div class="md:mb-0 mb-3">
                                <h3>ASSET DETAILS</h3>
                            </div>
                            <div class="expense-date">
                                <p class="pr-6">Expenses To Date</p>
                                <p>{{ currency($totalExpense) }}</p>
                            </div>

                        </div>
                        <hr>
                        <div class="grid grid-rows-1">
                            <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                                <div>
                                    <x-input type="hidden" id="latitude" value="{{ $asset->location?->latitude }}"></x-input>
                                    <x-input type="hidden" id="longitude" value="{{ $asset->location?->longitude }}"></x-input>
                                    <table class="admin-table mt-4" aria-label="">
                                        <th></th>
                                        <tbody>
                                            <tr class="border-b">
                                                <td class="gray3">Id</td>
                                                <td class="text-right">
                                                    {{ $asset->number }}
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Name</td>
                                                <td class="text-right">
                                                    {{ Str::ucfirst($asset->name) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Location</td>
                                                <td class="text-right">
                                                    {{ Str::ucfirst($asset->location?->name) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Asset Type</td>
                                                <td class="text-right">
                                                    {{ Str::ucfirst($asset->assetType?->name) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Status</td>
                                                <td class="text-right">
                                                    <span @class([ 's-active'=> $asset->status,
                                                        's-inactive' => ! $asset->status
                                                        ])>
                                                        {{ $asset->status_name }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Manufacturer</td>
                                                <td class="text-right">
                                                    {{ $asset->manufacturer }}
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Model Name</td>
                                                <td class="text-right">
                                                    {{ $asset->model }}
                                                </td>
                                            </tr>
                                            @foreach ($asset->custom_values ?? [] as $each_asset )
                                            <tr class="border-b">
                                                <td>
                                                    {{ $each_asset['name'] }}
                                                </td>
                                                <td>
                                                    {{ $each_asset['value'] }}
                                                </td>
                                                <td>
                                                    {{ $each_asset['unit'] }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <table class="admin-table mt-4" aria-label="">
                                        <th></th>
                                        <tbody>
                                            <tr class="border-b">
                                                <td class="gray3">Created On</td>
                                                <td class="text-right">
                                                    {{
                                                        $asset->created_at ? customDateFormat($asset->created_at, true, 'm/d/Y') : ''
                                                    }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-t">
                                                <td class="gray3">Purchase Date</td>
                                                <td class="text-right">
                                                    {{
                                                        $asset->purchase_date ? customDateFormat($asset->purchase_date, true, 'm/d/Y') : ''
                                                    }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-t">
                                                <td class="gray3">Installation Date</td>
                                                <td class="text-right">
                                                    {{
                                                        $asset->installation_date ? customDateFormat($asset->installation_date, true, 'm/d/Y') : ''
                                                    }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-t">
                                                <td class="gray3">Purchase Price</td>
                                                <td class="text-right">
                                                    {{
                                                        currency($asset->purchase_price)
                                                    }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-t">
                                                <td class="gray3">Replacement Cost</td>
                                                <td class="text-right">
                                                    {{
                                                        currency($asset->replacement_cost)
                                                    }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-t">
                                                <td class="gray3">Warranty Expiration</td>
                                                <td class="text-right">
                                                    {{
                                                        $asset->warranty_expiry_date ? customDateFormat($asset->warranty_expiry_date, true, 'm/d/Y') : ''
                                                    }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-t">
                                                <td class="gray3">Remaining Warranty </td>
                                                <td class="text-right">
                                                    {{ remainingWarrantyDays($asset->installation_date, $asset->warranty_expiry_date) }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-t">
                                                <td class="gray3">Total UseFul Life</td>
                                                <td class="text-right">
                                                    {{ !empty($asset->total_useful_life) ? totalUseFulLife($asset->total_useful_life) : '' }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-t">
                                                <td class="gray3">Remaining UseFul Life</td>
                                                <td class="text-right">
                                                    {{
                                                        !empty($asset->total_useful_life_date) ? remainingDays($asset->total_useful_life_date) : ''
                                                    }}
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Additional Information</td>
                                                <td class="text-right">
                                                    {!! nl2br(e( $asset->description)) !!}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mapouter">
                                    <div id="map-canvas" class="h-full mb-4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ session()->has('is_upload_media') ? 'show active' : '' }}" id="tabs-file" role="tabpanel" aria-labelledby="tabs-file-tab">
                        <div class="flex justify-end items-center">
                            <div class="form-group">
                                <form action="{{ route('admin.assets.upload.media', $asset->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <x-input type="file" id="upload-file" onchange="form.submit()"
                                        name="file[]" class="form-control" class="hidden" required multiple>
                                    </x-input>
                                    <x-button type="button" class="btn-outline-primary" onclick="document.getElementById('upload-file').click()">
                                        <em class="fa-solid fa-upload"></em> Upload
                                    </x-button>
                                </form>
                            </div>
                        </div>
                        <livewire:asset-media-table :where="[['asset_id', '=', $asset->id]]" />
                    </div>
                    <div class="tab-pane fade" id="tabs-comp" role="tabpanel" aria-labelledby="tabs-comp-tab">
                        <div class="flex justify-end items-center gap-3 mb-6 flex-wrap">
                            <a class="md:w-auto w-full" href="{{ route('admin.companies.company-compliance.asset.pdf', [$company->id, $asset->id]) }}">
                                <x-button type="submit" class="btn-outline-primary">
                                    <em class="fa-solid fa-cloud-arrow-down"></em> DOWNLOAD COMPLIANCE PLAN
                                </x-button>
                            </a>
                            <a class="md:w-auto w-full" href="{{ route('admin.companies.grid.compliance.pdf', [$company->id, $asset->id]) }}">
                                <x-button type="submit" class="btn-outline-primary">
                                    {{ Str::upper($asset->name) }} COMPLIANCE PLAN
                                </x-button>
                            </a>
                            <a class="md:w-auto w-full" href="{{ route('admin.companies.detail.compliance.pdf', [$company->id, $asset->id]) }}">
                                <x-button type="submit" class="btn-outline-primary">
                                    DETAIL COMPLIANCE PLAN
                                </x-button>
                            </a>
                            <x-nav-link href="{{ route('admin.companies.asset.work_order.create', [$company->id, $asset->id]) }}" class="btn btn-outline-primary">
                                <em class="fa-solid fa-circle-plus"></em> ADD NEW WORK ORDER
                            </x-nav-link>
                        </div>
                        <livewire:work-order-table
                            :where="[
                                ['type', '=', config('apg.type.company')],
                                ['company_id', '=', $company->id],
                            ]"
                            view-file="admin.company.asset.work-order-table"
                            :asset="$asset"
                        />
                        <livewire:sweet-alert component="work-order-table" entityTitle="workorder" />
                    </div>
                </div>
                {{-- tabs end --}}
            </div>
        </div>
    </div>
    @push('script')
    <script src="{{ asset('js/googlemaps.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_map_key')}}&libraries=places&callback=locateView" type="text/javascript">
    </script>
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            let actionType = "{{ request()->get('action_type') }}";
            if (actionType == 'compliance-plan') {
                document.getElementById('tabs-comp-tab').click();
            }
        });
    </script>
    @endpush
</x-app-layout>
