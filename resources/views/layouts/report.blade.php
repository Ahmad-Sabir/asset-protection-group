@props(['company'])
<div class="main-wrap">
    <x-alert-message class="mb-4" />
    <div class="main-fixed-wrap">
        <div class="heading">
            <h1>Manage Reports</h1>
        </div>
    </div>
    <div class="main-wrapper">
        <div class="admin-tabs">
            <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a
                        @class(['nav-link' => true, 'active' => request()->route()->named('admin.reports.assets')])
                        href="{{ route('admin.reports.assets') }}"
                        class="nav-link"
                        role="tab"
                        aria-controls="tabs-info"
                        aria-selected="true">
                        ASSETS
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        @class(['nav-link' => true, 'active' => request()->route()->named('admin.reports.work-orders')])
                        href="{{ route('admin.reports.work-orders') }}"
                        class="nav-link"
                        role="tab"
                        aria-controls="tabs-info"
                        aria-selected="true">
                        WORK ORDERS
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        @class(['nav-link' => true, 'active' => request()->route()->named('admin.reports.comapnies')])
                        href="{{ route('admin.reports.comapnies') }}"
                        class="nav-link"
                        role="tab"
                        aria-controls="tabs-info"
                        aria-selected="true">
                        COMPANIES
                    </a>
                </li>
            </ul>
        </div>
        <main>
            {{ $slot }}
        </main>
    </div>
</div>
