<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Repositories\EloquentInterface\AdminRepositoryInterface;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AdminController extends Controller {


    public function index() {

        // dd(auth('admin')->user()->actions);

        if (!auth_admin_user_permission('admin.list')) {
            abort(403, "Unauthorized Access Admin List to view");
        }

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'admin';
        $data['page_title'] = 'Admins';
        return view('admin.setting.admin.index', $data);
    }

    public function getAdmins(Request $request) {

        if (!auth_admin_user_permission('admin.list')) {
            abort(403, "Unauthorized Access Admin List to view");
        }


        $model = Admin::select();

        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('role', function ($data) {
                $roles = '';
                if ($data->roles) {
                    foreach ($data->roles as $role) {
                        $roles .= '<span class="badge badge-info mr-2">';
                        $roles .= $role->name;
                        $roles .= '</span>';
                    }
                }

                return $roles;
            })
            ->addColumn('full_name', function ($data) {
                return $data->full_name;
            })
            ->addColumn('image', function ($data) {
                $image = "";

                if (!empty($data->photo)) {
                    $image = ' <img src="' . asset('uploads/admin/' . $data->photo) . '"
                                class="img-fluid img-thumbnail"
                                style="height: 55px !important; width: 100px !important;" alt="Admin Photo">';
                }

                return $image;
            })
            ->addColumn('status', function ($data) {

                if ($data->id != auth()->guard('admin')->user()->id) {

                    if ($data->status == 1) {
                        $class = "success"; $status = 0; $status_name =  __('message.active');
                    } else {
                        $class = "danger"; $status = 1; $status_name = __('message.inactive');
                    }

                    $updateStatus = auth_admin_user_permission('admin.updateStatus') ? "updateStatus" : "";
                    return '<a class="' . $updateStatus . ' text-bold text-' . $class . '" href="javascript:void(0)" style="font-size:20px;" admin_id="' . $data->id . '" status="' . $status . '"> ' . $status_name . '</a>';
                }

            })
            ->addColumn('action', function ($data) {
                $button = "";

                if (auth_admin_user_permission('admin.view')) {
                    $button .= '<button class="btn btn-secondary view-modal" data-toggle="modal" data-target="#viewModal" admin_id="' . $data->id . '}" >
                                    <i class="fa fa-eye"></i> </button>';
                }

                if (auth_admin_user_permission('admin.edit')) {
                    $button .= '&nbsp;&nbsp;&nbsp; <a href="' . route('admin.admin.edit', $data->id) . '" class="btn btn-success"> <i class="fa fa-edit"></i> </a>';
                }

                if (auth_admin_user_permission('admin.delete')) {

                    if ($data->id != auth()->guard('admin')->user()->id) {
                        $button .= '&nbsp;&nbsp;&nbsp; <button class="btn btn-danger delete-btn" admin_id="' . $data->id . '">
                            <i class="fa fa-trash"></i> </button>';
                    }

                }

                return $button;
            })
            ->rawColumns(['role', 'status', 'action', 'image'])
            ->make(true);
    }

    public function create() {

        if (!auth_admin_user_permission('admin.create')) {
            abort(403, "Unauthorized Access Admin Create");
        }

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'admin';
        $data['roles']      = Role::all();
        $data['page_title'] = 'Create Admin';
        return view('admin.setting.admin.create', $data);
    }

    public function store(Request $request) {

        if (!auth_admin_user_permission('admin.create')) {
            abort(403, "Unauthorized Access Admin Create");
        }

        $validator = Validator::make($request->all(), [
            'username'   => 'required|min:3|max:30|unique:admins',
            'email'      => 'required|email|unique:admins',
            'first_name' => 'required|min:3',
            'last_name'  => 'required|min:3',
            'phone'      => 'required|unique:admins',
            'password'   => 'required|min:5',
            'address'    => 'sometimes',
            'photo'      => 'sometimes|image|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $photo_name = null;

        if ($request->hasFile('photo')) {
            $photo_name = $this->uploadFile($request->file('photo'), "admin");
        }

        $data = [
            'username'       => $request->input('username'),
            'email'          => $request->input('email'),
            'first_name'     => $request->input('first_name'),
            'last_name'      => $request->input('last_name'),
            'phone'          => $request->input('phone'),
            'address'        => $request->input('address'),
            'password'       => bcrypt($request->input('password')),
            'store_password' => $request->input('password'),
            'photo'          => $photo_name,
        ];

        DB::beginTransaction();
        try{

            $admin = Admin::create($data);
            if ($admin) {
                $roles = $request->roles;

                if ($roles) {
                    $admin->assignRole($roles);
                }

                DB::commit();
                $this->setMessage('Admin Create Successfully', 'success');
                return redirect()->route('admin.admin.index');
            } else {
                $this->setMessage('Admin Create Failed', 'danger');
                return redirect()->back()->withInput();
            }

        }catch(\Exception $e){
            DB::rollBack();
            $this->setMessage($e->getMessage(), 'danger');
            return redirect()->back()->withInput();
        }


    }

    public function show(Request $request, Admin $admin) {

        if (!auth_admin_user_permission('admin.view')) {
            abort(403, "Unauthorized Access Admin View");
        }

        return view('admin.setting.admin.show', compact('admin'));
    }

    public function edit(Request $request, Admin $admin) {

        if (!auth_admin_user_permission('admin.edit')) {
            abort(403, "Unauthorized Access Admin Edit");
        }

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'admin';
        $data['page_title'] = 'Edit Admin';
        $data['roles']      = Role::all();
        $data['admin']      = $admin;
        return view('admin.setting.admin.edit', $data);
    }

    public function update(Request $request, Admin $admin) {

        if (!auth_admin_user_permission('admin.edit')) {
            abort(403, "Unauthorized Access Admin Update Status");
        }

        $validator = Validator::make($request->all(), [
            'username'   => 'required|min:3|max:30|unique:admins,username,' . $admin->id,
            'email'      => 'required|email|unique:admins,email,' . $admin->id,
            'first_name' => 'required|min:3',
            'last_name'  => 'required|min:3',
            'phone'      => 'required|unique:admins,phone,' . $admin->id,
            'password'   => $request->password != null ? 'sometimes|min:5|max:100' : '',
            'address'    => 'sometimes',
            'photo'      => 'sometimes|image|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $photo_name = $admin->photo;

        if ($request->hasFile('photo')) {
            $photo_name = $this->uploadFile($request->file('photo'), "admin");
            $this->removeFile($admin->photo, "admin");
        }

        $data = [
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'type'  => 1,
            'photo' => $photo_name,
        ];

        $data = [
            'username'   => $request->input('username'),
            'email'      => $request->input('email'),
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'phone'      => $request->input('phone'),
            'address'    => $request->input('address'),
            'photo'      => $photo_name,
        ];

        if (!empty($request->password)) {
            $data['password']       = bcrypt($request->input('password'));
            $data['store_password'] = $request->input('password');
        }

        DB::beginTransaction();
        try{
            $check = Admin::where('id', $admin->id)->update($data) ? true : false;

            $admin->roles()->detach();

            $roles = $request->roles;

            if ($roles) {
                $admin->assignRole($roles);
            }

            DB::commit();
            if ($check) {
                $this->setMessage('Admin Update Successfully', 'success');
                return redirect()->route('admin.admin.index');
            } else {
                $this->setMessage('Admin Update Failed', 'danger');
                return redirect()->back()->withInput();
            }
        }catch(\Exception $e) {
            DB::rollBack();
            $this->setMessage('Admin Update Failed', 'danger');
            return redirect()->back()->withInput();
        }

    }

    public function updateStatus(Request $request) {

        if (!auth_admin_user_permission('admin.updateStatus')) {
            abort(403, "Unauthorized Access Admin Update Status");
        }

        $response = [
            'error' => 'Error Found',
        ];

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'admin_id' => 'required',
                'status'   => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'error' => 'Error Found',
                ];
            }
            else {
                $check = Admin::where('id', $request->admin_id)->update(['status' => $request->status]) ? true : false;

                if ($check) {
                    $response = [
                        'success' => 'Admin Status Update Successfully',
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


    public function destroy(Request $request, Admin $admin) {

        if (!auth_admin_user_permission('admin.delete')) {
            abort(403, "Unauthorized Access Admin Delete");
        }

        if (!empty($admin->photo)) {
            $this->removeFile($admin->photo, "admin");

        }

        $check = $admin->delete() ? true : false;

        if ($check) {
            $this->setMessage('Admin Delete Successfully', 'success');
        } else {
            $this->setMessage('Admin Delete Failed', 'danger');
        }

        return redirect()->route('admin.admin.index');
    }



    public function delete(Request $request) {

        if (!auth_admin_user_permission('admin.delete')) {
            abort(403, "Unauthorized Access Admin Delete");
        }

        $response = ['error' => 'Error Found'];

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'admin_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = ['error' => 'Error Found'];
            } else {
                $admin = Admin::where('id', $request->admin_id)->first();
                $check = Admin::where('id', $request->admin_id)->delete() ? true : false;

                if ($check) {
                    if (!empty($admin->photo)) {
                        $this->removeFile($admin->photo, "admin");
                    }

                    $response = ['success' => 'Admin Delete Update Successfully'];
                } else {
                    $response = ['error' => 'Database Error Found'];
                }

            }

        }

        return response()->json($response);
    }

}
