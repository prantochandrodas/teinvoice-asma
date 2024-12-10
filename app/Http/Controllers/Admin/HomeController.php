<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\EasySaleItem;
use App\Models\Item;
use Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;

class HomeController extends Controller {

    public function __construct() {
    }

    public function dashboard() {

        Cart::session($this->userId())->clearCartConditions();
        Cart::session($this->userId())->clear();

        // $locale = app()->getLocale();

        $data                  = [];
        $data['main_menu']     = 'home';
        $data['child_menu']    = 'home';
        $data['page_title']    = 'Home';
        $data['bill_no']       = $this->returnUniqueSaleBillNo();
        $data['easySaleItems'] = EasySaleItem::with('item')->get();
        $data['customers']     = Customer::active()->get();
        $data['items']         = Item::active()->get();
        $data['sales']         = Sale::orderBy('id','desc')->get();
        $data['branches']         =Branch::where('active_status',1)->get();

        return view('admin.dashboard', $data);
    }

    public function logout() {
        auth()->guard('admin')->logout();
        $this->setMessage('Admin Logout Successfully', 'success');
        return redirect()->route('login');
    }

    /** Protected Function */
    protected function userId() {

        if (auth()->guard('admin')->user()) {
            $userId = auth()->guard('admin')->user()->id;
        } else {
            $userId = 0;
        }

        return $userId;
    }

}
