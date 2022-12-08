@extends("layouts.staff")
<style>
    .orderDetails:hover{
        background-color: #E76F51 !important;
    }

    .filterButtons button:hover{
        background-color: #F4A261 !important;
    }

    .searchButton:hover{
        background-color: #2A9D8F !important;
    }
</style>
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col"></div>
            <div class="col-8">
                <h1 class="mb-5 fw-bold">Orders</h1>
                <div class="d-flex p-1 mb-4" style="background-color: #E76F51; height: 45px">
                    <div class="me-auto filterButtons">
                        <button type="button" class="btn text-light text-wrap ">Date <i class="bi bi-sort-up"></i></button>
                        <button type="button" class="btn text-light text-wrap ">Price <i class="bi bi-sort-up"></i></button>
                    </div>
                    <div class="ms-auto">
                        <button type="button" class="btn searchButton text-light" style="background-color: #264653"><i class="bi bi-search" style=""></i>  Search</button>
                    </div>
                </div>
                <div class="btn container-fluid mt-3 orderDetails" style="background-color: #F4A261; height: 70px; border-radius:22px"
                data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <div class="row">
                        <div class="col-2">test</div>
                        <div class="col-8">test2</div>
                        <div class="col-2">test3</div>
                    </div>
                </div>
                <div class="collapse" id="collapseExample" style="padding:0px 10px 0px 10px">
                    <div class="card card-body" style="background-color:#E76F51">Test</div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection   