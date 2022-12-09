<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class paymentController extends Controller
{
    public function index(Request $request){
        $bindingType = $request->input('binding-type');
        $color = $request->input('checkColor','off');
        $pageFormat = $request->input('pageFormat');
        $amount = $request->input('amount');
        $file = DB::table('files')->where('fileID', $request->input('fileID'))->first();
        return view('students/payment', [
            'bindingType' => $bindingType,
            'checkColor' => $color,
            'pageFormat' => $pageFormat,
            'amount' => $amount,
            'file' => $file,
        ]);
    }

    public function orderCreate(Request $request){
        
    }
}
