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
                        <em class="fa-solid fa-cloud-arrow-down"></em> Download CSV
                    </x-button>
                </div>
                <div class="form-group">

                    <x-button type="button" class="btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <em class="fa-solid fa-circle-plus"></em> Add Employee
                    </x-button>
                </div>
                <div class="form-group">

                    <x-button type="button" class="btn-primary" data-bs-toggle="offcanvas" data-bs-target="#view" aria-controls="offcanvasRight">
                        <em class="fa-solid fa-eye"></em> View Employee
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
                        <x-label for="created_on">Created On</x-label>
                        <x-date-picker id="created_on" mode="range" autocomplete="off" data-input>
                        </x-date-picker>
                    </div>
                    <div class="form-group">
                        {{-- multi-range-bar start --}}
                        {{-- <div class="multi-range-bar">
                    <label for="floatingInput" class="form-label">Select a date</label>
                    <div class="container">
                        <div class="sliderRange">
                            <div class="track"></div>
                        </div>
                        <div class="output o0"> </div>
                        <div class="thumb t0"></div>

                        <div class="output o1"> </div>
                        <div class="thumb t1"></div>
                    </div>
                </div> --}}
                        <x-range-bar></x-range-bar>
                        {{-- multi-range-bar end --}}
                    </div>
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

        </div>


    </div>

    {{-- right sidebar start --}}
    <div class="right-sidebar offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="right-sidebar-header">
            <h5><a href="" data-bs-dismiss="offcanvas"><em class="fa-solid fa-arrow-left"></em></a>
                Add Employee
            </h5>
            <button type="button" class="btn-close w-4 h-4 hidden" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="right-sidebar-content">
            <form action="">
                <div class="upload-image">
                    <div class="image">
                        <img src="/assets/images/user-img.png" alt="">
                    </div>
                    <div class="custom-file-upload">
                        <em class="fa-solid fa-sliders"></em> UPLOAD
                        <input class="form-control" type="file" id="formFile">
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInpu3" class="form-label">APG Employee ID</label>
                    <input type="text" class="form-control" id="exampleFormControlInput3" />
                    <span class="invalid">Invalid username </span>
                    <span class="invalid hidden">Invalid username </span>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInpu3" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="" />
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInpu3" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="" />
                </div>
                <div class="form-group">
                    <label for="exampleNumber0" class="form-label">Phone</label>
                    <input type="number" class="form-control" id="exampleNumber0" placeholder="" />
                </div>
                <div class="form-group">
                    <label for="exampleEmail0" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleEmail0" placeholder="" />
                </div>
                <div class="form-group">
                    <label for="exampleEmail0" class="form-label">Role</label>
                    <select class="form-select w-full" aria-label="Default select example">
                        <option selected></option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-outline-primary" type="submit"><em class="fa-solid fa-sliders"></em> add employee</button>
                </div>
            </form>
        </div>
    </div>
    {{-- right sidebar end --}}


    {{-- right View sidebar start --}}
    <div class="right-sidebar offcanvas offcanvas-end" tabindex="-1" id="view" aria-labelledby="offcanvasRightLabel">
        <div class="right-sidebar-header">
            <h5><a href="" data-bs-dismiss="offcanvas"><em class="fa-solid fa-arrow-left"></em></a>
                View employee
            </h5>
            <button type="button" class="btn-close w-4 h-4 hidden" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="right-sidebar-content">
            <form action="">
                <div class="upload-image">
                    <div class="image">
                        <img src="/assets/images/user-img.png" alt="">
                    </div>
                    <div class="profile-name">
                        <h3>Clayton Wiatrek</h3>
                        <span>Manager</span>
                    </div>
                </div>
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

                {{-- table end --}}
                <button class="btn btn-primary mt-8" type="submit"><em class="fa-solid fa-sliders"></em> EDIT EMPLOYEE PROFILE</button>
            </form>
        </div>
    </div>
    {{-- right sidebar end --}}
</x-app-layout>
