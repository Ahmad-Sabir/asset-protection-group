<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>manage company assets</h1>
            </div>
            <div class="top-buttons">
                <div class="form-group">
                    <x-button type="submit" class="btn-outline-secondary">
                        <em class="fa-solid fa-sliders"></em> Download PDF
                    </x-button>
                </div>
                <div class="form-group">
                    <x-button type="button" class="btn-outline-primary">
                        <em class="fa-solid fa-sliders"></em> Download CSV
                    </x-button>
                </div>
                <div class="form-group">
                    <x-button type="button" class="btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <em class="fa-solid fa-sliders"></em> Add Assets
                    </x-button>
                </div>
            </div>
        </div>
        <div class="main-content">
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
                        <x-date-picker id="created_on" mode="range" autocomplete="off" data-input></x-date-picker>
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

                </div>
                <div class="filters-end">
                    <div class="form-group">
                        <label for="exampleFormControlInpu3" class="form-label"></label>
                        <x-button type="submit" class="btn-secondary">
                            <em class="fa-solid fa-sliders"></em> Filter
                        </x-button>
                    </div>
                    <div class="form-group">
                        <a href="">Clear All</a>
                    </div>
                </div>
            </div>
            <div class="main-wrapper">

                <div class="admin-tabs switch-tabs">

                    <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-map" class="nav-link" id="tabs-map-tab" data-bs-toggle="pill" data-bs-target="#tabs-map" role="tab" aria-controls="tabs-map" aria-selected="true"><em class="fa-solid fa-map"></em> Map</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-table" class="nav-link active" id="tabs-table-tab" data-bs-toggle="pill" data-bs-target="#tabs-table" role="tab" aria-controls="tabs-table" aria-selected="false"><em class="fa-solid fa-list"></em> Table</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabs-tabContent">
                        <div class="tab-pane fade show active" id="tabs-table" role="tabpanel" aria-labelledby="tabs-table-tab">
                            {{-- table start --}}
                            <div class="entries">
                                <div class="form-group">
                                    <span>Showing</span>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>4</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <span>entries</span>
                                </div>
                            </div>
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
                                            <td>
                                                <div class="table-icons">
                                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                                    <em class="fa-solid fa-pen"></em>
                                                    <em class="fa-solid fa-trash"></em>
                                                </div>
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
                                            <td>
                                                <div class="table-icons">
                                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                                    <em class="fa-solid fa-pen"></em>
                                                    <em class="fa-solid fa-trash"></em>
                                                </div>
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
                                            <td class="s-inactive">
                                                Inactive
                                            </td>
                                            <td class="">
                                                Maintenance
                                            </td>
                                            <td class="">
                                                Well GST
                                            </td>
                                            <td>
                                                <div class="table-icons">
                                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                                    <em class="fa-solid fa-pen"></em>
                                                    <em class="fa-solid fa-trash"></em>
                                                </div>
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
                                                <div class="table-icons">
                                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                                    <em class="fa-solid fa-pen"></em>
                                                    <em class="fa-solid fa-trash"></em>
                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination">
                                <div class="total-page-label"><span>Showing 1 to 9 of 2,341 results</span></div>
                                <div class="total-pages">
                                    <nav aria-label="Page navigation example">
                                        <ul>
                                            <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true"><em class="fa-solid fa-chevron-left"></em></a></li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">2 <span class="visually-hidden">(current)</span></a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#"><em class="fa-solid fa-chevron-right"></em></a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-map" role="tabpanel" aria-labelledby="tabs-map-tab">
                            <div class="mapouter">
                                <div class="gmap_canvas"><iframe width="100%" height="420" id="gmap_canvas" src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net/blog/divi-discount-code-elegant-themes-coupon/"></a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="main-wrapper">
                <div class="admin-tabs">
                    <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-home" class="nav-link active" id="tabs-home-tab" data-bs-toggle="pill" data-bs-target="#tabs-home" role="tab" aria-controls="tabs-home" aria-selected="true">ASSET DETAILS</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-profile" class="nav-link" id="tabs-profile-tab" data-bs-toggle="pill" data-bs-target="#tabs-profile" role="tab" aria-controls="tabs-profile" aria-selected="false">UPLOAD IMAGES</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-messages" class="nav-link" id="tabs-messages-tab" data-bs-toggle="pill" data-bs-target="#tabs-messages" role="tab" aria-controls="tabs-messages" aria-selected="false">LOCATION</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabs-tabContent">
                        <div class="tab-pane fade show active" id="tabs-home" role="tabpanel" aria-labelledby="tabs-home-tab">
                            <div class="tab-content-wrapper">
                                <form action="">
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label disabled-label">APG Asset ID</label>
                                        <input type="text" class="form-control disabled-input" disabled id="exampleFormControlInput3" placeholder="APG-001">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Company Asset ID</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Status</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Manufacturer</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Asset Type</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Purchase Date</label>
                                        <div class="datepicker relative" data-mdb-toggle-button="false">
                                            <input type="text" class="form-control" placeholder="" />
                                            <button class="datepicker-toggle-button" data-mdb-toggle="datepicker">
                                                <em class="fas fa-calendar datepicker-toggle-icon"></em>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Installation Date</label>
                                        <div class="datepicker relative" data-mdb-toggle-button="false">
                                            <input type="text" class="form-control" placeholder="" />
                                            <button class="datepicker-toggle-button" data-mdb-toggle="datepicker">
                                                <em class="fas fa-calendar datepicker-toggle-icon"></em>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Purchase Price</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Warranty Expiration</label>
                                        <div class="datepicker relative" data-mdb-toggle-button="false">
                                            <input type="text" class="form-control" placeholder="" />
                                            <button class="datepicker-toggle-button" data-mdb-toggle="datepicker">
                                                <em class="fas fa-calendar datepicker-toggle-icon"></em>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Total Useful Life</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label disabled-label">Remaining Useful Life</label>
                                        <input type="text" class="form-control disabled-input" disabled id="exampleFormControlInput3" placeholder="1 Year, 2 Months, 3 Days">
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit"><em class="fa-solid fa-check"></em> save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-profile" role="tabpanel" aria-labelledby="tabs-profile-tab">
                            <div class="tab-content-wrapper">
                                <div class="columns-4">
                                    <div class="image-container">
                                        <img src="/assets/images/company-asset-image1.png" data-action="zoom" class="image">
                                        <div class="middle">
                                            <em class="fa-solid fa-xmark"></em>
                                        </div>
                                    </div>
                                    <div class="image-container">
                                        <img src="/assets/images/company-asset-image2.png" data-action="zoom" class="image">
                                        <div class="middle">
                                            <em class="fa-solid fa-xmark"></em>
                                        </div>
                                    </div>
                                    <div class="image-container">
                                        <img src="/assets/images/company-asset-image3.png" data-action="zoom" class="image">
                                        <div class="middle">
                                            <em class="fa-solid fa-xmark"></em>
                                        </div>
                                    </div>
                                    <div class="image-upload">
                                        <div class="custom-file-upload image-file-upload">
                                            <i class="fa-solid fa-upload"></i>
                                            <input class="form-control" type="file" id="formFile">
                                            <span class="pt-2">Upload Image</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-messages" role="tabpanel" aria-labelledby="tabs-profile-tab">
                            <div class="tab-content-wrapper">
                                <form action="">
                                    <div class="form-group">
                                        <label for="" class=" form-label">Drag the pin on the map to update the location or provide latitude and longitude coordinates for the location.</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Latitude</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Longitude</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Location Name</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="">
                                    </div>
                                    <div class="mapouter mb-4">
                                        <div class="gmap_canvas"><iframe width="100%" height="418" class="gmap-canvas" id="gmap_canvas" src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net/blog/divi-discount-code-elegant-themes-coupon/"></a>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit"><em class="fa-solid fa-check"></em> save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- tabs end --}}
                </div>
            </div>
            <div class="main-wrapper">
                <div class="admin-tabs">
                    <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-info" class="nav-link active" id="tabs-info-tab" data-bs-toggle="pill" data-bs-target="#tabs-info" role="tab" aria-controls="tabs-info" aria-selected="true">INFORMATION</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-file" class="nav-link" id="tabs-file-tab" data-bs-toggle="pill" data-bs-target="#tabs-file" role="tab" aria-controls="tabs-file" aria-selected="false">ADDITIONAL FILES</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-comp" class="nav-link" id="tabs-comp-tab" data-bs-toggle="pill" data-bs-target="#tabs-comp" role="tab" aria-controls="tabs-comp" aria-selected="false">COMPLIANCE PLAN</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabs-tabContent">
                        <div class="tab-pane fade show active" id="tabs-info" role="tabpanel" aria-labelledby="tabs-info-tab">
                            <div class="flex justify-end items-center">
                                <div class="form-group">
                                    <x-button type="button" class="btn-outline-primary">
                                        <em class="fa-solid fa-sliders"></em> EDIT DETAILS
                                    </x-button>
                                </div>
                            </div>
                            <!-- Image Carousel -->

                            <x-carousel></x-carousel>

                            <!-- Image Carousel  end-->
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <h3>ASSET DETAILS</h3>
                                </div>
                                <div class="expense-date">
                                    <p class="pr-6">Expenses To Date</p>
                                    <p>$100.00</p>
                                </div>

                            </div>
                            <hr>
                            <div class="container">
                                <div class="grid grid-rows-1">

                                    <div class="grid grid-cols-3 gap-4">
                                        <div>
                                            <table class="admin-table mt-4" aria-label="">

                                                <tbody>
                                                    <tr class="border-b border-t">
                                                        <td class="gray3">APG Employee ID</td>
                                                        <td class="text-right">
                                                            52145
                                                        </td>


                                                    </tr>
                                                    <tr class="border-b">
                                                        <td class="gray3">Phone</td>
                                                        <td class="text-right">
                                                            +1-234-567-890
                                                        </td>


                                                    </tr>
                                                    <tr class="border-b">
                                                        <td class="gray3">Email</td>
                                                        <td class="text-right">
                                                            clayton@apg.com
                                                        </td>


                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <table class="admin-table mt-4" aria-label="">

                                                <tbody>
                                                    <tr class="border-b border-t">
                                                        <td class="gray3">APG Employee ID</td>
                                                        <td class="text-right">
                                                            52145
                                                        </td>


                                                    </tr>
                                                    <tr class="border-b">
                                                        <td class="gray3">Phone</td>
                                                        <td class="text-right">
                                                            +1-234-567-890
                                                        </td>


                                                    </tr>
                                                    <tr class="border-b">
                                                        <td class="gray3">Email</td>
                                                        <td class="text-right">
                                                            clayton@apg.com
                                                        </td>


                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="gmap_canvas"><iframe width="100%" height="418" class="gmap-canvas" id="gmap_canvas" src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net/blog/divi-discount-code-elegant-themes-coupon/"></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-file" role="tabpanel" aria-labelledby="tabs-file-tab">
                            <div class="flex justify-end items-center">
                                <div class="form-group">
                                    <x-button type="button" class="btn-outline-primary">
                                        <em class="fa-solid fa-sliders"></em> EDIT DETAILS
                                    </x-button>
                                </div>
                            </div>
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


                                            <td>
                                                <em class="fa-solid fa-download"></em>
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


                                            <td>
                                                <em class="fa-solid fa-download"></em>
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
                                            <td>
                                                <em class="fa-solid fa-download"></em>
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


                                            <td>
                                                <em class="fa-solid fa-download"></em>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="tabs-comp" role="tabpanel" aria-labelledby="tabs-comp-tab">
                            <div class="filters-end">
                                <div class="form-group">
                                    <x-button type="submit" class="btn-outline-primary">
                                        <em class="fa-solid fa-sliders"></em> DOWNLOAD COMPLIANCE PLAN
                                    </x-button>
                                </div>
                                <div class="form-group">
                                    <x-button type="submit" class="btn-primary">
                                        <em class="fa-solid fa-sliders"></em> ADD WORK ORDER
                                    </x-button>
                                </div>
                            </div>
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
                                            <td class="s-open">
                                                Open
                                            </td>
                                            <td class="">
                                                Maintenance
                                            </td>
                                            <td class="">
                                                Well GST
                                            </td>
                                            <td>
                                                <div class="table-icons">
                                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                                    <em class="fa-solid fa-pen"></em>
                                                    <em class="fa-solid fa-trash"></em>
                                                </div>
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
                                            <td>
                                                <div class="table-icons">
                                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                                    <em class="fa-solid fa-pen"></em>
                                                    <em class="fa-solid fa-trash"></em>
                                                </div>
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
                                            <td class="s-inactive">
                                                Inactive
                                            </td>
                                            <td class="">
                                                Maintenance
                                            </td>
                                            <td class="">
                                                Well GST
                                            </td>
                                            <td>
                                                <div class="table-icons">
                                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                                    <em class="fa-solid fa-pen"></em>
                                                    <em class="fa-solid fa-trash"></em>
                                                </div>
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
                                                <div class="table-icons">
                                                    <em class="fa fa-eye" aria-hidden="true"></em>
                                                    <em class="fa-solid fa-pen"></em>
                                                    <em class="fa-solid fa-trash"></em>
                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- tabs end --}}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
