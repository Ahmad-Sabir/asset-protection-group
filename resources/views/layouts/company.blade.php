@props(['company'])
<div class="main-wrap">
    <x-alert-message class="mb-4" />
    <div class="main-fixed-wrap">
        <div class="heading">
            <h1>{{ $company->name ?? '' }}</h1>
        </div>
    </div>
    <div class="main-wrapper">
        <div class="admin-tabs">
            <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a
                        @class(['nav-link' => true, 'active' => request()->route()->named('admin.companies.show')])
                        href="{{ route('admin.companies.show', request('company')) }}"
                        class="nav-link"
                        role="tab"
                        aria-controls="tabs-info"
                        aria-selected="true">
                        DASHBOARD
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        @class(['nav-link' => true, 'active' => request()->routeIs("admin.companies.users*")])
                        href="{{ route('admin.companies.users.index', request('company')) }}"
                        role="tab"
                        aria-controls="tabs-info"
                        aria-selected="true">
                        EMPLOYEES
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        @class(['nav-link' => true, 'active' => request()->routeIs("admin.companies.locations*")])
                        href="{{ route('admin.companies.locations.index', request()->route('company')) }}"
                        role="tab"
                        aria-controls="tabs-info"
                        aria-selected="true">
                        Locations
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        @class(['nav-link' => true, 'active' => request()->routeIs("admin.companies.asset-types*")])
                        href="{{ route('admin.companies.asset-types.index', request('company')) }}"
                        role="tab"
                        aria-controls="tabs-info"
                        aria-selected="true">
                        ASSET TYPES
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        @class(['nav-link' => true, 'active' => request()->routeIs("admin.companies.assets*")])
                        href="{{ route('admin.companies.assets.index', request('company')) }}"
                        role="tab"
                        aria-controls="tabs-info"
                        aria-selected="true">
                        ASSETS
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        @class(['nav-link' => true, 'active' => request()->routeIs("admin.companies.work-orders*")])
                        href="{{ route('admin.companies.work-orders.index', request('company')) }}"
                        role="tab"
                        aria-controls="tabs-info"
                        aria-selected="true">
                        WORK ORDERS
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                <a
                    @class(['nav-link' => true, 'active' => request()->routeIs("admin.companies.expenses*")])
                    href="{{ route('admin.companies.expenses.index', request('company')) }}"
                    role="tab"
                    aria-controls="tabs-info"
                    aria-selected="true">
                    EXPENSES
                </a>
                </li>
                <a href="{{ URL::previous() }}" class="btn btn-warning back-btn"> <em class="fas fa-arrow-left"></em> Go Back</a>
            </ul>
        </div>
        <main>
            {{ $slot }}
        </main>
    </div>
</div>
