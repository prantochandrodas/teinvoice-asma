<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\EasySaleItem;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;

class EasySaleItemController extends Controller {


    /** For Logout */
    public function easySaleUpdate() {

        $validator = Validator::make(request()->all(), [
            'easy_sale_id' => 'required',
            'item_id'      => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = [
            'item_id'          => request()->input('item_id'),
            'updated_admin_id' => auth()->guard('admin')->user()->id,
        ];

        $check = EasySaleItem::where('id', request()->input('easy_sale_id'))->update($data) ? true : false;

        if ($check) {
            $this->setMessage('Easy Sale Item Update Successfully', 'success');
            return redirect()->route('admin.home');
        } else {
            $this->setMessage('Easy Sale Item Update Failed', 'danger');
            return redirect()->back()->withInput();
        }

    }


}
