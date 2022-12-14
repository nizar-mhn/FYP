<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Carbon\Carbon;

class invoiceController extends Controller
{   

    public function viewInvoice(Request $request){

        if ($request->color == 'on') {
            $colorPrice = 0.20;
        }else {
            $colorPrice = 0.10;
        }
        
        $pagePrice = $request->noPage * $colorPrice;
        
        if ($request->bindingType == 'No_binding') {
            $bindingPrice = 0.00;
        }else {
            $bindingPrice = 1.00;
        }
        
        $totalPricePerCopy = $pagePrice + $bindingPrice;

        $client = new Party([
            'name'=> 'TARUMT Printing',
            'phone' => '03-4145 0123',

        ]);

        $customer = new Party([
            'name' => Auth::user()->studentName,
            'custom_fields'=>[
                'email' => Auth::user()->email,
                'student ID' => Auth::user()->studentID,
                'order ID'=> $request->orderID,
                'Deliver location' => $request->location,
            ],
        ]);
        
        $pageFormat;
        if($request->pageFormat == 'one-side'){
            $pageFormat = 'One-sided page';
        }else{
            $pageFormat = 'Back-to-Back Page';
        }

        $item = (new InvoiceItem())
        ->title($request->fileName)
        ->description("Binding Type: ".$request->bindingType."
        ,Color: ". $request->color. "
        ,Page format: ".$pageFormat)
        ->quantity($request->numCopies)
        ->pricePerUnit($totalPricePerCopy)
        ->subTotalPrice($request->price);

        $date = Carbon::parse($request->orderDate);

        $invoice = Invoice::make()
            ->status(__('invoices::invoice.paid'))
            ->buyer($customer)
            ->seller($client)
            ->sequence($request->orderID)
            ->date($date)
            ->currencySymbol('RM')
            ->currencyCode('MYR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->payUntilDays(0)
            ->name('Receipt')
            ->filename('Order:#'.$request->orderID.'_Customer:'.Auth::user()->studentName)
            ->logo(public_path('image/logoPrintingTransparent.png'))
            ->addItem($item);

            return $invoice->stream();
    }

    public function downloadInvoice(Request $request){

        if ($request->color == 'on') {
            $colorPrice = 0.20;
        }else {
            $colorPrice = 0.10;
        }
        
        $pagePrice = $request->noPage * $colorPrice;
        
        if ($request->bindingType == 'No_binding') {
            $bindingPrice = 0.00;
        }else {
            $bindingPrice = 1.00;
        }
        
        $totalPricePerCopy = $pagePrice + $bindingPrice;

        $client = new Party([
            'name'=> 'TARUMT Printing',
            'phone' => '03-4145 0123',

        ]);

        $customer = new Party([
            'name' => Auth::user()->studentName,
            'custom_fields'=>[
                'email' => Auth::user()->email,
                'student id' => Auth::user()->studentID,
                'order id'=> $request->orderID,
                'Deliver location' => $request->location,
            ],
        ]);
        
        $pageFormat;
        if($request->pageFormat == 'one-side'){
            $pageFormat = 'One-sided page';
        }else{
            $pageFormat = 'Back-to-Back Page';
        }

        $item = (new InvoiceItem())
        ->title($request->fileName)
        ->description("Binding Type: ".$request->bindingType."
        ,Color: ". $request->color. "
        ,Page format: ".$pageFormat)
        ->quantity($request->numCopies)
        ->pricePerUnit($totalPricePerCopy)
        ->subTotalPrice($request->price);

        $date = Carbon::parse($request->orderDate);

        $invoice = Invoice::make()
            ->status(__('invoices::invoice.paid'))
            ->buyer($customer)
            ->seller($client)
            ->sequence($request->orderID)
            ->date($date)
            ->currencySymbol('RM')
            ->currencyCode('MYR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->name('Receipt')
            ->payUntilDays(0)
            ->filename('Order:#'.$request->orderID.'_Customer:'.Auth::user()->studentName)
            ->logo(public_path('image/logoPrintingTransparent.png'))
            ->addItem($item);

            return $invoice->download();
    }

}
