<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- Meta data -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VOLTECH') }}</title>

    <!--Favicon -->
    <link rel="icon"
        href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/brand/favicon.ico"
        type="image/x-icon" />

    <!--Bootstrap css -->
    <link
        href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/bootstrap/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Style css -->
    <link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/css/style.css" rel="stylesheet" />
    <link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/css/dark.css" rel="stylesheet" />
    <link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/css/skin-modes.css"
        rel="stylesheet" />

    <!-- Animate css -->
    <link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/css/animated.css"
        rel="stylesheet" />

    <!---Icons css-->
    <link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/css/icons.css" rel="stylesheet" />


    <!-- Color Skin css -->
    <link id="theme" href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/colors/color1.css"
        rel="stylesheet" type="text/css" />

            <!-- bala insert -->
    <!--Favicon -->
    <link rel="icon" href="{{ asset('images/brand/favicon.ico') }}" type="image/x-icon" />
    <!--Bootstrap css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/dark.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/skin-modes.css') }}" rel="stylesheet" />

    <!-- Animate css -->
    <link href="{{ asset('css/animated.css') }}" rel="stylesheet" />

    <!---Icons css-->
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet" />

    <!-- Color Skin css -->
    <link id="theme" href="{{ asset('colors/color1.css') }}" rel="stylesheet" type="text/css" />

    <!-- bala insert end -->

</head>

<body class="h-100vh bg-primary">
    @if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
    @endif
    <div class="box">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="page">
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="">
                            <div class="text-white">
                                <div class="card-body">
                                    <h2 class="display-4 mb-2 font-weight-bold error-text text-center">
                                        <strong>Login</strong></h2>
                                    <h4 class="text-white-80 mb-7 text-center">Sign In to your account</h4>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-9 d-block mx-auto">
                                                <div class="input-group mb-6">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-user"></i>
                                                        </div>
                                                    </div>
                                                    <input class="form-control" placeholder="Username" type="email"
                                                        name="email" :value="old('email')" required autofocus="OFF">

                                                </div>
                                                <div class="input-group mb-6">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-eye toggle-password"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" id="password" class="form-control"
                                                        placeholder="Password" name="password" required
                                                        autocomplete="current-password">

                                                </div>
                                                <!-- <div class="input-group mb-4">
													<div class="input-group-prepend">
														<div class="input-group-text">
															<i class="fe fe-user"></i>
														</div>
													</div>
													<input type="text" class="form-control" placeholder="Username">
												</div> -->
                                                <!-- <div class="input-group mb-4">
													<div class="input-group-prepend">
														<div class="input-group-text">
															<i class="fe fe-lock"></i>
														</div>
													</div>
													<input type="password" class="form-control" placeholder="Password">
												</div> -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <!-- <button type="button"
                                                            class="btn  btn-secondary btn-block px-4">Login</button> -->
                                                            <button type="submit"
                                                        class="btn  btn-secondary btn-block px-6">{{ __('Login') }}</button>
                                                    </div>
                                                    <!-- <div class="col-12 text-center">
														<a href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/forgot-password-2" class="btn btn-link box-shadow-0 px-0 text-white-80">Forgot password?</a>
													</div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- <div class="text-center pt-4">
											<div class="font-weight-normal fs-16">You Don't have an account <a class="btn-link font-weight-normal text-white-80" href="#">Register Here</a></div>
										</div> -->
                                </div>
                                <!-- <div class="custom-btns text-center">
										<button class="btn btn-icon" type="button"><span class="btn-inner-icon"><i class="fa fa-facebook-f"></i></span></button>
										<button class="btn btn-icon" type="button"><span class="btn-inner-icon"><i class="fa fa-google"></i></span></button>
										<button class="btn btn-icon" type="button"><span class="btn-inner-icon"><i class="fa fa-twitter"></i></span></button>
										<button class="btn btn-icon" type="button"><span class="btn-inner-icon"><i class="fa fa-pinterest-p"></i></span></button>
									</div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-none d-md-flex align-items-center">
                        <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/png/login.png"
                            alt="img">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery js-->
    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/js/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap4 js-->
    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/bootstrap/popper.min.js">
    </script>
    <script
        src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/bootstrap/js/bootstrap.min.js">
    </script>

    <!--Othercharts js-->
    <script
        src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/othercharts/jquery.sparkline.min.js">
    </script>

    <!-- Circle-progress js-->
    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/js/circle-progress.min.js">
    </script>

    <!-- Jquery-rating js-->
    <script
        src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/rating/jquery.rating-stars.js">
    </script>
    <!-- Custom js-->
    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/js/custom.js"></script>
    <!-- Jquery js-->
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>

    <!-- Bootstrap4 js-->
    <script src="{{ asset('plugins/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!--Othercharts js-->
    <script src="{{ asset('plugins/othercharts/jquery.sparkline.min.js') }}"></script>

    <!-- Circle-progress js-->
    <script src="{{ asset('js/circle-progress.min.js') }}"></script>

    <!-- Jquery-rating js-->
    <script src="{{ asset('plugins/rating/jquery.rating-stars.js') }}"></script>

    <!-- Custom js-->
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
<script>
$(document).on('click', '.toggle-password', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#password");
    input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
});
</script>

</html>