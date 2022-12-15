<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="icon" href="{{asset('image/logoPrintingTransparent.png')}}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        .image {
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            left: 0;
            right: 0;
            text-align: center;
            top: 10px;
            height: 200px;
            width: 600px;
        }

        .main {
            margin-top: 150px;
        }
    </style>
</head>

<body>
    <div id="app">

        <div>
            <div class="container-fluid" style="background-color:#264653; height:90px;">
            </div>
            <div class="container-fluid" style="background-color:#2A9D8F; height:25px;">
            </div>

            <img src="{{asset('image/printingLogo.png')}}" alt="Logo" class="img-fluid image">
        </div>


        <main class="py-4 main">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header text-center fs-4">{{ __('Login') }}</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('logged') }}">
                                    @csrf

                                    <div class="row mb-3">
                                        @if(session('danger'))
                                        <span class="alert alert-danger text-center">
                                            <strong>{{ session('danger') }}</strong>
                                        </span>
                                        @endif
                                        @if(session('info'))
                                        <span class="alert alert-info text-center">
                                            <strong>{{ session('info') }}</strong>
                                        </span>
                                        @endif
                                        <label for="id" class="col-md-4 col-form-label text-md-end">{{ __('Login ID') }}</label>

                                        <div class="col-md-6">
                                            <input id="id" type="text" class="form-control" name="id" value="{{ old('id') }}" required autocomplete="id" autofocus style="background-color:#2A9D8F; color:white;">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" style="background-color:#2A9D8F; color:white;">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="background-color:#2A9D8F; color:white;">

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 offset-md-4">
                                            </span><a href="{{route('forgotPassword')}}">Forgot your password?</a><span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 offset-md-4">
                                            <span>New here? Let's </span><a href="{{route('register')}}">Register</a><span> Now</span>
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="offset-md-9">
                                            <button type="submit" class="btn" style="background-color:#E76F51; color:white;">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>