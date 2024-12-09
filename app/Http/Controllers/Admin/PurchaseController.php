<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use App\Models\Item;
use App\Models\Ledger;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Category;
use App\Models\PurchaseItem;
use App\Models\StockItem;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PurchaseService;

class PurchaseController extends Controller {

    public function index() {
        if (!auth_admin_user_permission('purchase.create')) {
            abort(403, "Unauthorized Access Purchase Create to view");
        }

        $admin_id = auth()->guard('admin')->user()->id;
        \Cart::session($admin_id)->clear();
        $data                          = [];
        $data['main_menu']             = 'purchase';
        $data['child_menu']            = 'purchase';
        $data['page_title']            = 'Purchase Raw Material';
        $data['collapse']              = 'sidebar-collapse';
        $data['suppliers']             = Supplier::active()->get();
        $data['items']                  = Item::active()->get();
        return view('admin.purchase.purchase.purchaseForm', $data);
    }

    public function returnPurchaseItem(Request $request) {
        $data                     = [];
        $data['items'] = Item::active()
            ->where(function ($query) use ($request) {
                $item_name   = $request->item_name;

                if (!empty($item_name)) {
                    $query->where("name", "LIKE", "%{$item_name}%");
                    $query->orWhere("code", "LIKE", "%{$item_name}%");
                }
            })
            ->get();
        return view('admin.purchase.purchase.purchaseItem', $data);
    }

    public function purchaseItemAddCart(Request $request) {
        $admin_id             = auth()->guard('admin')->user()->id;
        $item_id = $request->input('item_id');
        $item_quantity        = $request->input('item_quantity');
        $item_price           = $request->input('item_price');

        $item = Item::active()
            ->where(['id' => $item_id])
            ->first();

        if ($item) {
            $cart = \Cart::session($admin_id)->getContent();
            $cart = $cart->sortBy('id');

            \Cart::session($admin_id)->add([
                'id'              => $item_id,
                'name'            => $item->name,
                'price'           => $item_price,
                'quantity'        => $item_quantity,
                'target'          => 'subtotal',
                'attributes'      => [],
                'associatedModel' => $item,
            ]);

            $cart      = \Cart::session($admin_id)->getContent();
            $cart      = $cart->sortBy('id');
            $totalItem = \Cart::session($admin_id)->getTotalQuantity();
            $getTotal  = \Cart::session($admin_id)->getTotal();
            $data      = [
                'cart'      => $cart,
                'totalItem' => $totalItem,
                'getTotal'  => $getTotal,
            ];
            return view('admin.purchase.purchase.purchaseItemCart', $data);
        }

    }

    public function purchaseItemDeleteCart(Request $request) {
        $admin_id = auth()->guard('admin')->user()->id;
        \Cart::session($admin_id)->remove($request->input('itemId'));

        $cart = \Cart::session($admin_id)->getContent();
        $cart = $cart->sortBy('id');

        $data = [
            'cart'      => $cart,
            'totalItem' => \Cart::session($admin_id)->getTotalQuantity(),
            'getTotal'  => \Cart::session($admin_id)->getTotal(),
            'error'     => "",
        ];
        return view('admin.purchase.purchase.purchaseItemCart', $data);
    }


    public function purchaseItemQtyUpdateCart(Request $request) {
        $admin_id = auth()->guard('admin')->user()->id;

        \Cart::session($admin_id)->update($request->input('itemId'), [
            'quantity' => [
                'relative' => false,
                'value'    => $request->input('quantity'),
            ],
        ]);

        $cart = \Cart::session($admin_id)->getContent();
        $cart = $cart->sortBy('id');

        $data = [
            'cart'      => $cart,
            'totalItem' => \Cart::session($admin_id)->getTotalQuantity(),
            'getTotal'  => \Cart::session($admin_id)->getTotal(),
            'error'     => "",
        ];
        return view('admin.purchase.purchase.purchaseItemCart', $data);
    }



    public function purchaseItemPriceUpdateCart(Request $request) {
        $admin_id = auth()->guard('admin')->user()->id;

        \Cart::session($admin_id)->update($request->input('itemId'), [
            'price' => $request->input('price'),
        ]);

        $cart = \Cart::session($admin_id)->getContent();
        $cart = $cart->sortBy('id');

        $data = [
            'cart'      => $cart,
            'totalItem' => \Cart::session($admin_id)->getTotalQuantity(),
            'getTotal'  => \Cart::session($admin_id)->getTotal(),
            'error'     => "",
        ];
        return view('admin.purchase.purchase.purchaseItemCart', $data);
    }


