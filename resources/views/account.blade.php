<x-app-layout>
    <!-- Content -->
    <div class="main-wrap">
        <div class="main-fixed-wrap">
            <div class="heading">
                <h1>manage account</h1>
            </div>
        </div>
        <div class="main-content">
            <div class="main-wrapper">
                <div class="admin-tabs">
                    <ul class="nav nav-tabs" id="tabs-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-home" class="nav-link active" id="tabs-home-tab" data-bs-toggle="pill" data-bs-target="#tabs-home" role="tab" aria-controls="tabs-home" aria-selected="true">Home</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-profile" class="nav-link" id="tabs-profile-tab" data-bs-toggle="pill" data-bs-target="#tabs-profile" role="tab" aria-controls="tabs-profile" aria-selected="false">Profile</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-messages" class="nav-link" id="tabs-messages-tab" data-bs-toggle="pill" data-bs-target="#tabs-messages" role="tab" aria-controls="tabs-messages" aria-selected="false">Messages</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-contact" class="nav-link" id="tabs-contact-tab" data-bs-toggle="pill" data-bs-target="#tabs-contact" role="tab" aria-controls="tabs-contact" aria-selected="false">Contact</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabs-tabContent">
                        <div class="tab-pane fade show active" id="tabs-home" role="tabpanel" aria-labelledby="tabs-home-tab">
                        <form action="">
                    <div class="upload-image">
                        <div class="image">
                            <img src="/assets/images/user-img.png" alt="">
                        </div>
                        <div class="custom-file-upload">
                            <em class="fa-solid fa-sliders"></em> upload
                            <input class="form-control" type="file" id="formFile">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInpu3" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInpu3" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInpu3" class="form-label">Email Address</label>
                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Email Address">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInpu3" class="form-label">Password</label>
                        <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Password">
                    </div>

                    <div class="form-group">
                    <button class="btn btn-primary" type="submit"><em class="fa-solid fa-sliders"></em> Update Information</button>
                </div>
                </form>
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
            </div>

        </div>
    </div>
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
                    <button type="button" class="inline px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="inline px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="exampleModalCenteredScrollable" tabindex="-1" aria-labelledby="exampleModalCenteredScrollable" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable relative w-auto pointer-events-none">
            <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalCenteredScrollableLabel">
                        Modal title
                    </h5>
                    <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body relative p-4">
                    <p>This is some placeholder content to show a vertically centered modal. We've added some extra
                        copy
                        here to show how vertically centering the modal works when combined with scrollable modals.
                        We
                        also use some repeated line breaks to quickly extend the height of the content, thereby
                        triggering the scrolling. When content becomes longer than the predefined max-height of
                        modal,
                        content will be cropped and scrollable within the modal.</p>
                    <br><br><br><br><br><br><br><br><br><br>
                    <p>Just like that.</p>
                </div>
                <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <button type="button" class="inline px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="inline px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- modal end --}}


    {{-- right sidebar start --}}


    <div class="offcanvas offcanvas-end fixed bottom-0 flex flex-col max-w-full bg-white invisible bg-clip-padding shadow-sm outline-none transition duration-300 ease-in-out text-gray-700 top-0 right-0 border-none w-96" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header flex items-center justify-between p-4">
            <h5 class="offcanvas-title mb-0 leading-normal font-semibold" id="offcanvasRightLabel">Offcanvas right
            </h5>
            <button type="button" class="btn-close box-content w-4 h-4 p-2 -my-5 -mr-2 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow p-4 overflow-y-auto">
            ...
        </div>
    </div>
    {{-- right sidebar end --}}
    </div>

</x-app-layout>
