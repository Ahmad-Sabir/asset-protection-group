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
                        <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
                    </x-button>
                </div>
                <div class="form-group">
                    <x-button type="button" class="btn-outline-primary">
                        <em class="fa-solid fa-cloud-arrow-down"></em> Download CSV
                    </x-button>
                </div>
                <div class="form-group">
                    <x-button type="button" class="btn-primary" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <em class="fa-solid fa-circle-plus"></em> Add Assets
                    </x-button>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="main-wrapper">
                <div class="admin-tabs">
                    <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-home" class="nav-link active" id="tabs-home-tab" data-bs-toggle="pill"
                                data-bs-target="#tabs-home" role="tab" aria-controls="tabs-home"
                                aria-selected="true">ASSET DETAILS</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-profile" class="nav-link" id="tabs-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#tabs-profile" role="tab" aria-controls="tabs-profile"
                                aria-selected="false">UPLOAD IMAGES</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-messages" class="nav-link" id="tabs-messages-tab" data-bs-toggle="pill"
                                data-bs-target="#tabs-messages" role="tab" aria-controls="tabs-messages"
                                aria-selected="false">LOCATION</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabs-tabContent">
                        <div class="tab-pane fade show active" id="tabs-home" role="tabpanel"
                            aria-labelledby="tabs-home-tab">
                            <div class="form-group w-64">
                                <select class="form-select alt-form-select w-64">
                                    <option selected="">Select Saved Filter</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            <div class="filters-section filters-group">
                                <div class="form-group w-96">
                                    <label for="exampleFormControlInpu3" class="form-label">Search</label>
                                    <input type="text" class="form-control w-96" id="exampleFormControlInput3"
                                        placeholder="">
                                </div>
                                <div class="form-group w-96">
                                    <label for="exampleFormControlInpu3" class="form-label">Search</label>
                                    <select class="form-select w-96">
                                        <option selected="">Select Saved Filter</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <x-label for="created_on">Created On</x-label>
                                    <x-date-picker mode="range"></x-date-picker>
                                </div>

                                <span class="filters-group-show">
                                    <x-range-bar></x-range-bar>

                                    <div class="form-group w-96">
                                        <label for="exampleFormControlInpu3" class="form-label">Search</label>
                                        <select class="form-select w-96">
                                            <option selected="">Select Saved Filter</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <x-label for="created_on">Created On</x-label>
                                        <x-date-picker mode="range"></x-date-picker>
                                    </div>
                                    <div class="form-group">
                                        <x-label for="created_on">Created On</x-label>
                                        <x-date-picker mode="range"></x-date-picker>
                                    </div>
                                    <div class="form-group w-96">
                                        <label for="exampleFormControlInpu3" class="form-label">Search</label>
                                        <select class="form-select w-96">
                                            <option selected="">Select Saved Filter</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="form-group w-96">
                                        <label for="exampleFormControlInpu3" class="form-label">Search</label>
                                        <select class="form-select w-96">
                                            <option selected="">Select Saved Filter</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="form-group w-40">
                                        <label for="exampleNumber0" class="form-label">Number input</label>
                                        <input type="number" class="form-control w-40" id="exampleNumber0"
                                            placeholder="Number input">
                                    </div>
                                    <div class="form-group w-40">
                                        <label for="exampleNumber0" class="form-label">Number input</label>
                                        <input type="number" class="form-control w-40" id="exampleNumber0"
                                            placeholder="Number input">
                                    </div>
                                    <div class="form-group w-40">
                                        <label for="exampleNumber0" class="form-label">Number input</label>
                                        <input type="number" class="form-control w-40" id="exampleNumber0"
                                            placeholder="Number input">
                                    </div>
                                    <div class="form-group w-40">
                                        <label for="exampleNumber0" class="form-label">Number input</label>
                                        <input type="number" class="form-control w-40" id="exampleNumber0"
                                            placeholder="Number input">
                                    </div>
                                    <div class="form-group w-40">
                                        <label for="exampleNumber0" class="form-label">Number input</label>
                                        <input type="number" class="form-control w-40" id="exampleNumber0"
                                            placeholder="Number input">
                                    </div>
                                    <div class="flex justify-end items-center w-full">
                                        <div class="form-group">
                                            <x-button class="btn-outline-primary">SAVE FILTER</x-button>
                                        </div>
                                        <div class="form-group">
                                            <x-button class="btn-secondary">FILTER</x-button>
                                        </div>
                                        <x-nav-link href="#">Clear All</x-nav-link>
                                    </div>

                                </span>
                            </div>
                            <div class="flex justify-center my-6 border-t">
                                <x-button class="more-text-btn">Advanced Filter</x-button>
                            </div>

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
                                            <li class="page-item disabled"><a class="page-link" href="#"
                                                    tabindex="-1" aria-disabled="true"><em
                                                        class="fa-solid fa-chevron-left"></em></a></li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">2 <span
                                                        class="visually-hidden">(current)</span></a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#"><em
                                                        class="fa-solid fa-chevron-right"></em></a></li>
                                        </ul>
                                    </nav>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-profile" role="tabpanel"
                            aria-labelledby="tabs-profile-tab">
                            <div class="tab-content-wrapper">
                                <div class="columns-4">
                                    <div class="image-container">
                                        <img src="/assets/images/company-asset-image1.png" data-action="zoom"
                                            class="image" alt="">
                                        <div class="middle">
                                            <em class="fa-solid fa-xmark"></em>
                                        </div>
                                    </div>
                                    <div class="image-container">
                                        <img src="/assets/images/company-asset-image2.png" data-action="zoom"
                                            class="image" alt="">
                                        <div class="middle">
                                            <em class="fa-solid fa-xmark"></em>
                                        </div>
                                    </div>
                                    <div class="image-container">
                                        <img src="/assets/images/company-asset-image3.png" data-action="zoom"
                                            class="image" alt="">
                                        <div class="middle">
                                            <em class="fa-solid fa-xmark"></em>
                                        </div>
                                    </div>
                                    <div class="image-upload">
                                        <div class="custom-file-upload image-file-upload">
                                            <em class="fa-solid fa-upload"></em>
                                            <input class="form-control" type="file" id="formFile">
                                            <span class="pt-2">Upload Image</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-messages" role="tabpanel"
                            aria-labelledby="tabs-profile-tab">
                            <div class="tab-content-wrapper">
                                <form action="">
                                    <div class="form-group">
                                        <label for="" class=" form-label">Drag the pin on the map to update the
                                            location or provide latitude and longitude coordinates for the
                                            location.</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Latitude</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3"
                                            placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Longitude</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3"
                                            placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInpu3" class="form-label">Location
                                            Name</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput3"
                                            placeholder="">
                                    </div>
                                    <div class="mapouter mb-4">
                                        <div class="gmap_canvas">
                                            <iframe width="100%" height="418" class="gmap-canvas" id="gmap_canvas"
                                                src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                                title=""></iframe>
                                            <a
                                                href="https://www.embedgooglemap.net/blog/divi-discount-code-elegant-themes-coupon/"></a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit"><em
                                                class="fa-solid fa-check"></em> save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- tabs end --}}
                </div>
            </div>
        </div>
    </div>
    @pushOnce('script')
    <script src="{{ asset('js/show-more.js') }}" defer></script>
    @endPushOnce
</x-app-layout>