    public function store(Request $request) {
        if (!auth_admin_user_permission('purchase.create')) {
            abort(403, "Unauthorized Access Purchase Create to view");
        }

        $validator = Validator::make($request->all(), [
            'total_item'                          => 'required',
            'invoice_no'                          => 'sometimes',
            'date'                                => 'required',
            'supplier_id'                         => 'sometimes',
            'note'                                => 'sometimes',
            'confirm_total_purchase_amount'       => 'required',
            'discount_amount'                     => 'required',
            'confirm_total_purchase_final_amount' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }


        \DB::beginTransaction();
        try {
            $admin_id = auth()->guard('admin')->user()->id;

            $date        = $request->input('date');
            $supplier_id = $request->input('supplier_id');


            $purchase_data = [
                'invoice_no'              => $request->input('invoice_no'),
                'date'                    => $request->input('date'),
                'time'                    => date('H:i:s'),
                'supplier_id'             => $supplier_id,
                'total_quantity'          => $request->input('total_item'),
                'grand_amount'            => $request->input('confirm_total_purchase_amount'),
                'discount_amount'         => $request->input('discount_amount'),
                'final_amount'            => $request->input('confirm_total_purchase_final_amount'),
                'note'                    => $request->input('note'),
                'created_admin_id'        => $admin_id,
            ];
            $purchase = Purchase::create($purchase_data);

            if ($purchase) {

                $data = [
                    'purchase_id'       => $purchase->id,
                    'admin_id'          => $admin_id,
                ];
                (new PurchaseService)->insert_purchase_items_and_update_stock($data);



                \DB::commit();
                $this->setMessage('Purchase  Successfully', 'success');
                return redirect()->route('admin.purchase.purchaseList');
            } else {
                \DB::rollback();
                $this->setMessage('Purchase  Failed', 'danger');
                return redirect()->back()->withInput();
            }

        } catch (\Exception$e) {
            \DB::rollback();
            $this->setMessage('Database Error', 'danger');
            return redirect()->back()->withInput();
        }

    }




    public function purchaseList() {
        if (!auth_admin_user_permission('purchase.list')) {
            abort(403, "Unauthorized Access Purchase List to view");
        }

        $data               = [];
        $data['main_menu']  = 'purchase';
        $data['child_menu'] = 'purchaseList';
        $data['page_title'] = 'Purchase List';
        $data['collapse']   = 'sidebar-collapse';
        $data['suppliers']  = Supplier::where(['status' => 1])->get();
        return view('admin.purchase.purchaseList', $data);
    }

    public function getPurchaseList(Request $request) {

        if (!auth_admin_user_permission('purchase.list')) {
            abort(403, "Unauthorized Access Purchase List to view");
        }

        $model = Purchase::with(['supplier:id,name'])
            ->where(function ($query) use ($request) {
                $supplier_id = $request->input('supplier_id');
                $invoice_no  = $request->input('invoice_no');
                $from_date   = $request->input('from_date');
                $to_date     = $request->input('to_date');

                if (!is_null($supplier_id) || !is_null($invoice_no) || !is_null($from_date) || !is_null($to_date)) {

                    if (!is_null($supplier_id) && $supplier_id != 0) {
                        $query->where('supplier_id', $supplier_id);
                    }

                    if (!is_null($invoice_no)) {
                        $query->where('invoice_no', 'like', "%$invoice_no%");
                    }

                    if (!is_null($from_date)) {
                        $query->where('date', '>=', $from_date);
                    }

                    if (!is_null($to_date)) {
                        $query->where('date', '<=', $to_date);
                    }

                }

            })
            ->select();

        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = "";
                if (auth_admin_user_permission('purchase.view')) {
                    $button .= '<button class="btn btn-secondary view-modal" data-toggle="modal" data-target="#viewModal" purchase_id="' . $data->id . '}" >
                        <i class="fa fa-eye"></i> </button>';
                }
                if (auth_admin_user_permission('purchase.edit')) {
                    $button .= '&nbsp;&nbsp;&nbsp; <a href="' . route('admin.purchase.edit', $data->id) . '" class="btn btn-success"> <i class="fa fa-edit"></i> </a>';
                }
                if (auth_admin_user_permission('purchase.delete')) {
                    $button .= '&nbsp;&nbsp;&nbsp; <button class="btn btn-danger delete-btn" purchase_id="' . $data->id . '">
                        <i class="fa fa-trash"></i> </button>';
                }
                return $button;
            })
            ->editColumn('date', function ($data) {
                return date('d-m-Y', strtotime($data->date));
            })
            ->editColumn('grand_amount', function ($data) {
                return number_format($data->grand_amount, 2);
            })
            ->editColumn('discount_amount', function ($data) {
                return number_format($data->discount_amount, 2);
            })
            ->editColumn('final_amount', function ($data) {
                return number_format($data->final_amount, 2);
            })
            ->rawColumns(['action'])
            ->with('total_grand_amount', number_format($model->sum('grand_amount')))
            ->with('total_discount_amount', number_format($model->sum('discount_amount')))
            ->with('total_final_amount', number_format($model->sum('final_amount')))
            ->make(true);
    }

    public function show(Request $request, Purchase $purchase) {
        if (!auth_admin_user_permission('purchase.view')) {
            abort(403, "Unauthorized Access Purchase to view");
        }

        $purchase->load('supplier', 'purchase_items.item');
        return view('admin.purchase.viewPurchase', compact('purchase'));
    }

    public function edit(Request $request, Purchase $purchase) {
        if (!auth_admin_user_permission('purchase.edit')) {
            abort(403, "Unauthorized Access Purchase Edit to view");
        }

        $purchase->load('supplier',  'purchase_items');

        $admin_id = auth()->guard('admin')->user()->id;
        \Cart::session($admin_id)->clear();

        foreach ($purchase->purchase_items as $purchase_item) {
            $item = Item::active()->where(['id' => $purchase_item->item_id])->first();

            if ($item) {
                \Cart::session($admin_id)->add([
                    'id'              => $purchase_item->id,
                    'name'            => $item->name,
                    'price'           => $purchase_item->price,
                    'quantity'        => $purchase_item->quantity,
                    'target'          => 'subtotal',
                    'attributes'      => [],
                    'associatedModel' => $item,
                ]);
            }

        }

        $cart      = \Cart::session($admin_id)->getContent();
        $cart      = $cart->sortBy('id');
        $totalItem = \Cart::session($admin_id)->getTotalQuantity();
        $getTotal  = \Cart::session($admin_id)->getTotal();

        $data                          = [];
        $data['cart']                  = $cart;
        $data['totalItem']             = $totalItem;
        $data['getTotal']              = $getTotal;
        $data['main_menu']             = 'purchase';
        $data['child_menu']            = 'purchase';
        $data['collapse']              = 'sidebar-collapse';
        $data['page_title']            = 'Update Purchase Raw Material';
        $data['suppliers']             = Supplier::where(['status' => 1])->get();
        $data['items']                 = Item::active()->get();
        $data['purchase']              = $purchase;


        return view('admin.purchase.purchase.purchaseEditForm', $data);
    }



    public function update(Request $request, Purchase $purchase) {
        if (!auth_admin_user_permission('purchase.edit')) {
            abort(403, "Unauthorized Access Purchase Edit to view");
        }

        $purchase->load('purchase_items');

        $validator = Validator::make($request->all(), [
            'total_item'                          => 'required',
            'invoice_no'                          => 'sometimes',
            'date'                                => 'required',
            'supplier_id'                         => 'sometimes',
            'note'                                => 'sometimes',
            'confirm_total_purchase_amount'       => 'required',
            'discount_amount'                     => 'required',
            'confirm_total_purchase_final_amount' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        \DB::beginTransaction();
        try {
            $admin_id = auth()->guard('admin')->user()->id;

            $date        = $request->input('date');
            $supplier_id = $request->input('supplier_id');

            $purchase_data = [
                'invoice_no'              => $request->input('invoice_no'),
                'date'                    => $request->input('date'),
                'time'                    => date('H:i:s'),
                'supplier_id'             => $supplier_id,
                'total_quantity'          => $request->input('total_item'),
                'grand_amount'            => $request->input('confirm_total_purchase_amount'),
                'discount_amount'         => $request->input('discount_amount'),
                'final_amount'            => $request->input('confirm_total_purchase_final_amount'),
                'note'                    => $request->input('note'),
                'updated_admin_id'        => $admin_id,
            ];


            $check = Purchase::where('id', $purchase->id)->update($purchase_data);

            if ($check) {

                $data = [
                    'purchase_id'       => $purchase->id,
                    'purchase_items'    => $purchase->purchase_items,
                    'admin_id'          => $admin_id,
                ];
                (new PurchaseService)->delete_purchase_items_and_update_stock($data)
                        ->insert_purchase_items_and_update_stock($data);


                \DB::commit();
                $this->setMessage('Purchase  Successfully', 'success');
                return redirect()->route('admin.purchase.purchaseList');
            } else {
                \DB::rollback();
                $this->setMessage('Purchase  Failed', 'danger');
                return redirect()->back()->withInput();
            }

        } catch (\Exception$e) {
            \DB::rollback();
            $this->setMessage('Database Error', 'danger');
            return redirect()->back()->withInput();
        }

    }

    public function destroy(Request $request, Item $rawMaterialItem) {

        $check = $rawMaterialItem->delete() ? true : false;

        if ($check) {
            $this->setMessage('Raw Material Item Delete Successfully', 'success');
        } else {
            $this->setMessage('Raw Material Item Delete Failed', 'danger');
        }

        return redirect()->route('admin.rawMaterialItem.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete(Request $request) {

        if (!auth_admin_user_permission('purchase.delete')) {
            abort(403, "Unauthorized Access Purchase delete to view");
        }

        $response = ['error' => 'Error Found'];

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'purchase_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = ['error' => 'Error Found'];
            } else {
                $admin_id = auth()->guard('admin')->user()->id;

                $purchase   = Purchase::with('purchase_items')->where('id', $request->purchase_id)->first();
                $check      = Purchase::where('id', $request->purchase_id)->delete() ? true : false;

                if ($check) {
                    $data = [
                        'purchase_id'       => $purchase->id,
                        'purchase_items'    => $purchase->purchase_items,
                        'admin_id'          => $admin_id,
                    ];
                    (new PurchaseService)->delete_purchase_items_and_update_stock($data);


                    PurchaseItem::where('purchase_id', $request->purchase_id)->delete() ? true : false;

                    $response = ['success' => 'Raw Material Item Delete Update Successfully'];
                } else {
                    $response = ['error' => 'Database Error Found'];
                }

            }

        }

        return response()->json($response);
    }

}
