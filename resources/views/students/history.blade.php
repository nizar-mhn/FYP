@extends('layouts.app')
@php
use App\Models\payment;
@endphp
<style>
    .orderDetails:hover {
        background-color: #264653 !important;
    }

    .filterButtons button:hover {
        background-color: #2A9D8F !important;
    }

    .searchButton:hover {
        background-color: #F4A261 !important;
    }
</style>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col"></div>
        <div class="col-8 p-2">
            <h1 class="fw-bold mb-5">History</h1>
            @if (count($printingInfoID))
            <div class="row align-items-center " style="background-color: #264653; height: 45px">
                <div class="col-md-2 text-light text-center">
                    Image
                </div>
                <div class="col-md-3 text-light text-center">
                    Order Info
                </div>
                <div class="col-md-2 offset-md-3 text-light">
                    Price
                </div>
                <div class="col-md-2 text-light">
                    Status
                </div>
            </div>
            @foreach ($printingInfoID as $id)
            @php

            $orderInfo = DB::table('order_printing_infos')->where('orderPrintingInfoID',$id->orderPrintingInfoID)->first();
            $file = DB::table('files')->where('fileID',$orderInfo->fileID)->first();
            $payment = Payment::where('orderID',$id->orderID)->first();
            @endphp
            <div class="row mt-3 align-items-center orderDetails p-2" style="background-color: #2A9D8F; border-radius:22px">
                <div class="col-md-2">
                    <img src="data:image/png;base64,{{ $file->thumbnail }}" alt="" class="img-fluid p-1 thumbnail border border-2">
                </div>
                <div class="col-md-3 text-light">
                    <h5 class="fw-bold text-break">{{ $file->fileName }}</h5>
                    <p>Binding Type: {{ str_replace('_',' ',$orderInfo->bindingType) }}</p>
                    @if($orderInfo->color=="on")
                    <p>Color: Yes</p>
                    @else
                    <p>Color: No</p>
                    @endif
                    @if ($orderInfo->pageFormat == 'one-side')
                    <p>Page Format: One-Sided Page</p>
                    @else
                    <p>Page Format: Back-to-Back Page</p>
                    @endif
                    <p>Number of Copies: {{ $orderInfo->numCopies }}</p>
                </div>
                <div class="col-md-2 offset-md-3 text-light">
                    <h4>Price: </h4>
                    <h4>RM {{number_format((float)$payment->totalPrice, 2, '.', '')}}</h4>
                </div>
                <div class="col-md-2 text-light">
                    {{ $id->status }}
                </div>
            </div>
            @endforeach
            @else
            <div class="row">
                <div class="col"></div>
                <div class="col-10 text-center pt-5">
                    <h1><i class="bi bi-clock-history fa-lg"></i></h1>
                    <h1>You have not ordered anything</h1>
                </div>
                <div class="col"></div>
            </div>
            @endif
        </div>
        <div class="col"></div>
    </div>
@endsection
