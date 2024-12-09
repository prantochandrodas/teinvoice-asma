<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SupplierController extends Controller {

    public function index() {
        if (!auth_admin_user_permission('supplier.list')) {
            abort(403, "Unauthorized Access Supplier List to view");
        }

        $data               = [];
        $data['main_menu']  = 'supplier';
        $data['child_menu'] = 'supplier';
        $data['page_title'] = 'Suppliers';
        return view('admin.supplier.supplier.index', $data);
    }


    public function getSuppliers(Request $request) {
        if (!auth_admin_user_permission('supplier.list')) {
            abort(403, "Unauthorized Access Supplier List to view");
        }

        $model = Supplier::select();
        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                $image = "";

                if (!empty($data->image)) {
                    $image = ' <img src="' . asset('uploads/supplier/' . $data->image) . '"
                                class="img-fluid img-thumbnail"
                                style="height: 55px !important; width: 100px !important;" alt="supplier Image">';
                }

                return $image;
            })
            ->addColumn('status', function ($data) {

                if ($data->status == 1) {
                    $class = "success"; $status = 0; $status_name =  __('message.active') ;
                } else {
                    $class = "danger"; $status = 1; $status_name =  __('message.inactive') ;
                }

                $updateStatus = auth_admin_user_permission('supplier.updateStatus') ? "updateStatus" : "";
                return '<a class="' . $updateStatus . ' text-bold text-' . $class . '" href="javascript:void(0)" style="font-size:20px;" supplier_id="' . $data->id . '" status="' . $status . '"> ' . $status_name . '</a>';

            })
            ->addColumn('action', function ($data) {
                $button = "";
                if (auth_admin_user_permission('item.view')) {
                    $button .= '<button class="btn btn-secondary view-modal" data-toggle="modal" data-target="#viewModal" supplier_id="' . $data->id . '}" >
                        <i class="fa fa-eye"></i> </button>';
                }
                if (auth_admin_user_permission('item.edit')) {
                     $button .= '&nbsp;&nbsp;&nbsp; <a href="' . route('admin.supplier.edit', $data->id) . '" class="btn btn-success"> <i class="fa fa-edit"></i> </a>';
                }
                if (auth_admin_user_permission('item.delete')) {
                    $button .= '&nbsp;&nbsp;&nbsp; <button class="btn btn-danger delete-btn" supplier_id="' . $data->id . '">
                        <i class="fa fa-trash"></i> </button>';
                }
                return $button;
            })
            ->addColumn('balance', function($data){
                return number_format($data->balance,2);
            })
            ->with('total_balance', number_format($model->sum('balance'),2))
            ->rawColumns(['status', 'action', 'image'])
            ->make(true);
    }


    public function create() {
        if (!auth_admin_user_permission('supplier.create')) {
            abort(403, "Unauthorized Access Supplier create to view");
        }

        $data               = [];
        $data['main_menu']  = 'supplier';
        $data['child_menu'] = 'supplier';
        $data['page_title'] = 'Create Supplier';
        $data['unique_code']       = $this->supplierUniqueCode();
        return view('admin.supplier.supplier.create', $data);
    }


    public function store(Request $request) {
        if (!auth_admin_user_permission('supplier.create')) {
            abort(403, "Unauthorized Access Supplier create to view");
        }
        $validator = Validator::make($request->all(), [
            'code'           => 'required|string|min:2|unique:suppliers',
            'name'           => 'required|min:3',
            'company_name'   => 'sometimes|nullable|string|min:2',
            'email'          => 'sometimes',
            'contact_number' => 'required|string|min:5|unique:suppliers',
            'address'        => 'sometimes',
            'image'          => 'sometimes|image',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->hasFile('image')) {
            $photo      = $request->file('image');
            $photo_name = $this->uploadFile($photo, "supplier");
        } else {
            $photo_name = null;
        }

        $data = [
            'code'             => $request->input('code'),
            'name'             => $request->input('name'),
            'company_name'     => $request->input('company_name'),
            'email'            => $request->input('email'),
            'contact_number'   => $request->input('contact_number'),
            'address'          => $request->input('address'),
            'image'            => $photo_name,
            'created_admin_id' => auth()->guard('admin')->user()->id,
        ];
        $check = Supplier::create($data) ? true : false;

        if ($check) {
            $this->setMessage('Supplier Create Successfully', 'success');
            return redirect()->route('admin.supplier.index');
        } else {
            $this->setMessage('Supplier Create Failed', 'danger');
            return redirect()->back()->withInput();
        }

    }


    public function show(Request $request, Supplier $supplier) {
        if (!auth_admin_user_permission('supplier.view')) {
            abort(403, "Unauthorized Access Supplier to view");
        }
        return view('admin.supplier.supplier.show', compact('supplier'));
    }


    public function edit(Request $request, Supplier $supplier) {
        if (!auth_admin_user_permission('supplier.edit')) {
            abort(403, "Unauthorized Access Supplier edit to view");
        }

        $data               = [];
        $data['main_menu']  = 'supplier';
        $data['child_menu'] = 'supplier';
        $data['page_title'] = 'Edit Supplier';
        $data['supplier']   = $supplier;
        return view('admin.supplier.supplier.edit', $data);
    }


    public function update(Request $request, Supplier $supplier) {
        if (!auth_admin_user_permission('supplier.edit')) {
            abort(403, "Unauthorized Access Supplier edit to view");
        }

        $validator = Validator::make($request->all(), [
            'code'           => 'required|string|min:2|unique:suppliers,code,' . $supplier->id,
            'name'           => 'required|min:3',
            'company_name'   => 'sometimes|nullable|string|min:2',
            'email'          => 'sometimes',
            'contact_number' => 'required|string|min:5|unique:suppliers,contact_number,' . $supplier->id,
            'address'        => 'sometimes',
            'image'          => 'sometimes|image',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->hasFile('image')) {
            $photo      = $request->file('image');
            $photo_name = $this->uploadFile($photo, "supplier");

            if (!empty($supplier->image)) {
                $old_photo_path = str_replace('\\', '/', public_path()) . '/uploads/supplier/' . $supplier->image;

                if (file_exists($old_photo_path)) {
                    unlink($old_photo_path);
                }

            }

        } else {
            $photo_name = $supplier->image;
        }

        $data = [
            'code'             => $request->input('code'),
            'name'             => $request->input('name'),
            'company_name'     => $request->input('company_name'),
            'email'            => $request->input('email'),
            'contact_number'   => $request->input('contact_number'),
            'address'          => $request->input('address'),
            'image'            => $photo_name,
            'updated_admin_id' => auth()->guard('admin')->user()->id,
        ];


        $check = Supplier::where('id', $supplier->id)->update($data) ? true : false;

        if ($check) {
            $this->setMessage('Supplier Update Successfully', 'success');
            return redirect()->route('admin.supplier.index');
        } else {
            $this->setMessage('Supplier Update Failed', 'danger');
            return redirect()->back()->withInput();
        }
    }


    public function updateStatus(Request $request) {
        if (!auth_admin_user_permission('supplier.updateStatus')) {
            abort(403, "Unauthorized Access Supplier update Status to view");
        }
        $response = [
            'error' => 'Error Found',
        ];

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'supplier_id' => 'required',
                'status'      => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'error' => 'Error Found',
                ];
            } else {
                $check = Supplier::where('id', $request->supplier_id)->update(['status' => $request->status]) ? true : false;

                if ($check) {
                    $response = [
                        'success' => 'Supplier Status Update Successfully',
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


    public function destroy(Request $request, Supplier $supplier) {
        if (!auth_admin_user_permission('supplier.delete')) {
            abort(403, "Unauthorized Access Supplier Delete to view");
        }
        if (!empty($supplier->image)) {
            $old_photo_path = str_replace('\\', '/', public_path()) . '/uploads/supplier/' . $supplier->image;
            if (file_exists($old_photo_path)) {
                unlink($old_photo_path);
            }
        }

        $check = $supplier->delete() ? true : false;

        if ($check) {
            $this->setMessage('Admin Delete Successfully', 'success');
        } else {
            $this->setMessage('Admin Delete Failed', 'danger');
        }

        return redirect()->route('admin.admin.index');
    }


    public function delete(Request $request) {
        if (!auth_admin_user_permission('supplier.delete')) {
            abort(403, "Unauthorized Access Supplier Delete to view");
        }

        $response = ['error' => 'Error Found'];

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'supplier_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = ['error' => 'Error Found'];
            } else {
                $supplier   = Supplier::where('id', $request->supplier_id)->first();
                $check      = Supplier::where('id', $request->supplier_id)->delete() ? true : false;

                if ($check) {

                    if (!empty($supplier->image)) {
                        $old_photo_path = str_replace('\\', '/', public_path()) . '/uploads/supplier/' . $supplier->image;

                        if (file_exists($old_photo_path)) {
                            unlink($old_photo_path);
                        }

                    }

                    $response = ['success' => 'Supplier Delete Update Successfully'];
                } else {
                    $response = ['error' => 'Database Error Found'];
                }

            }

        }

        return response()->json($response);
    }

}
