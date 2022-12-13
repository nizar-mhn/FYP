@extends('layouts.supplier')
<!-- Style -->
<Style>
    .uploadButton {
        background-color: #264653 !important;
    }

    .uploadButton:hover {
        background-color: #2A9D8F !important;
    }

    .subjectButtons button:hover {
        background-color: #F4A261 !important;
    }
</Style>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col"></div>
        <div class="col-8">
            <h1 class="fw-bold mb-5">Report</h1>
            @isset($error)
            @if($error!="")
            <div class="alert alert-danger ms-auto text-center" id="error" role="alert">
                {{ $error }}
            </div>
            @endif
            @endisset
            <form action="{{ route('supplierReport') }}" method="get" enctype="multipart/form-data">
                <div class="row">
                    <label for="join" class="col-md-2 col-form-label text-md-end">{{ __('Start Date') }}</label>
                    <div class="col-md-3">
                        <input type="date" class="form-control" name="start" required>
                    </div>
                    <label for="join" class="col-md-2 col-form-label text-md-end">{{ __('End Date') }}</label>
                    <div class="col-md-3">
                        <input type="date" class="form-control" name="end" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary" name="generate" value="1">Generate</button>
                    </div>
                </div>
            </form>
            @if(count($orders))
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sales Report From <strong>{{$start_date}}</strong> to <strong>{{$end_date}}</strong> </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>File Title</th>
                                    <th class="text-right">No. Copies</th>
                                    <th class="text-right">Pages</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            @if($orders)
                            <tbody>
                                @foreach ($orders as $data)
                                <tr>
                                    <td>{{$data->orderDate}}</td>
                                    <td>{{$data->fileName}}</td>
                                    <td class="text-right">{{$data->numCopies}}</td>
                                    <td class="text-right">{{$data->noPage}}</td>
                                    <td class="text-right">RM{{$data->totalPrice}}</td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th class="text-end">Total Orders: {{ count($orders) }}</th>
                                    <th></th>
                                    <th>Total: RM{{ $orders->sum('totalPrice') }}</th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            @else
            @isset($info)
            @if($info!="")
            <div class="alert alert-info ms-auto text-center" id="info" role="alert">
                @php
                echo $info;
                @endphp
            </div>
            @endif
            @endisset
            @endif
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection