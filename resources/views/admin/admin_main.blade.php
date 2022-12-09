@extends("layouts.admin")
<style>
    .orderDetails:hover {
        background-color: #E76F51 !important;
    }

    .filterButtons button:hover {
        background-color: #F4A261 !important;
    }

    .searchButton:hover {
        background-color: #2A9D8F !important;
    }
</style>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col"></div>
        <div class="col-8">
            <h1 class="fw-bold mb-5">Orders</h1>
            <div class="container">
                @if(count($order))
                <table class="table table-bordered mb-5 text-center">
                    <thead style="background-color: #E76F51">
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Student ID</th>
                            <th scope="col">Student name</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #F4A261">
                        @foreach($order as $data)
                        @php
                        $currentStudent = DB::table('students')->where('studentID', $data->studentID)->first();
                        @endphp
                        <tr>
                            <th scope="row">{{$data->orderID}}</th>
                            <td>{{ $data->studentID }}</td>
                            <td>{{ $currentStudent->studentName }}</td>
                            <td>{{ $data->orderDate }}</td>
                            <td>

                                <button id="barDropdown" class="dropdown-toggle btn text-light" style="background-color: #264653" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ $data->status }}
                                </button>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="barDropdown">
                                    @if($data->status=="Pending")
                                    <a class="dropdown-item disabled" href="{{route('orderStatus',[$data->orderID,'Pending'])}}">
                                        {{ __('Pending') }}
                                    </a>
                                    @else
                                    <a class="dropdown-item" href="{{route('orderStatus',[$data->orderID,'Pending'])}}">
                                        {{ __('Pending') }}
                                    </a>
                                    @endif
                                    @if($data->status=="Printed")
                                    <a class="dropdown-item disabled" href="{{route('orderStatus',[$data->orderID,'Printed'])}}">
                                        {{ __('Printed') }}
                                    </a>
                                    @else
                                    <a class="dropdown-item" href="{{route('orderStatus',[$data->orderID,'Printed'])}}">
                                        {{ __('Printed') }}
                                    </a>
                                    @endif
                                </div>

                            </td>
                            @php
                            $currentOrder = DB::table('order_details')->where('orderPrintingInfoID', $data->orderID)->first();
                            $currentOrderInfo = DB::table('order_printing_infos')->where('orderPrintingInfoID', $currentOrder->orderPrintingInfoID)->first();
                            $currentfile = DB::table('files')->where('fileID', $currentOrderInfo->fileID)->first();
                            @endphp
                            <td>
                                <a class="btn text-light" style="background-color: #264653" href="/{{ $currentfile->fileID }}/{{$data->orderID}}">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {!! $order->links() !!}
                </div>
                @else
                <div class="text-center">

                    <img src="{{asset('image/noOrder.png')}}" alt="No Order Found" class="img-fluid image">
                    <h3>Currently there's no order made...</h3>
                </div>
                @endif
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection