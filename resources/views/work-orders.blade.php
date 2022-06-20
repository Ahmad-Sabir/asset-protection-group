    <x-app-layout>
        <!-- Content -->
        <div class="main-wrap">
            <div class="main-fixed-wrap">
                <div class="heading">
                    <h1>manage employees</h1>
                </div>
                <div class="top-buttons">
                    <div class="form-group">
                        <x-button type="submit" class="btn-outline-primary">
                            <em class="fa-solid fa-cloud-arrow-down"></em> Download PDF
                        </x-button>
                    </div>
                    <div class="form-group">
                        <x-button type="submit" class="btn-primary">
                            <em class="fa-solid fa-cloud-arrow-down"></em> Download CSV
                        </x-button>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="main-wrapper">
                    <div class="grid grid-rows-1">

                        <div class="grid grid-cols-1 gap-4">
                            <div class="form-group">
                                <x-button type="submit" class="btn-outline-primary">
                                    <em class="fa-solid fa-circle-plus"></em> ADD NEW WORK ORDER
                                </x-button>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="container filters-wrapper">
                        <div class="grid grid-rows-2">

                            <div class="grid grid-cols-3 gap-4">
                                <div class="form-group">
                                    <x-button type="submit" class="btn-outline-secondary">
                                        View Work Order Of Current Month
                                    </x-button>
                                </div>
                                <div class="form-group">
                                    <x-button type="submit" class="btn-outline-secondary">
                                        View Work Order Of Current Month
                                    </x-button>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                                </div>

                            </div>
                            <div class="grid grid-cols-3 gap-4">
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
                                    <x-date-picker></x-date-picker>
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
                    {{-- table start --}}
                    <div class="table-border">
                        <table class="admin-table" aria-label="">
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

                    {{-- table end --}}
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
                <div class="work-order-details-section">
                    <section class="banner-image">
                        <img src="/assets/images/work-order-details-image.png" alt="image">
                    </section>
                    <div class="main-wrapper">
                        <div class="sm:flex items-center">
                            <p class="gray1">ID WO 0001</p>
                            <div class="sm:ml-auto gray1">

                                <a href="#">Edit Details <em class="fa-solid fa-pen ml-2"></em></a>

                            </div>
                        </div>
                        <div class="heading mt-2">
                            <h3>Change Filter</h3>
                        </div>
                        <div class="sm:flex items-center my-3">
                            <div class="form-group">
                                <select class="form-select form-select-green">
                                    <option selected="">Status: In Progress</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="form-group ml-3">
                                <select class="form-select form-select-outline-gray">
                                    <option selected="">Priority: High</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="sm:ml-auto gray1">

                                <x-popover></x-popover>

                            </div>
                        </div>
                        <hr>
                        <div class="container">


                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-base">Description</h4>
                                    <p class="gray1 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                                </div>
                                <div>
                                    <h4 class="text-base">Attachments</h4>
                                    <div class="flex flex-wrap gap-3 mt-3">
                                        <div class="image-box">
                                            <img src="/assets/images/company-asset-image1.png" data-action="zoom" alt="image" class="image">
                                        </div>
                                        <div class="image-box">
                                            <img src="/assets/images/company-asset-image2.png" data-action="zoom" alt="image" class="image">
                                        </div>
                                        <div class="image-box">
                                            <img src="/assets/images/company-asset-image3.png" data-action="zoom" alt="image" class="image">
                                        </div>
                                        <div class="doc-file">
                                            <em class="fa-solid fa-file-lines"></em>
                                            <span class="mt-3">File Name .docx</span>
                                        </div>
                                        <div class="doc-file">
                                            <em class="fa-solid fa-file-pdf"></em>
                                            <span class="mt-3">File Name .pdf</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-6 mt-4">
                                <div>
                                    <table class="admin-table" aria-label="">
                                        <th></th>
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
                                                    <div class="flex items-center justify-end">
                                                        <div class="user-image"><img src="/assets/images/user-image.png" alt="image">

                                                        </div>
                                                        <p class="ml-2">Mark Roberts</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <table class="admin-table mt-4" aria-label="">
                                        <th></th>
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
                                        <th></th>
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
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4"><a class="primary" href="#">Read More</a></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="main-wrapper">
                            <div class="flex items-center">
                                <h3 class="text-lg">TASKS</h3>
                                <a class="primary ml-auto font-semibold" href=""><em class="fa-solid fa-plus"></em> ADD TASK</a>

                            </div>
                            <hr class="mt-3">
                            <div class="form-check flex">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="gray1 ml-3" for="flexCheckDefault">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</label>
                            </div>
                            <p class="primary mt-3">Due On: 09/08/2015</p>

                            <hr class="mt-3">
                            <div class="form-check flex">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="gray1 ml-3 line-through" for="flexCheckDefault">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</label>
                            </div>
                            <p class="primary mt-3">Due On: 09/08/2015</p>
                        </div>
                        <div class="main-wrapper">
                            <div class="flex items-center">
                                <h3 class="text-lg">ADDITIONAL COST</h3>
                                <a class="primary ml-auto font-semibold" href=""><em class="fa-solid fa-plus"></em> ADD EXPENSES</a>

                            </div>
                            <table class="admin-table mt-4" aria-label="">
                                <th></th>
                                <tbody>
                                    <tr class="border-b border-t">
                                        <td class="gray3">Item</td>
                                        <td class="text-right">
                                            $5.00
                                        </td>


                                    </tr>
                                    <tr class="border-b">
                                        <td class="gray3">Item</td>
                                        <td class="text-right">
                                            $5.00
                                        </td>


                                    </tr>
                                    <tr class="border-b">
                                        <td class="gray3">Item</td>
                                        <td class="text-right">
                                            $5.00
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-bold">Total Cost</td>
                                        <td class="text-right font-bold">
                                            $15.00
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>


                <div class="work-order-details-section">
                    <section class="banner-image">
                        <img src="/assets/images/work-order-details-image.png" alt="image">
                    </section>
                    <div class="main-wrapper">
                        <div class="sm:flex items-center">
                            <p class="gray1">ID WO 0001</p>
                            <div class="sm:ml-auto gray1">

                                <div class="form-group">
                                    <x-button type="submit" class="btn-primary">
                                        <em class="fa-solid fa-sliders"></em> Save Changes
                                    </x-button>
                                </div>

                            </div>
                        </div>
                        <div class="heading mt-2">
                            <h3>Change Filter</h3>
                        </div>
                        <div class="sm:flex items-center my-3">
                            <div class="form-group">
                                <select class="form-select form-select-green">
                                    <option selected="">Status: In Progress</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="form-group ml-3">
                                <select class="form-select form-select-outline-gray">
                                    <option selected="">Priority: High</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="sm:ml-auto gray1">

                                <x-popover></x-popover>

                            </div>
                        </div>
                        <hr>
                        <div class="container">


                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-base">Description</h4>
                                    <p class="gray1 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                                </div>
                                <div>
                                    <h4 class="text-base">Attachments</h4>
                                    <div class="flex flex-wrap gap-3 mt-3">
                                        <div class="image-box">
                                            <img src="/assets/images/company-asset-image1.png" data-action="zoom" alt="image" class="image">
                                        </div>
                                        <div class="image-box">
                                            <img src="/assets/images/company-asset-image2.png" data-action="zoom" alt="image" class="image">
                                        </div>
                                        <div class="image-box">
                                            <img src="/assets/images/company-asset-image3.png" data-action="zoom" alt="image" class="image">
                                        </div>
                                        <div class="doc-file">
                                            <em class="fa-solid fa-file-lines"></em>
                                            <span class="mt-3">File Name .docx</span>
                                        </div>
                                        <div class="doc-file">
                                            <em class="fa-solid fa-file-pdf"></em>
                                            <span class="mt-3">File Name .pdf</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-6 mt-4">
                                <div>
                                    <table class="admin-table" aria-label="">
                                        <th></th>
                                        <tbody>
                                            <tr class="border-b border-t">
                                                <td class="gray3">Location:</td>
                                                <td class="text-right">
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Asset:</td>
                                                <td class="text-right">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Asset Type:</td>
                                                <td class="text-right">
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Asset Type:</td>
                                                <td class="text-right">
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <table class="admin-table" aria-label="">
                                        <th></th>
                                        <tbody>
                                            <tr class="border-b border-t">
                                                <td class="gray3">Due Date</td>
                                                <td class="text-right">
                                                    <div class="form-group">
                                                        <x-date-picker></x-date-picker>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Last Updated</td>
                                                <td class="text-right">
                                                    <div class="form-group">
                                                        <x-date-picker></x-date-picker>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Created On</td>
                                                <td class="text-right">
                                                    <div class="form-group">
                                                        <x-date-picker></x-date-picker>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Asset Type:</td>
                                                <td class="text-right">
                                                    <div class="form-group w-full">
                                                        <input type="text" class="form-control w-full" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <table class="admin-table" aria-label="">
