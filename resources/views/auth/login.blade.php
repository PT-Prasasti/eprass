<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>

    
    <meta name="description" content="{{ config('app.name', 'Laravel') }}">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <meta property="og:title" content="E-PRASS">
    <meta property="og:site_name" content="Codebase">
    <meta property="og:description" content="{{ config('app.name', 'Laravel') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" href="{{ asset(config('app.logo', 'assets/logo1.png')) }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset(config('app.logo', 'assets/logo1.png')) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset(config('app.logo', 'assets/logo1.png')) }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.min.css') }}">

</head>
<body>
    
    <div id="page-container" class="main-content-boxed">
        <main id="main-container">
            <div class="bg-image" style="background-image: url('assets/media/photos/photo34@2x.jpg');">
                <div class="row mx-0 bg-black-op">
                    <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                        <div class="p-30 invisible" data-toggle="appear">
                            <p class="font-size-h3 font-w600 text-white">
                                PT. PRAMBANAN SARANA SEJATI
                            </p>
                            <p class="font-italic text-white-op">
                                E-PRASS &copy; <span class="js-year-copy"></span>
                            </p>
                        </div>
                    </div>
                    <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white invisible" data-toggle="appear" data-class="animated fadeInRight">
                        <div class="content content-full">
                            <div class="px-30 py-10">
                                <a class="link-effect font-w700" href="index.html">
                                    <img src="assets/logo.png" width="40%">
                                </a>
                                <h1 class="h3 font-w700 mt-30 mb-10">Welcome to Your Dashboard</h1>
                                <h2 class="h5 font-w400 text-muted mb-0">Please sign in</h2>
                            </div>
                            <form class="js-validation-signin px-30" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="text" class="form-control" id="login-username" name="username">
                                            <label for="login-username">Username</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="password" class="form-control" id="login-password" name="password">
                                            <label for="login-password">Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="login-remember-me" name="login-remember-me">
                                            <label class="custom-control-label" for="login-remember-me">Remember Me</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-hero btn-alt-primary">
                                        <i class="si si-login mr-10"></i> Sign In
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="{{ asset('assets/js/codebase.core.min.js') }}"></script>
    <script src="{{ asset('assets/js/codebase.app.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/op_auth_signin.min.js') }}"></script>
</body>
</html>
