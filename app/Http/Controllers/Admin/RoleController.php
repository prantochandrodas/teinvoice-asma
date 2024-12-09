<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller {

    public function index() {

        if (!auth_admin_user_permission('role.list')) {
            abort(403, "Unauthorized Access Role List to View");
        }

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'role';
        $data['page_title'] = 'Roles ';
        return view('admin.setting.role.index', $data);
    }

    public function getRoles(Request $request) {

        if (!auth_admin_user_permission('role.list')) {
            abort(403, "Unauthorized Access Role List to View");
        }

        $model = Role::select();
        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('permission', function ($data) {
                $permissions = '';

                if ($data->permissions) {

                    foreach ($data->permissions as $permission) {
                        $permissions .= '<span class="badge badge-info mr-2">';
                        $permissions .= $permission->name;
                        $permissions .= '</span>';
                    }

                }

                return $permissions;
            })
            ->addColumn('action', function ($data) {
                $button = "";

                if (auth_admin_user_permission('role.edit')) {
                    $button .= '&nbsp;&nbsp;&nbsp; <a href="' . route('admin.role.edit', $data->id) . '" class="btn btn-success"> <i class="fa fa-edit"></i> </a>';
                }

                if (auth_admin_user_permission('role.delete')) {
                    $button .= '&nbsp;&nbsp;&nbsp; <button class="btn btn-danger delete-btn" role_id="' . $data->id . '">
                            <i class="fa fa-trash"></i> </button>';
                }

                return $button;
            })
            ->rawColumns(['permission', 'action'])
            ->make(true);
    }

    public function create() {

        if (!auth_admin_user_permission('role.create')) {
            abort(403, "Unauthorized Access Role Create");
        }

        $data                       = [];
        $data['main_menu']          = 'setting';
        $data['child_menu']         = 'role';
        $data['page_title']         = 'Create Role';
        $data['all_permissions']    = Permission::all();
        $data['permissions_groups'] = Admin::getPermissionGroups();
        return view('admin.setting.role.create', $data);
    }

    public function store(Request $request) {

        if (!auth_admin_user_permission('role.create')) {
            abort(403, "Unauthorized Access Role Create");
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|unique:roles',
        ], [
            'name.required' => "Please Enter Role Name",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $photo_name = null;

        if ($request->hasFile('photo')) {
            $photo      = $request->file('photo');
            $photo_name = $this->uploadFile($photo, "admin");
        }

        $permissions = $request->permissions;
        $name        = $request->name;
        $role        = Role::create(['name' => $name, 'guard_name' => 'admin']);

        if ($role) {

            if ($role && !empty($permissions)) {
                $role->syncPermissions($permissions);
            }

            $this->setMessage('Role Create Successfully', 'success');
            return redirect()->route('admin.role.index');
        } else {
            $this->setMessage('Role Create Failed', 'danger');
            return redirect()->back()->withInput();
        }

    }

    public function show(Request $request, Admin $admin) {

        if (!auth_admin_user_permission('role.view')) {
            abort(403, "Unauthorized Access Role View");
        }

        return view('admin.setting.admin.show', compact('admin'));
    }

    public function edit(Request $request, Role $role) {

        if (!auth_admin_user_permission('role.edit')) {
            abort(403, "Unauthorized Access Role Edit");
        }

        $data                       = [];
        $data['main_menu']          = 'setting';
        $data['child_menu']         = 'role';
        $data['page_title']         = 'Edit Admin';
        $data['role']               = $role;
        $data['all_permissions']    = Permission::all();
        $data['permissions_groups'] = Admin::getPermissionGroups();
        return view('admin.setting.role.edit', $data);
    }

    public function update(Request $request, Role $role) {

        if (!auth_admin_user_permission('role.edit')) {
            abort(403, "Unauthorized Access Role Edit");
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|unique:roles,name,' . $role->id,
        ], [
            'name.required' => "Please Enter Role Name",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $permissions = $request->permissions;
        $name        = $request->name;
        Role::where('id', $role->id)->update(['name' => $name]);

        if ($role && !empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        $this->setMessage('Role Update Successfully', 'success');
        return redirect()->route('admin.role.index');

    }

    public function updateStatus(Request $request) {

        if (!auth_admin_user_permission('role.updateStatus')) {
            abort(403, "Unauthorized Access Role Update Status");
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
            } else {
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

        if (!auth_admin_user_permission('role.delete')) {
            abort(403, "Unauthorized Access Role Delete");
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

        if (!auth_admin_user_permission('role.delete')) {
            abort(403, "Unauthorized Access Role Delete");
        }

        $response = ['error' => 'Error Found'];

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = ['error' => 'Error Found'];
            } else {
                $role = Role::findById($request->role_id, 'admin');

                Role::where('id', $role->id)->delete();

                if ($role) {
                    $response = ['success' => 'Role Delete Update Successfully'];
                } else {
                    $response = ['error' => 'Database Error Found'];
                }

            }

        }

        return response()->json($response);
    }

}
