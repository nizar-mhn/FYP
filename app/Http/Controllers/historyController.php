<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class historyController extends Controller
{
    public function index()
    {
        $currentUserID = Auth::user()->studentID;
        $currentUserOrderPrintingInfoID = DB::table('orders')
        ->join('order_details','orders.orderID', "=", 'order_details.orderID')
        ->where('orders.studentID',$currentUserID)->orderBy('orderDate','desc')->get();
        
        return view('students/history',[
            'printingInfoID' => $currentUserOrderPrintingInfoID,
        ]);
    }
}
