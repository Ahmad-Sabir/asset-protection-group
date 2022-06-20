<x-app-layout>
    <section class="customer-login">
        <div class="banner">
            <div class="img-container">
                <img src="/assets/images/logo-white.png" alt="" />
            </div>
            <div class="slider">
                <div class="banner-slider">
                    <!--  -->
                    <div id="carouselDarkVariant" class="carousel slide carousel carousel-dark relative"
                        data-bs-ride="carousel">
                        <!-- Indicators -->
                        <div class="carousel-indicators absolute  bottom-0 left-0 flex justify-start ">
                            <button data-bs-target="#carouselDarkVariant" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>
                            <button data-bs-target="#carouselDarkVariant" data-bs-slide-to="1"
                                aria-label="Slide 1"></button>
                            <button data-bs-target="#carouselDarkVariant" data-bs-slide-to="2"
                                aria-label="Slide 1"></button>
                        </div>

                        <!-- Inner -->
                        <div class="carousel-inner relative w-full overflow-hidden">
                            <!-- Single item -->
                            <div class="carousel-item active relative float-left w-full">
                                <div class="carousel-caption ">
                                    <p>
                                        All aspects of our services are performed with a single goal in mind
                                    </p>
                                    <h2>To Extend The Life Of The Asset.</h2>
                                </div>
                            </div>

                            <!-- Single item -->
                            <div class="carousel-item relative float-left w-full">
                                <div class="carousel-caption ">
                                    <p>
                                        All aspects of our services are performed with a single goal in mind
                                    </p>
                                    <h2>To Extend The Life Of The Asset.</h2>
                                </div>
                            </div>

                            <!-- Single item -->
                            <div class="carousel-item relative float-left w-full">
                                <div class="carousel-caption">
                                    <p>
                                        All aspects of our services are performed with a single goal in mind
                                    </p>
                                    <h2>To Extend The Life Of The Asset.</h2>
                                </div>
                            </div>
                        </div>
                        <!-- Inner -->

                        <!-- Controls -->
                        <button
                            class="carousel-control-prev absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline left-0"
                            type="button" data-bs-target="#carouselDarkVariant" data-bs-slide="prev"></button>
                        <button
                            class="carousel-control-next absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline right-0"
                            type="button" data-bs-target="#carouselDarkVariant" data-bs-slide="next"></button>
                    </div>
                    <!--  -->
                </div>
                <div class="banner-bottom">
                    <div class="banner-icon-container">
                        <x-nav-link target="_blank" href="https://www.linkedin.com/company/aprotectiongroup"><em class="fa-brands fa-linkedin-in"></em></x-nav-link>
                    </div>
                    <div class="banner-bottom-text">
                        <p>Privacy Policy</p>
                        <p>Contact</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form">
            <div class="form-container scroll">
                <h3 class="customer-heading">Login</h3>
                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" class="form-control input-field" id="exampleFormControlInput3" />
                </div>
                <div class="form-group">
                    <label for="Password">Remember Me</label>
                    <input type="password" class="form-control input-field" id="exampleFormControlInput3" />
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                    <label class="form-check-label" for="flexCheckDefault">Default checkbox</label>
                </div>
                <button class="btn btn-secondary w-full">LOGIN</button>
                <button class="btn btn-primary w-full">REGISTER</button>
            </div>
        </div>
    </section>
</x-app-layout>
