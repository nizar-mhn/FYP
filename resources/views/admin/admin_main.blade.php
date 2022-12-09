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
@if ($order)
<div class="container-fluid">
    <div class="row">
        <div class="col"></div>
        <div class="col-8">
            <h1 class="fw-bold mb-5">Orders</h1>
            <div class="container">
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
                            <th scope="row"><a href="/admins/{{ $data->orderID }}">{{ $data->orderID }}</a></th>
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
                            <td>
                                <a class="btn text-light" style="background-color: #264653" href="{{route('orderStatus',[$data->orderID,'Delivered'])}}">
                                    {{ __('Delivered') }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {!! $order->links() !!}
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
@else
empty
@endif
@endsection