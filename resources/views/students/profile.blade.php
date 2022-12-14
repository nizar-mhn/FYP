@extends('layouts.app')
<style>
    #user_profile {
        border-radius: 50% !important;
        width: 180px;
        height: 180px;
    }
</style>
@section('content')
@php
$userProgramDetails = DB::table('program_details')->where('programDetailsID', Auth::user()->programDetailsID)->first();
$currentProgram = DB::table('programs')->where('programID', $userProgramDetails->programID)->first();
@endphp
<div class="container-fluid">

    <div class="row">
        <div class="col"></div>
        <div class="col-6">
            <img class="img-fluid mx-auto d-block mb-3" id="user_profile" src="../image/img_avatar.png" alt="User Image">
            <div class="text-center">
                <h4>{{ Auth::user()->studentName }}</h4>
            </div>
            <div class="container-fluid text-white text-center" style="background-color: #264653; height:360px">
                <div class="row p-2 pt-4">
                    <div class="col-md-6">
                        Student ID
                    </div>
                    <div class="col-md-6">
                        {{ Auth::user()->studentID }}
                    </div>
                </div>
                <hr>
                <div class="row p-2">
                    <div class="col-md-6">
                        Programme
                    </div>
                    <div class="col-md-6">
                        {{ $currentProgram->programName }}
                    </div>
                </div>
                <hr>
                <div class="row p-2">
                    <div class="col-md-6">
                        Year
                    </div>
                    <div class="col-md-6">
                        {{ $userProgramDetails->year }}
                    </div>
                </div>
                <hr>
                <div class="row p-2">
                    <div class="col-md-6">
                        Semester
                    </div>
                    <div class="col-md-6">
                        {{ $userProgramDetails->semester }}
                    </div>
                </div>
                <hr>
                <div class="row p-2">
                    <div class="col-md-6">
                        Email
                    </div>
                    <div class="col-md-6">
                        {{ Auth::user()->email }}
                    </div>
                </div>
            </div>
            <div class="container-fluid" style="background-color: #2A9D8F; height:10px">
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection