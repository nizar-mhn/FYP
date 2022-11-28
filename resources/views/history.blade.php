@extends('layouts.app')
<style>
    .orderDetails:hover{
        background-color: #264653 !important;
    }

    .filterButtons button:hover{
        background-color: #2A9D8F !important;
    }

    .searchButton:hover{
        background-color: #F4A261 !important;
    }
</style>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col"></div>
        <div class="col-8 p-2">
            <h1 class="fw-bold mb-5">History</h1>
            <div class="d-flex p-1 mb-4" style="background-color: #264653; height: 45px">
                <div class="me-auto filterButtons">
                    <button type="button" class="btn text-light text-wrap ">Date <i class="bi bi-sort-up"></i></button>
                    <button type="button" class="btn text-light text-wrap ">Price <i class="bi bi-sort-up"></i></button>
                </div>
                <div class="ms-auto">
                    <button type="button" class="btn searchButton text-light" style="background-color: #E76F51"><i class="bi bi-search" style=""></i>  Search</button>
                    
                </div>
            </div>
    
            <div class="container-fluid mt-3 orderDetails" style="background-color: #2A9D8F; height: 70px; border-radius:22px"></div>
            <div class="container-fluid mt-3 orderDetails" style="background-color: #2A9D8F; height: 70px; border-radius:22px"></div>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection