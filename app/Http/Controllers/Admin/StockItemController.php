<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RawMaterialCategory;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Unit;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Models\Fund;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\StockRawMaterialItem;
use App\Models\SupplierPayment;

use function PHPUnit\Framework\isNull;
use App\Models\StockItem;

class StockItemController extends Controller {


    public function index() {
        if (!auth_admin_user_permission('stockItem.view')) {
            abort(403, "Unauthorized Access Stock Item List to view");
        }

        $data              = [];
        $data['main_menu']  = 'stock';
        $data['child_menu'] = 'stockRawMaterialItem';
        $data['page_title'] = 'Stock Raw Material Item List';
        $data['collapse']   = 'sidebar-collapse';
        $data['items']      = Item::where(['status' => 1])->get();
        return view('admin.stock.stockItem', $data);
    }


    public function getStockItem(Request $request) {

        if (!auth_admin_user_permission('stockItem.view')) {
            abort(403, "Unauthorized Access Stock Item List to view");
        }

        $model = StockItem::with(['item'])
                    ->where(function($query) use ($request){
                        $item_id     = $request->input('item_id');
                        if(!is_null($item_id) ){
                            if(!is_null($item_id) && $item_id != 0){
                                $query->where('item_id', $item_id);
                            }
                        }
                    })
                    ->select();



        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('quantity', function($data){
                return (float) $data->quantity;
            })
            ->editColumn('unit_cost', function($data){
                return number_format($data->unit_cost, 2);
            })
            ->editColumn('amount', function($data){
                return number_format($data->amount, 2);
            })
            ->with('total_stock_amount', $model->sum(\DB::raw('quantity * unit_cost')))
            ->with('total_quantity', $model->sum('quantity'))
            ->make(true);
    }


    public function printAll(Request $request) {

        $stockItems = StockItem::with(['item'])
            ->where(function($query) use ($request){
                $item_id     = $request->input('item_id');
                if(!is_null($item_id) ){
                    if(!is_null($item_id) && $item_id != 0){
                        $query->where('item_id', $item_id);
                    }
                }
            })
            ->orderBy('id', 'desc')
            ->get();


        return view('admin.stock.allStockItemPrint', compact('stockItems'));
    }




}
