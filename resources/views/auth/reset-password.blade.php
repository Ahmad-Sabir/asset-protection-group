<x-guest-layout>
    <x-auth-card>
        <section class="customer-login">
            <div class="banner">
                <div class="img-container">
                    <x-nav-link href="{{ url('/') }}"><img src="/assets/images/logo-white.png" alt="" />
                    </x-nav-link>
                </div>
                <div class="slider">
                    <div class="banner-slider">
                        <!--  -->
                        <div id="carouselDarkVariant" class="carousel slide carousel carousel-dark relative"
                            data-bs-ride="carousel">
                            <!-- Indicators -->
                            <div class="carousel-indicators absolute  bottom-0 left-0 flex justify-start ">
                                <x-button data-bs-target="#carouselDarkVariant" data-bs-slide-to="0"
                                    class="active" aria-current="true" aria-label="Slide 1"></x-button>
                                <x-button data-bs-target="#carouselDarkVariant" data-bs-slide-to="1"
                                    aria-label="Slide 1"></x-button>
                                <x-button data-bs-target="#carouselDarkVariant" data-bs-slide-to="2"
                                    aria-label="Slide 1"></x-button>
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
                        </div>
                        <!--  -->
                    </div>
                    <div class="banner-bottom">
                        <div class="banner-icon-container">
                            <x-nav-link target="_blank" href="https://www.linkedin.com/company/aprotectiongroup"><em class="fa-brands fa-linkedin-in"></em></x-nav-link>
                        </div>
                        <div class="banner-bottom-text">
                            <x-nav-link href="">
                                {{ __('Privacy Policy') }}
                            </x-nav-link>
                            <x-nav-link href="">
                                {{ __('Contact') }}
                            </x-nav-link>
                        </div>
                    </div>
                </div>
            </div>

            <form class="form" method="POST" action="{{ route('password.update') }}">
                <div class="form-container scroll">
                    <h3 class="customer-heading">Reset Password</h3>
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="form-group">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" class="form-control input-field" type="email" name="email"
                            :value="old('email', $request->email)" required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="form-group password-field" x-data="{ show: true }">
                        <x-label for="password" :value="__('New Password')" />
                        <x-input id="password" class="form-control" ::type="show ? 'password' : 'text'" name="password" required
                        autocomplete="current-password" />
                        <em :class="show ? 'fa fa-eye  pawword-toggle' : 'fa fa-eye-slash'" class="pawword-toggle"
                        @click="show = !show"> </em>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group password-field" x-data="{ show: true }">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-input id="password_confirmation" class="form-control" ::type="show ? 'password' : 'text'" name="password_confirmation" required
                        autocomplete="current-password" />
                        <em :class="show ? 'fa fa-eye  pawword-toggle' : 'fa fa-eye-slash'" class="pawword-toggle"
                        @click="show = !show"> </em>
                    </div>

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <x-button class="btn-secondary w-full justify-center">
                        {{ __('Reset Password') }}
                    </x-button>

                    <div class="back-login">
                        <x-nav-link href="{{ route('login') }}"><em class="fa-regular fa-arrow-left-long"></em> Back to Login</x-nav-link>
                    </div>

                </div>
            </form>

        </section>
    </x-auth-card>
</x-guest-layout>
