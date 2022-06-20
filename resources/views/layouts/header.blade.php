<!-- Top Navigation -->
<header class="z-50">
    <div class="logo">
        <img src="/assets/images/logo.svg" alt="">
    </div>
    <div class="side-menu">
        <div class="flex items-center">
            <div class="notification-box mr-10" x-data="{ notification_dropdown: false }">
                <x-nav-link x-on:click="notification_dropdown = ! notification_dropdown" href="#">
                    <span id="count">{{ $noti_counts }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                    </svg>
                </x-nav-link>
                <div @click.outside="notification_dropdown = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:leave-end="transform opacity-0 scale-95" class="notification-dropdown scroll" x-show="notification_dropdown" style="display: none;">
                    <div class="w-full bg-white p-4">
                        <span class="text font-semibold mb-5">Notifications</span>
                    </div>
                    <div class="notifications-list">
                        <ul id="notify">
                            @php
                                $memberType = (auth()->user()->user_status == config('apg.user_status.employee')) ? 'employee'  : 'admin';
                            @endphp
                            @forelse ($notifications ?? [] as $notification)
                                <li class="{{ ($notification['read_at'] != null) ? 'bg-white' : 'notification-hover' }} text-sm">
                                    <a href="{{ route("$memberType.work-orders.show", [$notification->data['workorder_id'], 'notification_id' => $notification->id]) }}">
                                        {{ Str::words($notification->data['message'], 6, '...') }}
                                    </a>
                                    <span class="px-2 text-sm">{{ customDateFormat($notification->created_at, false) }}</span>
                                </li>
                            @empty
                                <li>No notification found.</li>
                            @endforelse
                            @if (count($notifications) > 0)
                            <a href="{{ route("{$memberType}.notifications") }}">
                                <button class="btn btn-outline-primary btn-outline-primary-timer w-36 view-all">
                                    View All
                                </button>
                            </a>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="group">
                <a href="#" class="user-login flex items-center h-full bg-grey-darkest px-4">
                    @php
                        $profile = Auth::user()->profile()->first();
                    @endphp
                    @if ($profile)
                        <img src="{{ $profile->url }}" alt="">
                    @else
                        <img src="{{ asset('assets/images/avatar.png') }}" alt="">
                    @endif
                    <span class="hidden md:block">{{ Auth::user()->full_name }}</span>
                </a>
                <div class="hidden group-hover:block absolute pin-r top-ful side-menu-dropdown">
                    <a href="{{ (Auth::user()->user_status == config('apg.user_status.employee')) ? route('employee.get-profile')
                        : route('admin.get-profile') }}" class="block py-3 px-3 text-white">
                        My Account
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-nav-link :href="route('logout')" class="block py-3 px-3 text-white" onclick="event.preventDefault();this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
