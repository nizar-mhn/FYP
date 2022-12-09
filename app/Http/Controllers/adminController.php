<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    public function index()
    {
        $orderList = Order::whereNot('status', '=', 'Complete')->paginate(10);
        return view('admin/admin_main', ['order' => $orderList]);
    }

    public function status($orderID,$status)
    {
        $updateStatus = DB::table('orders')
            ->where('orderID', $orderID)
            ->update(['status' => $status]);

            return redirect()->route('adminMainPage');
    }


    public function report()
    {
        return view('admin/admin_report');
    }
}
