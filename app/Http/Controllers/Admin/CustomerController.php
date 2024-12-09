<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Customer;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller {

    public function index() {

        if (!auth_admin_user_permission('customer.list')) {
            abort(403, "Unauthorized Access Customer List to view");
        }

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'customer';
        $data['page_title'] = 'Customers';
        return view('admin.setting.customer.index', $data);
    }

    public function getCustomers(Request $request) {

        if (!auth_admin_user_permission('customer.list')) {
            abort(403, "Unauthorized Access  Customer List to view");
        }

        $model = Customer::select();

        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('full_name', function ($data) {
                return $data->full_name;
            })
            ->addColumn('image', function ($data) {
                $image = "";

                if (!empty($data->image)) {
                    $image = ' <img src="' . asset('uploads/customer/' . $data->image) . '"
                                class="img-fluid img-thumbnail"
                                style="height: 55px !important; width: 100px !important;" alt="Customer Photo">';
                }

                return $image;
            })
            ->addColumn('status', function ($data) {

                if ($data->status == 1) {
                    $class = "success"; $status = 0; $status_name = "Active";
                } else {
                    $class = "danger"; $status = 1; $status_name = "Inactive";
                }

                $updateStatus = auth_admin_user_permission('customer.updateStatus') ? "updateStatus" : "";
                return '<a class="' . $updateStatus . ' text-bold text-' . $class . '" href="javascript:void(0)" style="font-size:20px;" customer_id="' . $data->id . '" status="' . $status . '"> ' . $status_name . '</a>';

            })
            ->addColumn('action', function ($data) {
                $button = "";

                if (auth_admin_user_permission('customer.view')) {
                    $button .= '<button class="btn btn-secondary view-modal" data-toggle="modal" data-target="#viewModal" customer_id="' . $data->id . '}" >
                                    <i class="fa fa-eye"></i> </button>';
                }

                if (auth_admin_user_permission('customer.edit')) {
                    $button .= '&nbsp;&nbsp;&nbsp; <a href="' . route('admin.customer.edit', $data->id) . '" class="btn btn-success"> <i class="fa fa-edit"></i> </a>';
                }

                if (auth_admin_user_permission('customer.delete')) {

                    $button .= '&nbsp;&nbsp;&nbsp; <button class="btn btn-danger delete-btn" customer_id="' . $data->id . '">
                        <i class="fa fa-trash"></i> </button>';

                }

                return $button;
            })
            ->rawColumns(['status', 'action', 'image'])
            ->make(true);
    }

    public function create() {

        if (!auth_admin_user_permission('customer.create')) {
            abort(403, "Unauthorized Access  Customer Create");
        }

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'customer';
        $data['page_title'] = 'Create Customer';
        return view('admin.setting.customer.create', $data);
    }

    public function store(Request $request) {

        if (!auth_admin_user_permission('customer.create')) {
            abort(403, "Unauthorized Access  Customer Create");
        }

        $validator = Validator::make($request->all(), [
            'name'    => 'required|min:3',
            'email'   => 'sometimes|email',
            'phone'   => 'required|unique:customers',
            'image'   => 'sometimes|image|max:2000',
            'vat_no'  => 'sometimes',
            'address' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $image_name = null;

        if ($request->hasFile('image')) {
            $image_name = $this->uploadFile($request->file('image'), "customer");
        }

        $data = [
            'name'             => $request->input('name'),
            'email'            => $request->input('email'),
            'phone'            => $request->input('phone'),
            'vat_no'           => $request->input('vat_no'),
            'address'          => $request->input('address'),
            'image'            => $image_name,
            'created_admin_id' => auth()->guard('admin')->user()->id,
        ];

        $customer = Customer::create($data);

        if ($customer) {
            $this->setMessage('Customer Create Successfully', 'success');
            return redirect()->route('admin.customer.index');
        } else {
            $this->setMessage('Customer Create Failed', 'danger');
            return redirect()->back()->withInput();
        }

    }

    public function show(Customer $customer) {

        if (!auth_admin_user_permission('customer.view')) {
            abort(403, "Unauthorized Access Customer View");
        }

        return view('admin.setting.customer.show', compact('customer'));
    }

    public function edit(Customer $customer) {

        if (!auth_admin_user_permission('customer.edit')) {
            abort(403, "Unauthorized Access  Customer Edit");
        }

        $data               = [];
        $data['main_menu']  = 'customer';
        $data['child_menu'] = 'customer';
        $data['page_title'] = 'Edit Customer ';
        $data['customer']   = $customer;
        return view('admin.setting.customer.edit', $data);
    }

    public function update(Request $request, Customer $customer) {

        if (!auth_admin_user_permission('customer.edit')) {
            abort(403, "Unauthorized Access Customer Edit");
        }

        $validator = Validator::make($request->all(), [
            'name'    => 'required|min:3',
            'email'   => 'sometimes|email',
            'phone'   => 'required|unique:customers,phone,' . $customer->id,
            'image'   => 'sometimes|image|max:2000',
            'vat_no'  => 'sometimes',
            'address' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $image_name = $customer->image;

        if ($request->hasFile('image')) {
            $image_name = $this->uploadFile($request->file('image'), "customer");
            $this->removeFile($customer->image, "customer");
        }

        $data = [
            'name'             => $request->input('name'),
            'vat_no'           => $request->input('vat_no'),
            'email'            => $request->input('email'),
            'phone'            => $request->input('phone'),
            'address'          => $request->input('address'),
            'image'            => $image_name,
            'updated_admin_id' => auth()->guard('admin')->user()->id,
        ];
        $check = Customer::where('id', $customer->id)->update($data) ? true : false;

        if ($check) {
            $this->setMessage('Customer Update Successfully', 'success');
            return redirect()->route('admin.customer.index');
        } else {
            $this->setMessage('Customer Update Failed', 'danger');
            return redirect()->back()->withInput();
        }

    }

    public function updateStatus(Request $request) {

        if (!auth_admin_user_permission('customer.updateStatus')) {
            abort(403, "Unauthorized Access  Customer Update Status");
        }

        $response = [
            'error' => 'Error Found',
        ];

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required',
                'status'      => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'error' => 'Error Found',
                ];
            } else {
                $check = Customer::where('id', $request->customer_id)->update(['status' => $request->status]) ? true : false;

                if ($check) {
                    $response = [
                        'success' => 'Customer Status Update Successfully',
                        'status'  => $request->status,
                    ];
                } else {
                    $response = [
                        'error' => 'Database Error Found',
                    ];
                }

            }

        }

        return response()->json($response);
    }

    public function destroy(Customer $customer) {

        if (!auth_admin_user_permission('customer.delete')) {
            abort(403, "Unauthorized Access  Customer Delete");
        }

        if (!empty($customer->image)) {
            $this->removeFile($customer->image, "customer");
        }

        $check = $customer->delete() ? true : false;

        if ($check) {
            $this->setMessage('Customer Delete Successfully', 'success');
        } else {
            $this->setMessage('Customer Delete Failed', 'danger');
        }

        return redirect()->route('admin.customer.index');
    }

    public function delete(Request $request) {

        if (!auth_admin_user_permission('customer.delete')) {
            abort(403, "Unauthorized Access  Customer Delete");
        }

        $response = ['error' => 'Error Found'];

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = ['error' => 'Error Found'];
            } else {
                $customer = Customer::where('id', $request->customer_id)->first();
                $check    = Customer::where('id', $request->customer_id)->delete() ? true : false;

                if ($check) {

                    if (!empty($customer->image)) {
                        $this->removeFile($customer->image, "customer");
                    }

                    $response = ['success' => 'Customer Delete Update Successfully'];
                } else {
                    $response = ['error' => 'Database Error Found'];
                }

            }

        }

        return response()->json($response);
    }

}
