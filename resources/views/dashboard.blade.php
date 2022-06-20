<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>company Assets</h1>
            </div>
            <div class="top-buttons">
                <div class="form-group">
                    <select class="form-select alt-form-select">
                        <option selected>Assets with 1 year of remaining useful life</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-group">
                    <x-button type="submit" class="btn-outline-primary">
                        <em class="fa-solid fa-sliders"></em> Filter
                    </x-button>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="main-wrapper">
                <div class="mapouter">
                    <div class="gmap_canvas"><iframe title="" width="100%" height="420" id="gmap_canvas" src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe><a href="https://www.embedgooglemap.net/blog/divi-discount-code-elegant-themes-coupon/"></a>
                    </div>
                </div>
            </div>
            <div class="main-wrapper">
                <div class="filters-section">
                    <div class="form-group">
                        <label for="exampleFormControlInpu3" class="form-label">Asset Name</label>
                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInpu3" class="form-label">Asset Name</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <x-label for="created_on">Created On</x-label>
                        <x-date-picker class="date-picker" id="created_on" mode="range" autocomplete="off" data-input>
                        </x-date-picker>
                    </div>
                    <div class="form-group location-field">
                        <label for="exampleFormControlInpu3" class="form-label">Asset Location</label>
                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Asset Location">
                        <em class="fa-solid fa-location-dot"></em>
                    </div>
                    <div class="filter-btns">
                        <div class="form-group ">
                            <x-button type="submit" class="btn-secondary filter-btn">
                                <em class="fa-solid fa-sliders"></em> Filter
                            </x-button>
                        </div>
                        <div class="form-group">
                            <a href="">Clear All</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-wrapper">
                <div class="flex justify-end mb-4">
                    <div class="popover-box ml-2">
                        <x-button type="button" class="btn-outline-primary popover-trigger"><em class="fa-solid fa-sliders"></em>Customize Table</x-button>
                        <div class="popover-content customize-table">
                            <div class="form-check flex items-center">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                <label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
                            </div>
                            <div class="form-check flex items-center">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                <label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
                            </div>
                            <div class="form-check flex items-center">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                <label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
                            </div>
                            <div class="form-check flex items-center">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                <label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- table start --}}
                <div class="table-border">
                    <table class="admin-table" aria-label="">
                        <thead>
                            <tr>
                                <th scope="col" class="">
                                    #
                                </th>
                                <th scope="col" class="">
                                    ID
                                </th>
                                <th scope="col" class="">
                                    company id
                                </th>
                                <th scope="col" class="">
                                    installation date
                                </th>
                                <th scope="col" class="">
                                    name
                                </th>
                                <th scope="col" class="">
                                    status
                                </th>
                                <th scope="col" class="">
                                    type
                                </th>
                                <th scope="col" class="">
                                    location
                                </th>
                                <th scope="col" class="">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="">1</td>
                                <td class="">
                                    0001
                                </td>
                                <td class="">
                                    E-0001
                                </td>
                                <td class="">
                                    9/14/2020
                                </td>
                                <td class="">
                                    Chlorine Scale
                                </td>
                                <td class="s-active">
                                    Active
                                </td>
                                <td class="">
                                    Maintenance
                                </td>
                                <td class="">
                                    Well GST
                                </td>
                                <td class="">
                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="">1</td>
                                <td class="">
                                    0001
                                </td>
                                <td class="">
                                    E-0001
                                </td>
                                <td class="">
                                    9/14/2020
                                </td>
                                <td class="">
                                    Chlorine Scale
                                </td>
                                <td class="s-active">
                                    Active
                                </td>
                                <td class="">
                                    Maintenance
                                </td>
                                <td class="">
                                    Well GST
                                </td>
                                <td class="">
                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="">1</td>
                                <td class="">
                                    0001
                                </td>
                                <td class="">
                                    E-0001
                                </td>
                                <td class="">
                                    9/14/2020
                                </td>
                                <td class="">
                                    Chlorine Scale
                                </td>
                                <td class="s-active">
                                    Active
                                </td>
                                <td class="">
                                    Maintenance
                                </td>
                                <td class="">
                                    Well GST
                                </td>
                                <td class="">
                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>
                                    0001
                                </td>
                                <td class="">
                                    E-0001
                                </td>
                                <td class="">
                                    9/14/2020
                                </td>
                                <td class="">
                                    Chlorine Scale
                                </td>
                                <td class="s-active">
                                    Active
                                </td>
                                <td>
                                    Maintenance
                                </td>
                                <td>
                                    Well GST
                                </td>
                                <td>
                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- table end --}}
            </div>
        </div>


    </div>
    @pushOnce('script')

    <script>
        var popovers = document.querySelectorAll('.popover-box');
        var popoverTriggers = document.querySelectorAll('.popover-trigger');

        for (var i = 0; i < popoverTriggers.length; i++) {
            popoverTriggers[i].addEventListener('click', function(event) {
                this.parentElement.classList.toggle('popover-active');
            });
        }
    </script>

    @endPushOnce
</x-app-layout>
