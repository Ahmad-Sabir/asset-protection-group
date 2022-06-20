<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <x-button class="btn-secondary">
        <div class="spinner-border animate-spin inline-block w-5 h-5 border-4 rounded-full mr-2" role="status">
                </div>
                Processing 
        </x-button>
        
        {{-- selectr start --}}
        <x-selectr></x-selectr>
        {{-- selectr end --}}

        {{-- dropzone start --}}
        <x-dropzone></x-dropzone>
        {{-- dropzone end --}}

        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>MANAGE EMPLOYEES</h1>
            </div>
            <div class="main-button">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"> Vertically centered modal
                </button>
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Toggle right offcanvas
                </button>
                <button class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg  focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    Button with data-bs-target
                </button>
            </div>
        </div>
        <div class="comment-box mt-4 ml-[2.2rem]">
            <div class="form-group relative">
                <textarea class="form-control w-full" placeholder="Enter your Comments..."></textarea>
                <div class="comment-btns">
                    <x-button class="btn-secondary flex justify-end">Submit</x-button>
                </div>
            </div>
            <div class="image-upload">
                <x-dropzone />
            </div>

        </div>

        <div class="main-content">

            <div class="bg-blue-100 rounded-lg py-5 px-6 mb-4 text-base text-blue-700 mb-3" role="alert">
                A simple primary alert - check it out!
            </div>
            <div class="bg-purple-100 rounded-lg py-5 px-6 mb-4 text-base text-purple-700 mb-3" role="alert">
                A simple secondary alert - check it out!
            </div>
            <div class="bg-green-100 rounded-lg py-5 px-6 mb-4 text-base text-green-700 mb-3" role="alert">
                A simple success alert - check it out!
            </div>
            <div class="bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3" role="alert">
                A simple danger alert - check it out!
            </div>
            <div class="bg-yellow-100 rounded-lg py-5 px-6 mb-4 text-base text-yellow-700 mb-3" role="alert">
                A simple warning alert - check it out!
            </div>
            <div class="bg-indigo-100 rounded-lg py-5 px-6 mb-4 text-base text-indigo-700 mb-3" role="alert">
                A simple indigo alert - check it out!
            </div>
            <div class="bg-gray-50 rounded-lg py-5 px-6 mb-4 text-base text-gray-500 mb-3" role="alert">
                A simple light alert - check it out!
            </div>
            <div class="bg-gray-300 rounded-lg py-5 px-6 mb-4 text-base text-gray-800 mb-3" role="alert">
                A simple dark alert - check it out!
            </div>
            <div class="admin-form">
                <h6>customer login pages</h6>
                <ul>
                    <li><a href="{{ url('/customer-login') }}">Customer Login</a></li>
                </ul>
                {{-- form fields start --}}
                <div class="form-group">
                    <label for="exampleFormControlInpu3" class="form-label">Default input</label>
                    <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Default input" />
                </div>

                <div class="form-group">
                    <label for="exampleEmail0" class="form-label">Email input</label>
                    <input type="email" class="form-control" id="exampleEmail0" placeholder="Email input" />
                </div>

                <div class="form-group">
                    <label for="examplePassword0" class="form-label">Password input</label>
                    <input type="password" class="form-control" id="examplePassword0" placeholder="Password input" />
                </div>

                <div class="form-group">
                    <label for="exampleNumber0" class="form-label">Number input</label>
                    <input type="number" class="form-control" id="exampleNumber0" placeholder="Number input" />
                </div>

                <div class="form-group">
                    <label for="exampleURL0" class="form-label">URL input</label>
                    <input type="url" class="form-control" id="exampleURL0" placeholder="URL input" />
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Your message"></textarea>
                </div>
                <br>
                <br>
                <!-- Default checkbox -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                    <label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked />
                    <label class="form-check-label" for="flexCheckChecked">Checked checkbox</label>
                </div>
                <br>
                <br>
                <!-- Default radio -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" />
                    <label class="form-check-label" for="flexRadioDefault1"> Default radio </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked />
                    <label class="form-check-label" for="flexRadioDefault2"> Default checked radio </label>
                </div>
                <br>

                {{-- date picker --}}
                <x-date-picker></x-date-picker>
                <x-date-picker mode="range"></x-date-picker>
                {{-- date picker end --}}
                <br>

                {{-- single range bar start --}}
                <div class="single-range-bar">
                </div>
                {{-- single range bar end --}}
                <br>
                <br>
                <h6>range bar</h6>
                <x-range-bar type="single"></x-range-bar>
                {{-- multi-range-bar end --}}
                <hr>
                <br>
                <br>
                {{-- file upload --}}
                <div class="flex">
                    <div class="mb-3 w-96">
                        <label for="formFile" class="form-label inline-block mb-2 text-gray-700">Default file input
                            example</label>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                </div>
                <div class="flex">
                    <div class="mb-3 w-96">
                        <label for="formFileMultiple" class="form-label inline-block mb-2 text-gray-700">Multiple files
                            input example</label>
                        <input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="formFileMultiple" multiple>
                    </div>
                </div>
                <br>
                <br>
                {{-- select --}}
                <div class="flex">
                    <div class="mb-3 xl:w-96">
                        <select class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                {{-- switch button --}}
                <br>
                <br>
                <div class="flex">
                    <div class="form-check form-switch">
                        <input class="form-check-input appearance-none w-9 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label inline-block text-gray-800" for="flexSwitchCheckDefault">Default
                            switch checkbox input
                        </label>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>


            {{-- form fields end --}}

            {{-- table start --}}
            <br>
            <br>
            <table class="min-w-full admin-table" aria-label="">
                <thead class="bg-white border-b">
                    <tr>
                        <th scope="col" class="">
                            #
                        </th>
                        <th scope="col" class="">
                            First
                        </th>
                        <th scope="col" class="">
                            Last
                        </th>
                        <th scope="col" class="">
                            Handle
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                        <td class="">1</td>
                        <td class="">
                            Mark
                        </td>
                        <td class="">
                            Otto
                        </td>
                        <td class="">
                            @mdo
                        </td>
                    </tr>
                    <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                        <td class="">2</td>
                        <td class="">
                            Jacob
                        </td>
                        <td class="">
                            Thornton
                        </td>
                        <td class="">
                            @fat
                        </td>
                    </tr>
                    <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                        <td class="">3</td>
                        <td class="">
                            Larry
                        </td>
                        <td class="">
                            Wild
                        </td>
                        <td class="">
                            @twitter
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- table end --}}

            {{-- Range Bar Start --}}
            <br>
            <br>
            <div class="relative pt-1 single-range-bar">
                <label for="customRange1" class="form-label">Example range</label>
                <input type="range" class="form-range h-6 p-0" id="customRange1" />
            </div>
            {{-- Range Bar end --}}
            <br>
            <br>
            {{-- pagination start --}}
            <div class="flex pagination">
                <nav aria-label="Page navigation example">
                    <ul class="flex list-style-none">
                        <li class="page-item disabled"><a class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-500 pointer-events-none focus:shadow-none" href="#" tabindex="-1" aria-disabled="true">Previous</a></li>
                        <li class="page-item"><a class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none" href="#">1</a></li>
                        <li class="page-item active"><a class="page-link relative block py-1.5 px-3 rounded border-0 bg-blue-600 outline-none transition-all duration-300 rounded text-white hover:text-white hover:bg-blue-600 shadow-md focus:shadow-md" href="#">2 <span class="visually-hidden">(current)</span></a></li>
                        <li class="page-item"><a class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none" href="#">3</a></li>
                        <li class="page-item"><a class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
            {{-- pagination end --}}
            <br>
            <br>
            {{-- tabs start --}}
            <div class="admin-tabs">
                <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0 mb-4" id="tabs-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-home" class="nav-link block font-medium text-xs leading-tight uppercase border-x-0 border-t-0 border-b-2 border-transparent px-6 py-3 my-2 hover:border-transparent hover:bg-gray-100 focus:border-transparent active" id="tabs-home-tab" data-bs-toggle="pill" data-bs-target="#tabs-home" role="tab" aria-controls="tabs-home" aria-selected="true">Home</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-profile" class="nav-link block font-medium text-xs leading-tight uppercase border-x-0 border-t-0 border-b-2 border-transparent px-6 py-3 my-2 hover:border-transparent hover:bg-gray-100focus:border-transparent" id="tabs-profile-tab" data-bs-toggle="pill" data-bs-target="#tabs-profile" role="tab" aria-controls="tabs-profile" aria-selected="false">Profile</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-messages" class="nav-link block font-medium text-xs leading-tight uppercase  border-x-0 border-t-0 border-b-2 border-transparent px-6 py-3 my-2 hover:border-transparent hover:bg-gray-100 focus:border-transparent" id="tabs-messages-tab" data-bs-toggle="pill" data-bs-target="#tabs-messages" role="tab" aria-controls="tabs-messages" aria-selected="false">Messages</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-contact" class="nav-link disabled pointer-events-none block font-medium text-xs leading-tight uppercase border-x-0 border-t-0 border-b-2 border-transparent px-6 py-3 my-2 hover:border-transparent hover:bg-gray-100 focus:border-transparent" id="tabs-contact-tab" data-bs-toggle="pill" data-bs-target="#tabs-contact" role="tab" aria-controls="tabs-contact" aria-selected="false">Contact</a>
                    </li>
                </ul>
                <div class="tab-content" id="tabs-tabContent">
                    <div class="tab-pane fade show active" id="tabs-home" role="tabpanel" aria-labelledby="tabs-home-tab">
                        Tab 1 content
                    </div>
                    <div class="tab-pane fade" id="tabs-profile" role="tabpanel" aria-labelledby="tabs-profile-tab">
                        Tab 2 content
                    </div>
                    <div class="tab-pane fade" id="tabs-messages" role="tabpanel" aria-labelledby="tabs-profile-tab">
                        Tab 3 content
                    </div>
                    <div class="tab-pane fade" id="tabs-contact" role="tabpanel" aria-labelledby="tabs-contact-tab">
                        Tab 4 content
                    </div>
                </div>
                {{-- tabs end --}}
            </div>
            <br>

            <!-- Image Carousel -->

            <div class="flex items-center justify-center w-full h-full py-24 sm:py-8 px-4">
                <div class="w-full relative flex items-center justify-center">
                    <button aria-label="slide backward" class="absolute z-30 left-0 ml-10 focus:outline-none focus:bg-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 cursor-pointer" id="prev">
                        <svg class="dark:text-gray-900" width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <div class="w-full h-full mx-auto overflow-x-hidden overflow-y-hidden">
                        <div id="slider" class="h-full flex lg:gap-8 md:gap-6 gap-14 items-center justify-start transition ease-out duration-700">
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/fDngH9G/carosel-1.png" alt="black chair and white table" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 1</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/DWrGxX6/carosel-2.png" alt="sitting area" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 2</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/tCfVky2/carosel-3.png" alt="sitting area" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 2</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/rFsGfr5/carosel-4.png" alt="sitting area" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 2</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/fDngH9G/carosel-1.png" alt="black chair and white table" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 2</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/DWrGxX6/carosel-2.png" alt="sitting area" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 2</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/tCfVky2/carosel-3.png" alt="sitting area" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 2</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/rFsGfr5/carosel-4.png" alt="sitting area" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 2</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/fDngH9G/carosel-1.png" alt="black chair and white table" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 2</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/DWrGxX6/carosel-2.png" alt="sitting area" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 2</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/tCfVky2/carosel-3.png" alt="sitting area" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 2</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 relative w-full sm:w-auto">
                                <img src="https://i.ibb.co/rFsGfr5/carosel-4.png" alt="sitting area" class="object-cover object-center w-full" />
                                <div class="bg-gray-800 bg-opacity-30 absolute w-full h-full p-6">
                                    <h2 class="lg:text-xl leading-4 text-base lg:leading-5 text-white dark:text-gray-900">Catalog 2</h2>
                                    <div class="flex h-full items-end pb-6">
                                        <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-white dark:text-gray-900">Minimal Interior</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button aria-label="slide forward" class="absolute z-30 right-0 mr-10 focus:outline-none focus:bg-gray-400 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400" id="next">
                        <svg class="dark:text-gray-900" width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>


            <!-- Image Carousel  end-->


        </div>

        {{-- right sidebar start --}}
        <div class="right-sidebar offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="right-sidebar-header">
                <h5><a href="" data-bs-dismiss="offcanvas"><em class="fa-solid fa-arrow-left"></em></a>
                    VIEW EXPENSE
                </h5>
                <button type="button" class="btn-close w-4 h-4 hidden" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="right-sidebar-content">
                <form action="">
                    <div class="upload-image">
                        <div class="image">
                            <img src="/assets/images/logo.svg" alt="">
                        </div>
                        <div class="custom-file-upload">
                            <em class="fa-solid fa-sliders"></em> uplaod
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
                        <label for="exampleFormControlInpu3" class="form-label">APG Employee ID</label>
                        <input type="text" class="form-control invalid" id="exampleFormControlInput3" />
                        <span class="invalid">Invalid username </span>
                        <span class="invalid hidden">Invalid username </span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-outline-primary" type="submit"><em class="fa-solid fa-sliders"></em>
                            Filter</button>
                        <button class="btn btn-primary" type="submit"><em class="fa-solid fa-sliders"></em> ADD
                            EMPLOYEE</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- right sidebar end --}}

        {{-- left siderbar start --}}
        <div class="flex space-x-2">
            <div>
                <div class="offcanvas offcanvas-start fixed bottom-0 flex flex-col max-w-full bg-white invisible bg-clip-padding shadow-sm outline-none transition duration-300 ease-in-out text-gray-700 top-0 left-0 border-none w-96" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header flex items-center justify-between p-4">
                        <h5 class="offcanvas-title mb-0 leading-normal font-semibold" id="offcanvasExampleLabel">
                            Offcanvas</h5>
                        <button type="button" class="btn-close box-content w-4 h-4 p-2 -my-5 -mr-2 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body flex-grow p-4 overflow-y-auto">
                        <div>
                            Some text as placeholder. In real life you can have the elements you have chosen. Like,
                            text, images, lists, etc.
                        </div>
                        <div class="dropdown relative mt-4">
                            <button class="dropdown-toggle inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg active:text-white transition duration-150 ease-in-out flex items-center whitespace-nowrap dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                Dropdown button
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down" class="w-2 ml-2" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path fill="currentColor" d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z">
                                    </path>
                                </svg>
                            </button>
                            <ul class="dropdown-menu min-w-max absolute hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100" href="#">Action</a></li>
                                <li><a class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100" href="#">Another action</a></li>
                                <li><a class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- left sidebar end --}}

        {{-- modal start --}}
        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                    <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                            Modal title
                        </h5>
                        <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body relative p-4">
                        <p>This is a vertically centered modal.</p>
                    </div>
                    <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                        <button type="button" class="inline-block px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal end --}}
    </div>
    {{-- side bar menu dropdown start --}}
    <ul>
        <li class="relative hidden" id="sidenavSecEx2">
            <a class="flex items-center cursor-pointer" data-mdb-ripple="true" data-mdb-ripple-color="primary" data-bs-toggle="collapse" data-bs-target="#collapseSidenavSecEx2" aria-expanded="false" aria-controls="collapseSidenavSecEx2">

                <span>Collapsible item 1</span>
                <svg aria-hidden="true" focusable="false" data-prefix="fas" class="w-3 h-3 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                    </path>
                </svg>
            </a>
            <ul class="relative accordion-collapse collapse" id="collapseSidenavSecEx2" aria-labelledby="sidenavSecEx2" data-bs-parent="#sidenavSecExample">
                <li class="relative">
                    <a href="#!" class="flex items-center text-xs py-4 pl-12 pr-6 h-6 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="primary">Link 1</a>
                </li>
                <li class="relative">
                    <a href="#!" class="flex items-center text-xs py-4 pl-12 pr-6 h-6 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="primary">Link 2</a>
                </li>
            </ul>
        </li>
    </ul>
    {{-- side bar menu dropdown end --}}

    {{-- right View sidebar start --}}
    <div class="right-sidebar offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="right-sidebar-header">
            <h5><a href="" data-bs-dismiss="offcanvas"><em class="fa-solid fa-arrow-left"></em></a>
                add employee
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
                        <h2>Clayton Wiatrek</h2>
                        <span>Manager</span>
                    </div>
                </div>
                <table class="admin-table mt-4" aria-label="">
                    <th>&nbsp;</th>
                    <tbody>
                        <tr class="border-b">
                            <td class="">APG Employee ID</td>
                            <td class="">
                                52145
                            </td>


                        </tr>
                        <tr class="border-b">
                            <td class="">Phone</td>
                            <td class="">
                                +1-234-567-890
                            </td>


                        </tr>
                        <tr class="border-b">
                            <td class="">Email</td>
                            <td class="">
                                clayton@apg.com
                            </td>


                        </tr>
                    </tbody>
                </table>

                {{-- table end --}}
                <button class="btn btn-primary mt-8" type="submit"><em class="fa-solid fa-sliders"></em> EDIT EMPLOYEE
                    PROFILE</button>
            </form>
        </div>
    </div>
    {{-- right sidebar end --}}
</x-app-layout>