<th></th>
                                        <tbody>
                                            <tr class="border-b border-t">
                                                <td class="gray3">Work Order Type</td>
                                                <td class="text-right">
                                                    <div class="form-group w-full">
                                                        <input type="text" class="form-control w-full" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3">Work Order Freq.</td>
                                                <td class="text-right">
                                                    <div class="form-group w-full">
                                                        <input type="text" class="form-control w-full" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                                                    </div>
                                                </td>


                                            </tr>
                                            <tr class="border-b">
                                                <td class="gray3 w-40">Notes</td>
                                                <td class="text-right">
                                                    <div class="form-group w-full">
                                                        <textarea class="form-control w-full" id="description" name="description" rows="4" cols="5" placeholder="Additional Information"></textarea>
                                                        <span class="invalid" x-text="errorMessages.description"></span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4"><a class="primary" href="#">Read More</a></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="main-wrapper tasks-box">
                            <div class="flex items-center">
                                <h3 class="text-lg">TASKS</h3>
                                <a class="primary ml-auto font-semibold" href=""><em class="fa-solid fa-plus"></em> ADD TASK</a>

                            </div>
                            <hr class="mt-3">
                            <table class="admin-table" aria-label="">
<th></th>
                                <tbody>
                                    <tr>
                                        <td class="w-20"><a href="#"><em class="fa-solid fa-trash" aria-hidden="true"></em></a></td>
                                        <td>
                                            <div class="form-group w-full task-text-area">
                                                <textarea class="form-control w-full task-text-area" id="description" name="description" rows="4" cols="5" placeholder="Additional Information"></textarea>
                                                <span class="invalid" x-text="errorMessages.description"></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-20"></td>
                                        <td>
                                            <div class="form-group">
                                                <x-label for="created_on">Due Date</x-label>
                                                <x-date-picker></x-date-picker>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="main-wrapper">
                            <div class="flex items-center">
                                <h3 class="text-lg">ADDITIONAL COST</h3>
                                <a class="primary ml-auto font-semibold" href=""><em class="fa-solid fa-plus"></em> ADD EXPENSES</a>

                            </div>
                            <hr class="mt-3">
                            <table class="admin-table" aria-label="">
<th></th>
                                <tbody>
                                    <tr class="border-b">
                                        <td class="gray3">Item</td>
                                        <td class="text-right">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                                            </div>
                                        </td>
                                        <td class="text-right w-20">
                                            <a href="#" class="gray5 mr-3"><em class="fa-solid fa-trash" aria-hidden="true"></em></a>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-t">
                                        <td class="gray3">Item</td>
                                        <td class="text-right">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                                            </div>
                                        </td>
                                        <td class="text-right w-20">
                                            <a href="#" class="gray5 mr-3"><em class="fa-solid fa-trash" aria-hidden="true"></em></a>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-t">
                                        <td class="gray3">Item</td>
                                        <td class="text-right">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Asset Name/ID">
                                            </div>
                                        </td>
                                        <td class="text-right w-20">
                                            <a href="#" class="gray5 mr-3"><em class="fa-solid fa-trash" aria-hidden="true"></em></a>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-bold">Total Cost</td>
                                        <td></td>
                                        <td class="text-right font-bold">
                                            $15.00
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- right sidebar end --}}
    </x-app-layout>
