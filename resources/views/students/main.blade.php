@extends('layouts.app')
<!-- Style -->
<Style>
    .uploadButton{
        background-color: #E76F51 !important; 
    }
    .uploadButton:hover{
        background-color: #F4A261 !important; 
    }
    .subjectButtons button:hover{
        background-color: #2A9D8F !important;
    }
</Style>
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col"></div>
            <div class="col-8">
                <h1 class="fw-bold mb-5">My Files</h1>
                <div class="d-flex p-1" style="background-color: #264653; height: 45px">
                    <div class="me-auto subjectButtons">
                        <button type="button" class="btn text-light text-wrap ">A2BS-something</button>
                        <button type="button" class="btn text-light text-wrap ">A3BS-something</button>
                    </div>
                    <div class="ms-auto">
                        <button type="button" class="btn uploadButton text-light">Upload</button>
                    </div>
                </div>
                <div class="container-fluid" style="background-color: #2A9D8F; height: 10px">
                </div>
                <div class="container mt-3" style="height: 450px; background-color:#264653">
                    
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection