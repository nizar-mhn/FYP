@extends('layouts.app')
    <style>
        #user_profile{
            border-radius: 50% !important;
            width: 180px;
            height: 180px;
        }
    </style>
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col"></div>
            <div class="col-6">
                <img class="img-fluid mx-auto d-block mb-3" id="user_profile" src="image/img_avatar.png" alt="User Image">
                <div class="container-fluid" style="background-color: #264653; height:400px"> 

                </div>
                <div class="container-fluid" style="background-color: #2A9D8F; height:10px"> 
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection