<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class paymentController extends Controller
{
    public function index(Request $request){
        $bindingType = $request->input('binding-type');
        $color = $request->input('checkColor','off');
        $pageFormat = $request->input('pageFormat');
        $amount = $request->input('amount');
        return view('students/payment', [
            'bindingType' => $bindingType,
            'checkColor' => $color,
            'pageFormat' => $pageFormat,
            'amount' => $amount,
        ]);
    }
}
