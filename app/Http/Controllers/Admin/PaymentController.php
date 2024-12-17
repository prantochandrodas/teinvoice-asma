<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function salePaymentList()
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
            $data = Payment::with(['customer', 'saleInfo'])->where('type', 1)
                ->get();
            return DataTables::of($data)
                ->addColumn('bill_no', function ($row) {
                    return $row->saleInfo ? $row->saleInfo->bill_no : '';
                })
                ->addColumn('customer_name', function ($row) {
                    return $row->customer ? $row->customer->name : 'N/A';
                })
                ->addColumn('customer_phone', function ($row) {
                    return $row->customer ? $row->customer->phone : 'N/A';
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('admin.sale-payment.salePrint', [$data->id]) . '" class="btn btn-success btn-sm" title="Print Sale Item"
                        target="_blank">
                    <i class="fas fa-print"></i>
                    </a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function salePaymentPrint(Request $request, $id)
    {

        //    dd($id);
        $data = Payment::with(['saleInfo', 'customer'])->find($id);

        return view('admin.sales_payment_list.print', compact('data'));
    }


    public function duePaymentList()
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
            $data = Payment::with(['customer', 'saleInfo'])->where('type', 2)
                ->get();
            return DataTables::of($data)
                ->addColumn('bill_no', function ($row) {
                    return $row->saleInfo ? $row->saleInfo->bill_no : '';
                })
                ->addColumn('customer_name', function ($row) {
                    return $row->customer ? $row->customer->name : 'N/A';
                })
                ->addColumn('customer_phone', function ($row) {
                    return $row->customer ? $row->customer->phone : 'N/A';
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('admin.sale-payment.salePrint', [$data->id]) . '" class="btn btn-success btn-sm" title="Print Sale Item"
                        target="_blank">
                    <i class="fas fa-print"></i>
                    </a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
