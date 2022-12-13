@extends('layouts.supplier')
<style>
    .buyBtn {
        background-color: #E76F51 !important;
    }

    .buyBtn:hover {
        background-color: #F4A261 !important;
    }
</style>
@section('content')
@php
$currentFile = DB::table('files')->where('fileID', $fileID)->first();
@endphp
<div class="container">
    <h1>File Info</h1>
    <div class="row ">
        <div class="col-md-6">
            <img src="data:image/png;base64,{{ $currentFile->thumbnail }}" class="thumbnail border border-2" alt="File Picture" style="height: 500px; object-fit:cover;width:400px">
        </div>
        <div class="col-md-6">
            <h3>File Title: </h3>
            <h4>{{ $currentFile->fileName }}</h4>
            <h3 class="pt-4">No. Pages: {{ $currentFile->noPage }}</h3>
            @php
            $currentOrder = DB::table('order_details')->where('orderPrintingInfoID', $orderID)->first();
            $currentOrderInfo = DB::table('order_printing_infos')->where('orderPrintingInfoID', $currentOrder->orderPrintingInfoID)->first();
            $currentPayment = DB::table('payments')->where('orderID', $orderID)->first();
            @endphp
            <h3 class="pt-4">Binding Type: {{ $currentOrderInfo->bindingType }}</h3>
            @if ($currentOrderInfo->color == 'on')
            <h3 class="pt-4">Color: Yes</h3>
            @else
            <h3 class="pt-4">Color: No</h3>
            @endif
            <h3 class="pt-4">Page Format: {{ $currentOrderInfo->pageFormat }}</h3>
            <h3 class="pt-4">Number of Copies: {{ $currentOrderInfo->numCopies }}</h3>

            <a class="btn text-light" style="background-color: #264653" href="{{route('pdfDownload',[$currentFile->fileID])}}">
                {{ __('Download file') }}
            </a>
            <a class="btn text-light" style="background-color: #264653" href="{{route('orderStatus',[$orderID,'Delivered'])}}">
                {{ __('Complete Order') }}
            </a>
        </div>
    </div>
</div>
@endsection