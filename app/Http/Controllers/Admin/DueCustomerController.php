<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DueCustomerController extends Controller
{
    public function index() {

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'DueList';
        $data['page_title'] = 'Customer Due List';
        return view('admin.due_customer.index', $data);
    }

    public function getdata(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::where('due_payment', '>', 0)
            ->orderBy('due_payment', 'desc')
            ->get();
            return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $button = "";
                $deleteUrl = route('admin.expense.destroy', $data->id);
                $csrfToken = csrf_field();
                $method = method_field('DELETE');
                $button .= '<div class="d-inline-flex align-items-center">
                              <a data-toggle="modal" data-target="#viewDetailsModal" purchase_id="' . $data->id . '" class="view-details btn btn-sm me-2 rounded" style="padding:8px; background-color:#17a2b8; color:white"><span>' .
                                  '<i class="fa fa-eye"></i>' .
                                 '</span></a>
                            </div>';

              
                return $button;
            })
            ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function dueCustomerDetails($id){
        $saleInfo=Sale::where('customer_id',$id)->get();
        $paymentInfo=Payment::where('customer_id',$id)->get();
       return view('admin.due_customer.details',compact('saleInfo','paymentInfo'));
     }

}
