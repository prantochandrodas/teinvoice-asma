<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{


    public function getPermissionsByGuard(Request $request)
    {
        if($request->ajax()) {
            $permissions = Permission::where('guard_name', $request->get('guard_name'))->get();
            return view('admin.permission.filterListByGuard', compact('permissions'));
        }
    }
}
