<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use DateTime;
use Illuminate\Support\Facades\DB;

class supplierController extends Controller
{
    public function index()
    {
        $orderList = Order::whereNot('status', '=', 'Delivered')->paginate(10);
        return view('supplier/supplier_main', ['order' => $orderList]);
    }

    public function status($orderID, $status)
    {
        $updateStatus = DB::table('orders')
            ->where('orderID', $orderID)
            ->update(['status' => $status]);

        return redirect()->route('supplierMainPage');
    }


    public function report(Request $request)
    {

        $this->data['start_date']  = $request->input('start');
        $this->data['end_date']  = $request->input('end');

        $start_date = new DateTime($this->data['start_date']);
        $end_date = new DateTime($this->data['end_date']);

        $end_date->setTime(23, 59, 59);

        $this->data['orders'] = Order::select('orders.orderDate', 'order_printing_infos.bindingType', 'order_printing_infos.color', 'order_printing_infos.pageFormat',  'order_printing_infos.numCopies', 'payments.totalPrice', 'files.noPage', 'files.fileName')
            ->join('order_details', 'order_details.orderID', '=', 'orders.orderID')
            ->join('order_printing_infos', 'order_printing_infos.orderPrintingInfoID', '=', 'order_details.orderPrintingInfoID')
            ->join('files', 'files.fileID', '=', 'order_printing_infos.fileID')
            ->join('payments', 'payments.orderID', '=', 'orders.orderID')
            ->whereBetween('orders.orderDate', [$start_date,  $end_date])
            ->where('orders.status', '=', 'Delivered')
            ->get();

        $errorMsg = "";
        $infoMsg = "";

        if ($request->input('generate')) {
            if ($this->data['start_date'] > $this->data['end_date']) {
                $errorMsg = "End date cannot be earlier than Start date";
            } else {
                if (!count($this->data['orders'])) {
                    $infoMsg = "There is no Sales during <b>" . date_format($start_date, 'm/d/Y') . "-" . date_format($end_date, 'm/d/Y') . "</b>";
                }
            }
        }

        return view('supplier/supplier_report', $this->data)->with('error', $errorMsg)->with('info', $infoMsg);
    }
}
