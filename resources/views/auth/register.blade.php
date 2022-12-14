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
                                        <input class="form-check-input" type="radio" name="user" id="user2" value="Staff">
                                        <label class="form-check-label" for="user2">
                                            Staff
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
                            @if($user=='Student')
                            @if(!isset($prog))
                            <div class="card-body">
                                <form class="text-center" method="GET" action="{{route('selectProgram')}}">
                                    <div class="row mb-3">
                                        <label for="prog" class="col-md-4 col-form-label text-md-end">{{ __('Program Name') }}</label>

                                        <div class="col-md-6">
                                            <select name="prog" id="prog" class="form-select" required>
                                                @foreach ($programs as $data)
                                                <option value="{{$data->programID}}">{{$data->programName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div>
                                            <input type="hidden" name="user" value="{{$user}}">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Next') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @else
                            <div class="card-body">
                                <form method="GET" action="{{ route('validation') }}">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="studentID" class="col-md-4 col-form-label text-md-end">{{ __('Student ID') }}</label>

                                        <div class="col-md-6">
                                            @if(isset($userID))
                                            <input id="studentID" type="text" class="form-control" name="studentID" value="{{ $userID }}" required autocomplete="studentID" autofocus placeholder="eg. 2105086">
                                            @else
                                            <input id="studentID" type="text" class="form-control" name="studentID" value="" required autocomplete="studentID" autofocus placeholder="eg. 2105086">
                                            @endif
                                            @if(isset($errorID))
                                            <div class="alert-danger alert">
                                                {{ $errorID }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            @if(isset($name))
                                            <input id="name" type="text" class="form-control" name="name" value="{{ $name }}" required autocomplete="name" autofocus placeholder="eg. Alex Chong">
                                            @else
                                            <input id="name" type="text" class="form-control" name="name" value="" required autocomplete="name" autofocus placeholder="eg. Alex Chong">
                                            @endif
                                            @if(isset($errorName))
                                            <div class="alert-danger alert">
                                                {{ $errorName }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                        <div class="col-md-6">
                                            @if(isset($name))
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
                                    <div class="row mb-3">
                                        <label for="year" class="col-md-4 col-form-label text-md-end">{{ __('Year') }}</label>


                                        <div class="col-md-6">
                                            <select name="year" id="year" class="form-select" required>
                                                @if(isset($year))
                                                @foreach ($programDetails as $data)
                                                @if($year == $data->year)
                                                <option value="{{$data->year}}" selected>{{$data->year}}</option>
                                                @else
                                                <option value="{{$data->year}}">{{$data->year}}</option>
                                                @endif
                                                @endforeach
                                                @else
                                                @foreach ($programDetails as $data)
                                                <option value="{{$data->year}}">{{$data->year}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="sem" class="col-md-4 col-form-label text-md-end">{{ __('Semester') }}</label>

                                        <div class="col-md-6">
                                            <select name="sem" id="sem" class="form-select" required>
                                                @if(isset($sem))
                                                @foreach ($programDetailsSem as $data)
                                                @if($sem == $data->semester)
                                                <option value="{{$data->semester}}" selected>{{$data->semester}}</option>
                                                @else
                                                <option value="{{$data->semester}}">{{$data->semester}}</option>
                                                @endif
                                                @endforeach
                                                @else
                                                @foreach ($programDetailsSem as $data)
                                                <option value="{{$data->semester}}">{{$data->semester}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

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
                                            <input type="hidden" name="prog" value="{{$prog}}">
                                            <input type="hidden" name="user" value="{{$user}}">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif

                            @elseif($user=='Staff')
                            <div class="card-body">
                                <form method="GET" action="{{ route('validation') }}">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="staffID" class="col-md-4 col-form-label text-md-end">{{ __('Staff ID') }}</label>

                                        <div class="col-md-6">
                                            @if(isset($userID))
                                            <input id="staffID" type="text" class="form-control" name="staffID" value="{{ $userID }}" required autocomplete="studentID" autofocus placeholder="eg. p1234">
                                            @else
                                            <input id="staffID" type="text" class="form-control" name="staffID" value="" required autocomplete="studentID" autofocus placeholder="eg. p1234">
                                            @endif
                                            @if(isset($errorID))
                                            <div class="alert-danger alert">
                                                {{ $errorID }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            @if(isset($name))
                                            <input id="name" type="text" class="form-control" name="name" value="{{ $name }}" required autocomplete="name" autofocus placeholder="eg. Alex Chong">
                                            @else
                                            <input id="name" type="text" class="form-control" name="name" value="" required autocomplete="name" autofocus placeholder="eg. Alex Chong">
                                            @endif
                                            @if(isset($errorName))
                                            <div class="alert-danger alert">
                                                {{ $errorName }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                        <div class="col-md-6">
                                            @if(isset($name))
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

                                    <div class="row mb-3">
                                        <label for="course" class="col-md-4 col-form-label text-md-end">{{ __('Courses') }}</label>

                                        <div class="col-md-6">
                                            <select name="course[]" id="course" class="form-select" required multiple>
                                                <option disabled>You may select multiple Courses by CTRL+Click</option>
                                                @if(isset($course))

                                                @foreach ($courses as $data)
                                                @if(in_array($data->courseID,$course))
                                                <option value="{{$data->courseID}}" selected>{{$data->courseCode}} - {{$data->courseName}}</option>
                                                @else
                                                <option value="{{$data->courseID}}">{{$data->courseCode}} - {{$data->courseName}}</option>
                                                @endif
                                                @endforeach
                                                
                                                @else
                                                @foreach ($courses as $data)
                                                <option value="{{$data->courseID}}">{{$data->courseCode}} - {{$data->courseName}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

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
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @else
                            @endif

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>