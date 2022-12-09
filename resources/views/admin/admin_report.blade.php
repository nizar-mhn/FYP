@extends('layouts.admin')
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
            <form action="{{ route('adminReport') }}" method="get" enctype="multipart/form-data">
                <div class="row">
                    <label for="join" class="col-md-2 col-form-label text-md-end">{{ __('Start Date') }}</label>
                    <div class="col-md-3">
                        <input type="datetime-local" class="form-control" name="start">
                    </div>
                    <label for="join" class="col-md-2 col-form-label text-md-end">{{ __('End Date') }}</label>
                    <div class="col-md-3">
                        <input type="datetime-local" class="form-control" name="end">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </div>
            </form>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    @php
                    $date1 = date_create($start_date);
                    $date2 = date_create($end_date);
                    @endphp
                    @if($start_date&&$end_date)
                    <h6 class="m-0 font-weight-bold text-primary">Sales Report From <strong>{{date_format($date1,"Y-m-d")}}</strong> to <strong>{{date_format($date2,"Y-m-d")}}</strong> </h6>
                    @else
                    <h6 class="m-0 font-weight-bold text-primary">Sales Report From <strong>--</strong> to <strong>--</strong> </h6>
                    @endif
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
                                @php
                                $date3 = date_create($data->orderDate);
                                @endphp
                                <tr>
                                    <td>{{date_format($date3,"Y-m-d")}}</td>
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
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection