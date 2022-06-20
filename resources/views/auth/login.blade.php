<x-guest-layout>
    <x-auth-card>
        <section class="customer-login">
            <div class="banner">
                <div class="img-container">
                    <x-nav-link href="{{ url('/') }}"><img src="/assets/images/logo-white.png" alt="" /></x-nav-link>
                </div>
                <div class="slider">
                    <div class="banner-slider">
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
                    </div>
                    <div class="banner-bottom">
                        <div class="banner-icon-container">
                            <x-nav-link target="_blank" href="https://www.linkedin.com/company/aprotectiongroup"><em class="fa-brands fa-linkedin-in"></em></x-nav-link>
                        </div>
                        <div class="banner-bottom-text">
                            <x-nav-link  href="">
                                {{ __('Privacy Policy') }}
                            </x-nav-link>
                            <x-nav-link  href="">
                                {{ __('Contact') }}
                            </x-nav-link>
                        </div>
                    </div>
                </div>
            </div>

            <form class="form" method="POST" action="{{ route('login') }}">
                <div class="form-container scroll">
                    <h3 class="customer-heading">Login</h3>
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="form-control" type="email" name="email" :value="old('email')"
                            required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="form-group password-field" x-data="{ show: true }">
                        <x-label for="password" :value="__('Password')" />
                        <x-input id="password" class="form-control" ::type="show ? 'password' : 'text'" name="password" required
                            autocomplete="current-password" />
                            <em :class="show ? 'fa fa-eye  pawword-toggle' : 'fa fa-eye-slash'" class="pawword-toggle"
                            @click="show = !show"> </em>
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <span class="form-control">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="login-btn-wrap">
                        <!-- Session Status -->
                        <x-auth-session-status :status="session('status')" />

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                        <x-button class="btn-secondary w-full justify-center">
                            {{ __('Log in') }}
                        </x-button>
                        @if (Route::has('password.request'))
                            <x-nav-link class="forget-password" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </x-nav-link>
                        @endif
                    </div>
                </div>
            </form>
        </section>

    </x-auth-card>
</x-guest-layout>
