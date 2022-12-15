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
                            <div class="card-header text-center fs-4">{{ __('Reset Password') }}</div>

                            <div class="card-body">

                                <form method="GET" action="{{ route('resetPassword') }}">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                        <div class="col-md-6">
                                            @if(isset($email))
                                            <input id="email" type="email" class="form-control" name="email" value="{{ $email }}" required autocomplete="email" placeholder="eg. alex@gmail.com">
                                            @else
                                            <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" placeholder="eg. alex@gmail.com">
                                            @endif
                                            @if(isset($errorEmail))
                                            <div class="alert-danger alert">
                                                {{ $errorEmail }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn" style="background-color:#E76F51; color:white;">
                                                {{ __('Send Password Reset Link') }}
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