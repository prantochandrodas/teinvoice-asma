<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
            // ->addColumn('division_name', function ($row){
            //     dd($row->name);
            //     return $row->division ? $row->division->name : '';
            // })
                ->make(true);
        }
    }
}
