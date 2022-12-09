@extends('layouts.app')
@php

if ($checkColor == 'on') {
    $colorPrice = 0.20;
}else {
    $colorPrice = 0.10;
}

$pagePrice = $file->noPage * $colorPrice;

if ($bindingType == 'No_binding') {
    $bindingPrice = 0.00;
}else {
    $bindingPrice = 1.00;
}

$totalPricePerCopy = $pagePrice + $bindingPrice;
$totalPayPrice =  $totalPricePerCopy * $amount;


@endphp
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h1 class="pt-4">Payment</h1>
            <div class="d-flex">
                <img src="data:image/png;base64,{{ $file->thumbnail }}" class="thumbnail border border-2" alt="File Picture" style="height: 100px; width:100px">
                <h4 class="ms-auto">{{ $file->fileName }}</h4>
            </div>
            <hr class="pb-2"/>
            <div class="d-flex pb-2">
                <h4>Pages: {{ $file->noPage }}</h4>
                <h4 class="ms-auto">RM {{ number_format((float)$pagePrice, 2, '.', '') }}</h4>
            </div>
            <div class="d-flex pb-2">
                <h4>Color Pages: </h4>
                <h4 class="ms-auto">
                    @if ($checkColor == 'on')
                    Yes
                    @else
                    No
                    @endif
                </h4>
            </div>
            <div class="d-flex pb-2">
                <h4>Page format: </h4>
                <h4 class="ms-auto">
                    @if ($pageFormat == 'back-back')
                        Back-to-Back Page
                    @else
                        One-Sided Page
                    @endif
                </h4>
            </div>
            <div class="d-flex pb-2">
                <h4>Binding Type: {{ str_replace('_',' ',$bindingType) }}</h4>
                <h4 class="ms-auto">RM {{ $bindingPrice }}</h4>
            </div>
            <div class="d-flex pb-2">
                <h4>Amount:</h4>
                <h4 class="ms-auto">{{ $amount }} copies</h4>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h5 class="pb-2">Price per copy: RM {{ number_format((float)$totalPricePerCopy, 2, '.', '') }}</h5>
                    <h5>Total Price: RM {{ number_format((float)$totalPayPrice, 2, '.', '') }}</h5>
                    <form action="{{ route('orderCreate') }}" method="POST" id="orderValueForm">
                        <input type="hidden" value="{{ $file->fileID }}" name="fileID">
                        <input type="hidden" value="{{ $bindingType }}" name="bindingType">
                        <input type="hidden" value="{{ $checkColor }}" name="checkColor">
                        <input type="hidden" value="{{ $pageFormat }}" name="pageFormat">
                        <input type="hidden" value="{{ $amount }}" name="amount">
                    </form>
                </div>
                <div class="col-md-6">
                    <script src="https://www.paypal.com/sdk/js?client-id=AVHLdO_kJLWmLlCNLwYjJ0NgJcSNzkfKuVhV3kZarX3kjhcqBvuJpNAgBwLgveFLXH0L86gph7jwodiP&currency=MYR"></script>
                    <div id="paypal-button-container"></div>
                    <script>
                        paypal.Buttons({
                            createOrder: (data, actions) => {
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: {{ number_format((float)$totalPayPrice, 2, '.', '') }}
                                        }
                                    }]
                                });
                            },
                            onApprove: (data, actions) => {
                                return actions.order.capture().then(function(orderData) {
                                    document.getElementById("orderValueForm").submit();
                                });
                            }
                        }).render('#paypal-button-container');
                    </script>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
@endsection