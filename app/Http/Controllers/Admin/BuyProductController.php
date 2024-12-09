<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BuyProduct;
use App\Models\BuyProductDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BuyProductController extends Controller
{
    public function index()
    {
        $data = [];

        $data['main_menu']  = 'booking';
        $data['child_menu'] = 'buy_product_list';
        $data['page_title'] = 'Sales  List';

        return view('admin.buyProduct.index', $data);
    }

    public function getBuyProductListold(Request $request)
    {

        $model = BuyProduct::with(['buyProductDetails'])
            ->where(function ($query) use ($request) {
                $from_date   = $request->input('from_date');
                $to_date     = $request->input('to_date');

                if ($request->has('from_date') && !is_null($from_date) && $from_date != '') {
                    $query->where('date', '>=', $from_date);
                }

                if ($request->has('to_date') && !is_null($to_date) && $to_date != '') {
                    $query->where('date', '<=', $to_date);
                }
            })
            ->orderBy('id', 'desc')
            ->select();
        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = "";
                if (auth_admin_user_permission('item.view')) {
                    $button .= '<button class="btn btn-secondary view-modal" data-toggle="modal" data-target="#viewModal" buy_id="' . $data->id . '" >
                        <i class="fa fa-eye"></i> </button>';
                }
                $button .= '<a href="' . route('admin.buyproduct.Print', [$data->id, 1]) . '" class="btn btn-success ml-1" title="Print Sale Item"
                >
                    <i class="fas fa-print"></i>
                    </a>';
                // if (auth_admin_user_permission('item.edit')) {
                //      $button .= '&nbsp;&nbsp;&nbsp; <a href="' . route('admin.supplier.edit', $data->id) . '" class="btn btn-success"> <i class="fa fa-edit"></i> </a>';
                // }
                if (auth_admin_user_permission('item.delete')) {
                    $button .= '&nbsp;&nbsp;&nbsp; <button   onclick="return confirm(\'Are you sure you want to delete this item?\')"    class="btn btn-danger delete-btn" supplier_id="' . $data->id . '">
                        <i class="fa fa-trash"></i> </button>';
                }
                return $button;
            })

            // ->with('total_balance', number_format($model->sum('balance'),2))
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getBuyProductList(Request $request)
    {

        $model = BuyProductDetail::
            where(function ($query) use ($request) {
                $from_date   = $request->input('from_date');
                $to_date     = $request->input('to_date');

                if ($request->has('from_date') && !is_null($from_date) && $from_date != '') {
                    $query->where('date', '>=', $from_date);
                }

                if ($request->has('to_date') && !is_null($to_date) && $to_date != '') {
                    $query->where('date', '<=', $to_date);
                }
            })
            ->orderBy('id', 'desc')
            ->select();
        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = "";
                // if (auth_admin_user_permission('item.view')) {
                //     $button .= '<button class="btn btn-secondary view-modal" data-toggle="modal" data-target="#viewModal" buy_id="' . $data->id . '" >
                //         <i class="fa fa-eye"></i> </button>';
                // }
                // $button .= '<a href="' . route('admin.buyproduct.Print', [$data->id, 1]) . '" class="btn btn-success ml-1" title="Print Sale Item"
                // >
                //     <i class="fas fa-print"></i>
                //     </a>';
                // if (auth_admin_user_permission('item.edit')) {
                //      $button .= '&nbsp;&nbsp;&nbsp; <a href="' . route('admin.supplier.edit', $data->id) . '" class="btn btn-success"> <i class="fa fa-edit"></i> </a>';
                // }
                if (auth_admin_user_permission('item.delete')) {
                    $button .= '&nbsp;&nbsp;&nbsp; <button   onclick="return confirm(\'Are you sure you want to delete this item?\')"    class="btn btn-danger delete-btn" supplier_id="' . $data->id . '">
                        <i class="fa fa-trash"></i> </button>';
                }
                return $button;
            })

            // ->with('total_balance', number_format($model->sum('balance'),2))
            ->rawColumns(['action'])
            ->with('total_item_buy_bill', $model->sum('item_buy_bill'))
            ->with('total_cost', $model->sum('total_cost'))
            ->make(true);
    }
    public function create()
    {
        $data               = [];
        $data['main_menu']  = 'expenseHead';
        $data['child_menu'] = 'buy-product-entry';
        return view('admin.buyProduct.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'purchase_no' => 'required|array',
            'supplier_name' => 'required|array',
            'item_code' => 'required|array',
            'item_name' => 'required|array',
            'item_buy_bill' => 'required',
            'total_cost' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $total_cost = $request->total_cost;
            $count = count($total_cost);

            $total_item_buy_bill = 0;
            $total_cost_bill = 0;
            $buyNoDatabase = DB::table('buy_products')
                ->select('buy_no')
                ->orderBy('id', 'DESC')
                ->first();;
            if ($buyNoDatabase) {
                $last_buy_no = $buyNoDatabase->buy_no;
                $buy_no_numeric = (int) substr($last_buy_no, 4);
                $buy_no = 'BUY-' . sprintf("%06d", $buy_no_numeric + 1);
            } else {
                $buy_no = 'BUY-000001'; // Default value if no record exists
            }
            for ($i = 0; $i < $count; $i++) {
                $total_item_buy_bill += $request->item_buy_bill[$i];
                $total_cost_bill += $request->total_cost[$i];
            }
            $BuyProductData = [
                'buy_no' => $buy_no,
                'total_item_buy_bill' => $total_item_buy_bill,
                'date' => date('Y-m-d'),
                'total_cost' => $total_cost_bill,
            ];
            $check = BuyProduct::create($BuyProductData);
            $buyProductDetails = [];
            for ($i = 0; $i < $count; $i++) {
                $buyProductDetails[] = [
                    'buy_product_id' => $check->id,
                    'date' => date('Y-m-d'),
                    'purchase_no'    => $request->purchase_no[$i],
                    'supplier_name'    => $request->supplier_name[$i],
                    'item_code'    => $request->item_code[$i],
                    'item_name'    => $request->item_name[$i],
                    'item_buy_bill'    => $request->item_buy_bill[$i],
                    'total_cost'    => $request->total_cost[$i],
                ];
            }
            BuyProductDetail::insert($buyProductDetails);
            DB::commit();
            $this->setMessage('Create Successfully', 'success');
            return redirect()->route('admin.buy-product-entry.index');
        } catch (Exception $e) {
            DB::rollBack();
            $this->setMessage('Create Failed', 'danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=BuyProductDetail::where('buy_product_id',$id)->get();
        return view('admin.buyProduct.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buyProduct = BuyProductDetail::findOrFail($id);

        if ($buyProduct->delete()) {
            return response()->json(['success' => 'Product entry deleted successfully.']);
        }

        return response()->json(['error' => 'Failed to delete product entry.'], 500);
    }
    public function buyproductPrint($id){
        $type=0;
        $previous_route = url()->previous();
        // dd($previous_route);
        $data=BuyProductDetail::where('buy_product_id',$id)->get();
        return view('admin.buyProduct.print',compact('data','type','previous_route'));

    }
    public function buy_product_print(Request $request){
        $buyProductDetails = BuyProductDetail::
            where(function ($query) use ($request) {
                $from_date   = $request->input('from_date');
                $to_date     = $request->input('to_date');

                if ($request->has('from_date') && !is_null($from_date) && $from_date != '') {
                    $query->where('date', '>=', $from_date);
                }

                if ($request->has('to_date') && !is_null($to_date) && $to_date != '') {
                    $query->where('date', '<=', $to_date);
                }
            })
            ->orderBy('id', 'desc')
            ->get();
            $type=0;
            $previous_route = url()->previous();

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.buyProduct.print2', compact('buyProductDetails', 'type','previous_route'))->render()
                ]);
            }
        return view('admin.buyProduct.print2',compact('buyProductDetails','type','previous_route'));
    }
}
