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
                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif

                                <form method="GET" action="{{ route('passwordReset') }}">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="min 8 characters, 1 uppercase, 1 lowercase, 1 number">

                                            @if(isset($errorPassword))
                                            <div class="alert-danger alert">
                                                {{ $errorPassword }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="confirmPassword" required autocomplete="new-password">

                                            @if(isset($errorConfirmPass))
                                            <div class="alert-danger alert">
                                                {{ $errorConfirmPass }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <input type="hidden" name="user" value="{{$user}}">
                                            <input type="hidden" name="email" value="{{$email}}">
                                            <button type="submit" class="btn" style="background-color:#E76F51; color:white;">
                                                {{ __('Reset Password') }}
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