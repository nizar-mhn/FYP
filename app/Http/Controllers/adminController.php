<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    public function index()
    {
        $orderList = Order::whereNot('status', '=', 'Delivered')->paginate(10);
        return view('admin/admin_main', ['order' => $orderList]);
    }

    public function status($orderID, $status)
    {
        $updateStatus = DB::table('orders')
            ->where('orderID', $orderID)
            ->update(['status' => $status]);

        return redirect()->route('adminMainPage');
    }


    public function report(Request $request)
    {
        
        $this->data['start_date']  = $request->input('start');
        $this->data['end_date']  = $request->input('end');

        $this->data['orders'] = Order::select('orders.orderDate', 'order_printing_infos.bindingType', 'order_printing_infos.color', 'order_printing_infos.pageFormat',  'order_printing_infos.numCopies', 'payments.totalPrice','files.noPage','files.fileName')
            ->join('order_details', 'order_details.orderID', '=', 'orders.orderID')
            ->join('order_printing_infos', 'order_printing_infos.orderPrintingInfoID', '=', 'order_details.orderPrintingInfoID')
            ->join('files','files.fileID','=','order_printing_infos.fileID')
            ->join('payments','payments.orderID','=','orders.orderID')
            ->whereBetween('orders.orderDate', [$this->data['start_date'], $this->data['end_date']])
            ->where('orders.status','=','Delivered')
            ->get();

        return view('admin/admin_report',$this->data);
    }
}
