<div class="sidebar lg:min-h-screen z-10 fixed shadow-md bg-white lg:w-[318px] w-full">
    <div @click.away="open = false" x-data="{ open: false }">
        <div class="flex-shrink-0 pl-5 py-4 flex flex-row items-center justify-between">
            <button class="rounded-lg lg:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
                <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                    <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <nav :class="{'block': open, 'hidden': !open}" class="lg:block hidden">
            <ul>
                @if(Auth::user()->user_status == config('apg.user_status.super-admin') || Auth::user()->user_status == config('apg.user_status.admin'))
                    <li @class(['active' => request()->routeIs('admin.users.*')])>
                        <x-nav-link :href="route('admin.dashboard')" data-mdb-ripple="true" data-mdb-ripple-color="red">
                            <svg xmlns="" viewBox="0 0 20 20">
                                <g id="Group_37" data-name="Group 37" transform="translate(-2 -2)">
                                <path id="Path_29" data-name="Path 29" d="M14,10V22H4a2,2,0,0,1-2-2V10Z"/>
                                <path id="Path_30" data-name="Path 30" d="M22,10V20a2,2,0,0,1-2,2H16V10Z"/>
                                <path id="Path_31" data-name="Path 31" d="M22,4V8H2V4A2,2,0,0,1,4,2H20A2,2,0,0,1,22,4Z" />
                                </g>
                            </svg>
                            <span>Dashboard</span>
                        </x-nav-link>
                    </li>
                    <li @class(['active' => request()->routeIs('admin.users.*')])>
                        <x-nav-link :href="route('admin.users.index')" data-mdb-ripple="true" data-mdb-ripple-color="red">
                            <svg xmlns="" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 21.2 17" style="" xml:space="preserve">
                                <path id="Path_602" class="st0" d="M20.3,12.4c0.1-0.5,0.1-0.9,0-1.4l0.9-0.5c0.1-0.1,0.1-0.2,0.1-0.3c-0.2-0.7-0.6-1.4-1.1-1.9  c-0.1-0.1-0.2-0.1-0.3,0L19,8.7c-0.4-0.3-0.8-0.5-1.2-0.7v-1c0-0.1-0.1-0.2-0.2-0.2c-0.7-0.2-1.5-0.2-2.2,0c-0.1,0-0.2,0.1-0.2,0.2  v1c-0.4,0.2-0.9,0.4-1.2,0.7l-0.9-0.5c-0.1-0.1-0.2,0-0.3,0c-0.5,0.5-0.9,1.2-1.1,1.9c0,0.1,0,0.2,0.1,0.3l0.9,0.5  c-0.1,0.5-0.1,0.9,0,1.4l-0.9,0.5c-0.1,0.1-0.1,0.2-0.1,0.3c0.2,0.7,0.6,1.4,1.1,1.9c0.1,0.1,0.2,0.1,0.3,0l0.9-0.5  c0.4,0.3,0.8,0.5,1.2,0.7v1c0,0.1,0.1,0.2,0.2,0.2c0.7,0.2,1.5,0.2,2.2,0c0.1,0,0.2-0.1,0.2-0.2v-1c0.4-0.2,0.9-0.4,1.2-0.7l0.9,0.5  c0.1,0.1,0.2,0,0.3,0c0.5-0.5,0.9-1.2,1.1-1.9c0-0.1,0-0.2-0.1-0.3L20.3,12.4z M16.5,13.3c-0.9,0-1.6-0.7-1.6-1.6  c0-0.9,0.7-1.6,1.6-1.6c0.9,0,1.6,0.7,1.6,1.6C18.1,12.6,17.4,13.3,16.5,13.3C16.5,13.3,16.5,13.3,16.5,13.3L16.5,13.3z M7.4,8.5  c2.3,0,4.2-1.9,4.2-4.2S9.8,0,7.4,0l0,0C5.1,0,3.2,1.9,3.2,4.2l0,0C3.2,6.6,5.1,8.5,7.4,8.5C7.4,8.5,7.4,8.5,7.4,8.5L7.4,8.5z   M14.1,16c-0.1,0-0.2-0.1-0.2-0.1L13.6,16c-0.2,0.1-0.4,0.2-0.7,0.2c-0.4,0-0.7-0.2-1-0.4c-0.6-0.7-1.1-1.5-1.3-2.3  c-0.2-0.6,0.1-1.2,0.6-1.5l0.3-0.2c0-0.1,0-0.2,0-0.3l-0.3-0.2c-0.5-0.3-0.8-0.9-0.6-1.5c0-0.1,0.1-0.2,0.1-0.3c-0.1,0-0.2,0-0.4,0  H9.9c-0.8,0.3-1.6,0.5-2.4,0.5c-0.8,0-1.7-0.2-2.4-0.5H4.5C2,9.6,0,11.6,0,14v1.4C0,16.3,0.7,17,1.6,17l0,0h11.7  c0.3,0,0.6-0.1,0.9-0.3c0-0.1-0.1-0.3-0.1-0.4L14.1,16z"/>
                            </svg>
                            <span>Manage Admin Users</span>
                        </x-nav-link>
                    </li>
                    <li @class(['active' => request()->routeIs('admin.asset-types.*')])>
                        <x-nav-link :href="route('admin.asset-types.index')" data-mdb-ripple="true" data-mdb-ripple-color="red">
                            <svg xmlns="" viewBox="0 0 19.125 17">
                                <path id="Path_607" data-name="Path 607" d="M18.063-13.812H14.344l-1.062-1.062H10.625a1.063,1.063,0,0,0-1.062,1.063V-8.5a1.063,1.063,0,0,0,1.063,1.063h7.438A1.063,1.063,0,0,0,19.125-8.5v-4.25A1.063,1.063,0,0,0,18.063-13.812Zm0,9.563H14.344L13.281-5.312H10.625A1.063,1.063,0,0,0,9.563-4.25V1.063a1.063,1.063,0,0,0,1.063,1.063h7.438a1.063,1.063,0,0,0,1.063-1.062v-4.25A1.063,1.063,0,0,0,18.063-4.25ZM2.125-14.344a.531.531,0,0,0-.531-.531H.531A.531.531,0,0,0,0-14.344V-1.062A1.063,1.063,0,0,0,1.063,0H8.5V-2.125H2.125V-9.562H8.5v-2.125H2.125Z" transform="translate(0 14.875)"/>
                            </svg>
                            <span>Manage Asset Types</span>
                        </x-nav-link>
                    </li>
                    <li class="relative">
                        <x-nav-link class="translate-all duration-500" onclick="clickMe()" data-mdb-ripple="true" data-mdb-ripple-color="red" data-bs-toggle="collapse" data-bs-target="#manage-asset-collapse">
                            <svg xmlns="" viewBox="0 0 18 15.75">
                                <path id="Path_603" data-name="Path 603" d="M16.7-9.992,11.813-6.88v-2.4a.844.844,0,0,0-1.3-.712L5.625-6.88v-6.9a.844.844,0,0,0-.844-.844H.844A.844.844,0,0,0,0-13.781V.281a.844.844,0,0,0,.844.844H17.156A.844.844,0,0,0,18,.281V-9.28A.844.844,0,0,0,16.7-9.992ZM14.2-2.25H12.8a.422.422,0,0,1-.422-.422V-4.078A.422.422,0,0,1,12.8-4.5H14.2a.422.422,0,0,1,.422.422v1.406A.422.422,0,0,1,14.2-2.25Zm-4.5,0H8.3a.422.422,0,0,1-.422-.422V-4.078A.422.422,0,0,1,8.3-4.5H9.7a.422.422,0,0,1,.422.422v1.406A.422.422,0,0,1,9.7-2.25Zm-4.5,0H3.8a.422.422,0,0,1-.422-.422V-4.078A.422.422,0,0,1,3.8-4.5H5.2a.422.422,0,0,1,.422.422v1.406A.422.422,0,0,1,5.2-2.25Z" transform="translate(0 14.625)"/>
                            </svg>
                            <span >Manage Assets</span>
                            <em class="fa-solid fa-angle-down arrow-right" id="fa-angle-down" ></em>
                        </x-nav-link>
                        <ul
                        @class([
                            'relative accordion-collapse collapse' => true,
                            'show' => request()->routeIs('admin.assets.*') || request()->routeIs('admin.company-assets'),
                        ])
                        id="manage-asset-collapse">
                            <li @class(['active' => request()->routeIs('admin.assets.*')])>
                                <x-nav-link :href="route('admin.assets.index')" data-mdb-ripple="true" data-mdb-ripple-color="red">
                                    <span>Manage Master Assets</span>
                                </x-nav-link>
                            </li>
                            <li @class(['active' => request()->routeIs('admin.company-assets')])>
                                <x-nav-link :href="route('admin.company-assets')" data-mdb-ripple="true" data-mdb-ripple-color="red">
                                    <span>Manage Company Assets</span>
                                </x-nav-link>
                            </li>
                        </ul>
                    </li>
                    <li @class(['active' => request()->routeIs('admin.work-orders.*')])>
                        <x-nav-link :href="route('admin.work-orders.index')" data-mdb-ripple="true" data-mdb-ripple-color="red">
                            <svg xmlns="" viewBox="0 0 13.5 18">
                                <path id="Path_604" data-name="Path 604" d="M10.125-6.75H3.375V-4.5h6.75Zm3.129-5.309L9.812-15.5a.843.843,0,0,0-.6-.246H9v4.5h4.5v-.214A.841.841,0,0,0,13.254-12.059Zm-5.379,1.09V-15.75H.844A.842.842,0,0,0,0-14.906V1.406a.842.842,0,0,0,.844.844H12.656a.842.842,0,0,0,.844-.844V-10.125H8.719A.846.846,0,0,1,7.875-10.969ZM2.25-13.219a.281.281,0,0,1,.281-.281H5.344a.281.281,0,0,1,.281.281v.563a.281.281,0,0,1-.281.281H2.531a.281.281,0,0,1-.281-.281Zm0,2.25a.281.281,0,0,1,.281-.281H5.344a.281.281,0,0,1,.281.281v.563a.281.281,0,0,1-.281.281H2.531a.281.281,0,0,1-.281-.281Zm9,10.688A.281.281,0,0,1,10.969,0H8.156a.281.281,0,0,1-.281-.281V-.844a.281.281,0,0,1,.281-.281h2.813a.281.281,0,0,1,.281.281Zm0-7.031v3.375a.562.562,0,0,1-.562.563H2.813a.562.562,0,0,1-.562-.562V-7.312a.562.562,0,0,1,.563-.562h7.875A.562.562,0,0,1,11.25-7.312Z" transform="translate(0 15.75)"/>
                            </svg>
                            <span>Manage Master Work Orders</span>
                        </x-nav-link>
                    </li>
                    <li @class(['active' => request()->routeIs('admin.companies.*')])>
                        <x-nav-link :href="route('admin.companies.index')" data-mdb-ripple="true" data-mdb-ripple-color="red">
                            <svg xmlns="" viewBox="0 0 21.25 14.875">
                                <path id="Path_606" data-name="Path 606" d="M20.624-13.067a9.833,9.833,0,0,0-3.865-.746c-4.09,0-8.179,2.07-12.269,2.07A10.075,10.075,0,0,1,1.414-12.2a1.135,1.135,0,0,0-.344-.054A1.057,1.057,0,0,0,0-11.2V-.662A1.056,1.056,0,0,0,.626.316a9.827,9.827,0,0,0,3.865.746c4.09,0,8.179-2.07,12.269-2.07a10.074,10.074,0,0,1,3.076.456A1.136,1.136,0,0,0,20.18-.5,1.057,1.057,0,0,0,21.25-1.555V-12.088A1.057,1.057,0,0,0,20.624-13.067ZM1.594-10.485a11.556,11.556,0,0,0,2.082.3A2.127,2.127,0,0,1,1.594-8.477Zm0,9.463V-2.608A2.124,2.124,0,0,1,3.709-.57,8.02,8.02,0,0,1,1.594-1.022Zm9.031-2.165A2.959,2.959,0,0,1,7.969-6.375a2.959,2.959,0,0,1,2.656-3.187,2.959,2.959,0,0,1,2.656,3.188A2.959,2.959,0,0,1,10.625-3.187Zm9.031.922a11.413,11.413,0,0,0-1.8-.28,2.121,2.121,0,0,1,1.8-1.636Zm0-7.84A2.121,2.121,0,0,1,17.8-12.148a7.98,7.98,0,0,1,1.853.42Z" transform="translate(0 13.813)"/>
                            </svg>
                            <span>Manage Companies</span>
                        </x-nav-link>
                    </li>
                    <li @class(['active' => request()->routeIs('admin.reports.*')])>
                        <x-nav-link :href="route('admin.reports.assets')" data-mdb-ripple="true" data-mdb-ripple-color="red">
                            <svg xmlns="" viewBox="0 0 13.5 18">
                                <path id="Path_608" data-name="Path 608" d="M7.875-10.969V-15.75H.844A.842.842,0,0,0,0-14.906V1.406a.842.842,0,0,0,.844.844H12.656a.842.842,0,0,0,.844-.844V-10.125H8.719A.846.846,0,0,1,7.875-10.969Zm2.25,8.3A.423.423,0,0,1,9.7-2.25H3.8a.423.423,0,0,1-.422-.422v-.281A.423.423,0,0,1,3.8-3.375H9.7a.423.423,0,0,1,.422.422Zm0-2.25A.423.423,0,0,1,9.7-4.5H3.8a.423.423,0,0,1-.422-.422V-5.2A.423.423,0,0,1,3.8-5.625H9.7a.423.423,0,0,1,.422.422Zm0-2.531v.281A.423.423,0,0,1,9.7-6.75H3.8a.423.423,0,0,1-.422-.422v-.281A.423.423,0,0,1,3.8-7.875H9.7A.423.423,0,0,1,10.125-7.453ZM13.5-11.464a.841.841,0,0,0-.246-.594L9.812-15.5a.843.843,0,0,0-.6-.246H9v4.5h4.5Z" transform="translate(0 15.75)"/>
                            </svg>
                            <span>Manage Reports</span>
                        </x-nav-link>
                    </li>
                    <li @class(['active' => request()->routeIs('admin.delete-logs')])>
                        <x-nav-link :href="route('admin.delete-logs')" data-mdb-ripple="true" data-mdb-ripple-color="red">
                            <svg xmlns="" viewBox="0 0 448 512"><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM207 199L127 279C117.7 288.4 117.7 303.6 127 312.1C136.4 322.3 151.6 322.3 160.1 312.1L199.1 273.9V408C199.1 421.3 210.7 432 223.1 432C237.3 432 248 421.3 248 408V273.9L287 312.1C296.4 322.3 311.6 322.3 320.1 312.1C330.3 303.6 330.3 288.4 320.1 279L240.1 199C236.5 194.5 230.4 191.1 223.1 191.1C217.6 191.1 211.5 194.5 207 199V199z"/></svg>
                            <span>Delete Logs</span>
                        </x-nav-link>
                    </li>
                    @else
                    <li @class(['active' => request()->routeIs('employee.work-orders.*')])>
                        <x-nav-link :href="route('employee.work-orders.index')" data-mdb-ripple="true" data-mdb-ripple-color="red">
                            <svg xmlns="" viewBox="0 0 13.5 18">
                                <path id="Path_604" data-name="Path 604" d="M10.125-6.75H3.375V-4.5h6.75Zm3.129-5.309L9.812-15.5a.843.843,0,0,0-.6-.246H9v4.5h4.5v-.214A.841.841,0,0,0,13.254-12.059Zm-5.379,1.09V-15.75H.844A.842.842,0,0,0,0-14.906V1.406a.842.842,0,0,0,.844.844H12.656a.842.842,0,0,0,.844-.844V-10.125H8.719A.846.846,0,0,1,7.875-10.969ZM2.25-13.219a.281.281,0,0,1,.281-.281H5.344a.281.281,0,0,1,.281.281v.563a.281.281,0,0,1-.281.281H2.531a.281.281,0,0,1-.281-.281Zm0,2.25a.281.281,0,0,1,.281-.281H5.344a.281.281,0,0,1,.281.281v.563a.281.281,0,0,1-.281.281H2.531a.281.281,0,0,1-.281-.281Zm9,10.688A.281.281,0,0,1,10.969,0H8.156a.281.281,0,0,1-.281-.281V-.844a.281.281,0,0,1,.281-.281h2.813a.281.281,0,0,1,.281.281Zm0-7.031v3.375a.562.562,0,0,1-.562.563H2.813a.562.562,0,0,1-.562-.562V-7.312a.562.562,0,0,1,.563-.562h7.875A.562.562,0,0,1,11.25-7.312Z" transform="translate(0 15.75)"></path>
                            </svg>
                            <span>Manage Work Orders</span>
                        </x-nav-link>
                    </li>
            </ul>
            @endif
            <div class="sidebar-footer">
                <p>Copyright {{ date('Y') }} APG.</p>
                <p>All Rights Reserved</p>
            </div>
        </nav>
    </div>
</div>

