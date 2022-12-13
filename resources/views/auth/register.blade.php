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
                            @if(!isset($user))
                            <div class="card-header text-center fs-4">{{ __('Register') }}</div>

                            <div class="card-body">
                                <form class="text-center" method="GET" action="{{route('selectUser')}}">
                                    <h4 class="mb-3">Register as:</h4>
                                    <div class="form-check form-check-inline mb-3">
                                        <input class="form-check-input" type="radio" name="user" id="user1" value="Student" checked>
                                        <label class="form-check-label" for="user1">
                                            Student
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline mb-3">
                                        <input class="form-check-input" type="radio" name="user" id="user2" value="Lecturer">
                                        <label class="form-check-label" for="user2">
                                            Lecturer
                                        </label>
                                    </div>

                                    <div class="row mb-0">
                                        <div>
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Next') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @else
                            <div class="card-header text-center fs-4">{{ __('Register as ') }}{{$user}}</div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>