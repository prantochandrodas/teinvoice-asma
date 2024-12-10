<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function salePaymentList ()
    {

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'SalesPaymentList';
        $data['page_title'] = 'Sales Payment List';
        return view('admin.sales_payment_list.index', $data);
    }

    public function salePaymentGetdata(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::with('customer')->where('type', 1)
            ->get();
            return DataTables::of($data)
            ->addColumn('customer_name', function ($row){
                return $row->customer ? $row->customer->name : '';
            })
            ->addColumn('customer_phone', function ($row){
                return $row->customer ? $row->customer->phone : '';
            })
                ->make(true);
        }
    }

    public function duePaymentList ()
    {

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'DuePaymentList';
        $data['page_title'] = 'Due Payment List';
        return view('admin.due_payment_list.index', $data);
    }

    public function duePaymentGetdata(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::with('customer')->where('type', 2)
            ->get();
            return DataTables::of($data)
            ->addColumn('customer_name', function ($row){
                return $row->customer ? $row->customer->name : '';
            })
            ->addColumn('customer_phone', function ($row){
                return $row->customer ? $row->customer->phone : '';
            })
            ->make(true);
        }
    }
}
