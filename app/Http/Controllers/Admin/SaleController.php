<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Application;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Sale;
use App\Services\SaleService;
use Cart;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class SaleController extends Controller {

    /** Add Cart Item */
    public function addCartSaleItem(Request $request) {

        if ($request->ajax()) {
            $user_id      = $this->userId();
            $easy_sale_id = $request->easy_sale_id;
            $item_id      = $request->item_id;

            $item = Item::with('stock_item')->whereHas('easy_sale_item', function ($query) use ($easy_sale_id) {
                $query->where('id', $easy_sale_id);
            })
                ->orWhere('id', $item_id)
                ->first();

            if ($item) {
                $cart_flag = 0;

                $previous_cart = Cart::session($this->userId())->getContent();

                if (!$previous_cart->isEmpty()) {

                    foreach ($previous_cart as $v_item) {

                        if ($v_item->id == $item->id) {

                            Cart::session($this->userId())->update($item->id, [
                                'quantity' => [
                                    'relative' => false,
                                    'value'    => 1 + $v_item->quantity,
                                ],
                            ]);
                            $cart_flag = 1;
                        }

                    }

                }

                if ($cart_flag == 0) {
                    $unit_cost = $item->stock_item ? $item->stock_item->unit_cost : 0;
                    \Cart::session($this->userId())->add([
                        'id'              => $item->id,
                        'name'            => $item->name,
                        'price'           => $item->price,
                        'quantity'        => 1,
                        'attributes'      => [
                            'unit_cost' => $item->purchase_price,
                        ],
                        'associatedModel' => $item,
                    ]);
                }

            }

            $cart      = \Cart::session($this->userId())->getContent()->sortBy('id');
            $totalItem = \Cart::session($this->userId())->getTotalQuantity();
            $getTotal  = \Cart::session($this->userId())->getTotal();

            $data = [
                'cart'      => $cart,
                'totalItem' => $totalItem,
                'getTotal'  => $getTotal,
                'user_id'   => $user_id,
            ];

            return view('admin.sale.saleCartItem', $data);
        }

    }

    /** Add Cart Item via barcode */
    public function addCartSaleItemBarcode(Request $request) {

        if ($request->ajax()) {

            $user_id = $this->userId();
            $code    = $request->bar_code;

            $item = Item::with('stock_item')->where('code', $code)->first();

            if ($item) {
                $cart_flag = 0;

                $previous_cart = Cart::session($this->userId())->getContent();

                if (!$previous_cart->isEmpty()) {

                    foreach ($previous_cart as $v_item) {

                        if ($v_item->id == $item->id) {

                            Cart::session($this->userId())->update($item->id, [
                                'quantity' => [
                                    'relative' => false,
                                    'value'    => 1 + $v_item->quantity,
                                ],
                            ]);
                            $cart_flag = 1;
                        }

                    }

                }

                if ($cart_flag == 0) {
                    $unit_cost = $item->stock_item ? $item->stock_item->unit_cost : 0;
                    \Cart::session($this->userId())->add([
                        'id'              => $item->id,
                        'name'            => $item->name,
                        'price'           => $item->price,
                        'quantity'        => 1,
                        'attributes'      => [
                            'unit_cost' => $item->purchase_price,
                        ],
                        'associatedModel' => $item,
                    ]);
                }

            }

            $cart      = \Cart::session($this->userId())->getContent()->sortBy('id');
            $totalItem = \Cart::session($this->userId())->getTotalQuantity();
            $getTotal  = \Cart::session($this->userId())->getTotal();

            $data = [
                'cart'      => $cart,
                'totalItem' => $totalItem,
                'getTotal'  => $getTotal,
                'user_id'   => $user_id,
            ];

            return view('admin.sale.saleCartItem', $data);
        }

    }

    /** Add Other Cart Item */
    public function addCartOtherSaleItem(Request $request) {

        if ($request->ajax()) {

            $user_id   = $this->userId();
            $random_id = "other" . random_int(0, 9999);

            \Cart::session($this->userId())->add([
                'id'              => $random_id,
                'name'            => "other_item",
                'price'           => 0,
                'quantity'        => 1,
                'attributes'      => [
                    'name'      => '',
                    'unit_cost' => 0,
                ],
                'associatedModel' => [],
            ]);

            $cart      = \Cart::session($this->userId())->getContent()->sortBy('id');
            $totalItem = \Cart::session($this->userId())->getTotalQuantity();
            $getTotal  = \Cart::session($this->userId())->getTotal();

            $data = [
                'cart'      => $cart,
                'totalItem' => $totalItem,
                'getTotal'  => $getTotal,
                'user_id'   => $user_id,
            ];

            return view('admin.sale.saleCartItem', $data);
        }

    }

    /** Remove Cart Item*/
    public function removeCartSaleItem(Request $request) {

        if ($request->ajax()) {
            $user_id = $this->userId();
            $item_id = $request->item_id;

            Cart::session($this->userId())->remove($item_id);

            $cart      = Cart::session($this->userId())->getContent()->sortBy('id');
            $totalItem = Cart::session($this->userId())->getTotalQuantity();
            $getTotal  = Cart::session($this->userId())->getTotal();

            $data = [
                'cart'      => $cart,
                'totalItem' => $totalItem,
                'getTotal'  => $getTotal,
                'user_id'   => $user_id,
            ];

            return view('admin.sale.saleCartItem', $data);
        }

    }

    /** Remove Cart Item*/
    public function deleteAllCartSaleItem(Request $request) {

        if ($request->ajax()) {
            $user_id = $this->userId();
            Cart::session($this->userId())->clearCartConditions();
            Cart::session($this->userId())->clear();

            $cart      = Cart::session($this->userId())->getContent()->sortBy('id');
            $totalItem = Cart::session($this->userId())->getTotalQuantity();
            $getTotal  = Cart::session($this->userId())->getTotal();

            $data = [
                'cart'      => $cart,
                'totalItem' => $totalItem,
                'getTotal'  => $getTotal,
                'user_id'   => $user_id,
            ];

            return view('admin.sale.saleCartItem', $data);
        }

    }

    /** Update Other Item Name */
    public function updateCartSaleItemName(Request $request) {

        if ($request->ajax()) {
            $user_id   = $this->userId();
            $item_id   = $request->item_id;
            $item_name = $request->item_name;

            Cart::session($user_id)->update($item_id, [
                'attributes' => [
                    'name'      => $item_name,
                    'unit_cost' => 0,
                ],
            ]);

            $cart      = Cart::session($this->userId())->getContent()->sortBy('id');
            $totalItem = Cart::session($this->userId())->getTotalQuantity();
            $getTotal  = Cart::session($this->userId())->getTotal();

            $data = [
                'cart'      => $cart,
                'totalItem' => $totalItem,
                'getTotal'  => $getTotal,
                'user_id'   => $user_id,
            ];

            return view('admin.sale.saleCartItem', $data);
        }

    }

    /** Update Other Item Price */
    public function updateCartSaleItemPrice(Request $request) {

        if ($request->ajax()) {
            $user_id    = $this->userId();
            $item_id    = $request->item_id;
            $item_price = $request->item_price;

            Cart::session($user_id)->update($item_id, [
                'price' => $item_price,
            ]);

            $cart      = Cart::session($this->userId())->getContent()->sortBy('id');
            $totalItem = Cart::session($this->userId())->getTotalQuantity();
            $getTotal  = Cart::session($this->userId())->getTotal();

            $data = [
                'cart'      => $cart,
                'totalItem' => $totalItem,
                'getTotal'  => $getTotal,
                'user_id'   => $user_id,
            ];

            return view('admin.sale.saleCartItem', $data);
        }

    }

    /** Update Other Item Price */
    public function updateCartSaleItemQuantity(Request $request) {

        if ($request->ajax()) {
            $user_id       = $this->userId();
            $item_id       = $request->item_id;
            $item_quantity = $request->item_quantity;

            Cart::session($user_id)->update($item_id, [
                'quantity' => [
                    'relative' => false,
                    'value'    => $item_quantity,
                ],
            ]);

            $cart      = Cart::session($this->userId())->getContent()->sortBy('id');
            $totalItem = Cart::session($this->userId())->getTotalQuantity();
            $getTotal  = Cart::session($this->userId())->getTotal();

            $data = [
                'cart'      => $cart,
                'totalItem' => $totalItem,
                'getTotal'  => $getTotal,
                'user_id'   => $user_id,
            ];

            return view('admin.sale.saleCartItem', $data);
        }

    }

    /** Update Other Item Price */
    public function updateCartSaleItemAmount(Request $request) {

        if ($request->ajax()) {
            $user_id    = $this->userId();
            $item_id    = $request->item_id;
            $item_price = $request->item_amount / $request->quantity;

            Cart::session($user_id)->update($item_id, [
                'price' => $item_price,
            ]);

            $cart      = Cart::session($this->userId())->getContent()->sortBy('id');
            $totalItem = Cart::session($this->userId())->getTotalQuantity();
            $getTotal  = Cart::session($this->userId())->getTotal();

            $data = [
                'cart'      => $cart,
                'totalItem' => $totalItem,
                'getTotal'  => $getTotal,
                'user_id'   => $user_id,
            ];

            return view('admin.sale.saleCartItem', $data);
        }

    }

    public function store(Request $request) {


        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'bill_type'        => 'sometimes',
            'bill_no'          => 'sometimes',
            'bill_date'        => 'required',
            'branch_id'        => 'required',
            'subtotal_amount'  => 'required',
            'total_item'       => 'required',
            'discount_amount'  => 'required',
            'total_tax_amount' => 'required',
            'total_amount'     => 'required',
            'pay_amount'     => 'required',
            'customer_id'      => 'sometimes',
            'note'             => 'sometimes',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        \DB::beginTransaction();
        try {

            $admin_id = auth()->guard('admin')->user()->id;

            $customer_id     = $request->input('customer_id');
            $customer_name   = $request->input('customer_name');
            $customer_vat_no = $request->input('customer_vat_no');
            $duePayment = $request->input('due_payment');

            if ($customer_id == '0' && !empty($customer_name) && !empty($customer_vat_no)) {
                $customer_id = Customer::create([
                    'name'             => $request->input('customer_name'),
                    'email'            => $request->input('customer_email'),
                    'phone'            => $request->input('customer_phone'),
                    'vat_no'           => $request->input('customer_vat_no'),
                    'address'          => $request->input('customer_address'),
                    'due_payment'      => $request->input('due_payment'),
                    'created_admin_id' => $admin_id,
                ])->id;
            }elseif($customer_id !== '0'){
                $updateCustomer=Customer::find($customer_id);
                $newDuePayment=$updateCustomer->due_payment + $duePayment;
                $updateCustomer->update([
                    'due_payment' => $newDuePayment
                ]);
            }

            /**
             * Sale Master Data Set
             */
            $sale_data = [
                'date'             => $request->input('bill_date'),
                'time'             => date('H:i:s'),
                'bill_no'          => $this->returnUniqueSaleBillNo(),
                'bill_type'        => $request->input('bill_type'),
                'customer_id'      => $customer_id,
                'branch_id'      => $request->input('branch_id'),
                'note'             => $request->input('note'),
                'total_quantity'   => $request->input('total_item'),
                'grand_amount'     => $request->input('subtotal_amount'),
                'discount_amount'  => $request->input('discount_amount'),
                'due_payment'      => $request->input('due_payment'),
                'tax_amount'       => $request->input('total_tax_amount'),
                'final_amount'     => $request->input('total_amount'),
                'total_unit_cost'  => $request->input('total_unit_cost'),
                'payment_type'     => $request->input('payment_type'),
                'created_admin_id' => $admin_id,
            ];

            
            $sale = Sale::create($sale_data);

            
            $ref = Payment::latest()->first();

            if ($ref) {
                $invoice_no = 'PAY_00' . $ref->id + 1;
            } else {
                $invoice_no = 'PAY_00';
            }
            $payment_data=[
                'sale_id' => $sale->id,
                'customer_id' => $customer_id,
                'payment_type' => $request->input('payment_type'),
                'type' => 1,
                'voucher_number' => $invoice_no,
                'pay_amount' => $request->input('pay_amount'),
                'payment_date' => Carbon::today()->toDateString(),
            ];
             Payment::create($payment_data);
           
           
             if ($sale) {

                /**
                 * Sale Details
                 */
                $data = [
                    'sale'     => $sale,
                    'admin_id' => $admin_id,
                ];
                (new SaleService)->insert_sale_details($data);

                \DB::commit();
                $this->setMessage('Sale  Successfully', 'success');

                if ($request->input('btn') == 'print') {
                    return redirect()->route('admin.sale.salePrint', [$sale->id, 2]);
                }

                return redirect()->route('admin.sale.salePrint', $sale->id);

                // return redirect()->route('admin.home');
            } else {
                $this->setMessage('Sale  Failed', 'danger');
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            \DB::rollback();
            $this->setMessage('Database Error', 'danger');
            return redirect()->back()->withInput();
        }

    }

    public function salePrint(Request $request, Sale $sale, $type = 0) {
        $sale->load([
            'customer',
            'sale_details.item',
            'created_admin',
        ]);
        $application = Application::first();

        $generatedString = GenerateQrCode::fromArray([
            new Seller($application->name), // seller name
            new TaxNumber($application->vat_number), // seller tax number
            new InvoiceDate(date('Y-m-d', strtotime($sale->date)) . date(' H:i:s', strtotime($sale->time))),
            new InvoiceTotalAmount($sale->grand_amount), // invoice total amount
            new InvoiceTaxAmount($sale->tax_amount),
        ])->render();

        $page_title     = 'Print Booking Parcel';
        $previous_route = url()->previous();
        // dd($sale);

        return view('admin.sale.salePrint', compact('sale', 'page_title', 'previous_route', 'type', 'generatedString'));
    }

    public function printPreview(Request $request) {

        $application = Application::first();

        $generatedString = GenerateQrCode::fromArray([
            new Seller($application->name), // seller name
            new TaxNumber($application->vat_number), // seller tax number
            new InvoiceDate(date('Y-m-d H:i:s')),
            new InvoiceTotalAmount($request->input('total_amount')), // invoice total amount
            new InvoiceTaxAmount($request->input('total_tax_amount')),
        ])->render();

        $cart      = \Cart::session($this->userId())->getContent()->sortBy('id');
        $totalItem = \Cart::session($this->userId())->getTotalQuantity();
        $getTotal  = \Cart::session($this->userId())->getTotal();
        $user_id   = $this->userId();

        $data = [
            'subtotal_amount'  => $request->input('subtotal_amount'),
            'total_item'       => $request->input('total_item'),
            'discount_amount'  => $request->input('discount_amount'),
            'total_tax_amount' => $request->input('total_tax_amount'),
            'total_amount'     => $request->input('total_amount'),
            'cart'             => $cart,
            'totalItem'        => $totalItem,
            'getTotal'         => $getTotal,
            'user_id'          => $user_id,
            'generatedString'  => $generatedString,
        ];

        return view('admin.sale.salePrintPreview', $data);
    }

    public function printPreviewPrint(Request $request) {

        $application = Application::first();

        $generatedString = GenerateQrCode::fromArray([
            new Seller($application->name), // seller name
            new TaxNumber($application->vat_number), // seller tax number
            new InvoiceDate(date('Y-m-d H:i:s')),
            new InvoiceTotalAmount($request->input('total_amount')), // invoice total amount
            new InvoiceTaxAmount($request->input('total_tax_amount')),
        ])->render();

        $cart      = \Cart::session($this->userId())->getContent()->sortBy('id');
        $totalItem = \Cart::session($this->userId())->getTotalQuantity();
        $getTotal  = \Cart::session($this->userId())->getTotal();
        $user_id   = $this->userId();

        $data = [
            'subtotal_amount'  => $request->input('subtotal_amount'),
            'total_item'       => $request->input('total_item'),
            'discount_amount'  => $request->input('discount_amount'),
            'total_tax_amount' => $request->input('total_tax_amount'),
            'total_amount'     => $request->input('total_amount'),
            'cart'             => $cart,
            'totalItem'        => $totalItem,
            'getTotal'         => $getTotal,
            'user_id'          => $user_id,
            'generatedString'  => $generatedString,
        ];

        return view('admin.sale.salePrintPreviewPrint', $data);
    }

    public function searchBill(Request $request) {

        if ($request->ajax()) {
            $sale = Sale::where('bill_no', $request->search_bill)
                ->select('id')
                ->first();
            return response()->json($sale);
        }

        return response()->json([]);

    }

    public function list(Request $request) {
        $data = [];

        $data['main_menu']  = 'booking';
        $data['child_menu'] = 'bookingParcellist';
        $data['page_title'] = 'Sales  List';
        $data['customers']  = Customer::active()->get();
        $data['branches']  = Branch::where('active_status',1)->get();

        return view('admin.sale.saleList', $data);
    }

    public function getList(Request $request) {

        $model = Sale::with(['sale_details'])
            ->where(function ($query) use ($request) {
                $payment = $request->input('payment');
                $branch = $request->input('branch_name');
                $customer_id = $request->input('customer_id');
                $from_date   = $request->input('from_date');
                $to_date     = $request->input('to_date');
                if($branch){
                    $query->where('branch_id', $branch);
                }
                if($payment){
                    $query->where('payment_type', $payment);
                }
                if ($request->has('customer_id') && !is_null($customer_id) && $customer_id != '') {
                    $query->where('customer_id', $customer_id);
                }

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

            ->editColumn('date', function ($data) {
                return date('d-m-Y', strtotime($data->date));
            })
            ->addColumn('total_purchase_tax', function ($data) {
                return '0.00';
            })
            ->addColumn('total_purchase_final_amount', function ($data) {
                return number_format($data->total_unit_cost, 2);
            })
            ->editColumn('total_unit_cost', function ($data) {
                return number_format($data->total_unit_cost, 2);
            })
            ->editColumn('total_quantity', function ($data) {
                return number_format($data->total_quantity, 2);
            })
            ->editColumn('grand_amount', function ($data) {
                return number_format($data->grand_amount, 2);
            })
            ->editColumn('discount_amount', function ($data) {
                return number_format($data->discount_amount, 2);
            })
            ->editColumn('tax_amount', function ($data) {
                return number_format($data->tax_amount, 2);
            })
            ->editColumn('final_amount', function ($data) {
                return number_format($data->final_amount, 2);
            })
            ->addColumn('action', function ($data) {
                $button = '<a href="' . route('admin.sale.salePrint', [$data->id, 1]) . '" class="btn btn-success btn-sm" title="Print Sale Item"
                        target="_blank">
                    <i class="fas fa-print"></i>
                    </a>';
                $button .= '&nbsp; <button class="btn btn-secondary btn-sm view-modal" data-toggle="modal" data-target="#viewModal"
                        sale_id="' . $data->id . '" >
                    <i class="fa fa-eye"></i>
                    </button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->with('total_quantity', $model->sum('total_quantity'))
            ->with('total_grand_amount', $model->sum('grand_amount'))
            ->with('total_discount_amount', $model->sum('discount_amount'))
            ->with('total_tax_amount', $model->sum('tax_amount'))
            ->with('total_final_amount', $model->sum('final_amount'))
            ->with('total_unit_cost', $model->sum('total_unit_cost'))
            ->make(true);
    }

    public function printAll(Request $request) {
        $from_date = $request->input('from_date');
        $to_date   = $request->input('to_date');

        $sales = Sale::with(['sale_details'])
            ->where(function ($query) use ($request, $from_date, $to_date) {
                $customer_id = $request->input('customer_id');

                if ($request->has('customer_id') && !is_null($customer_id) && $customer_id != '') {
                    $query->where('customer_id', $customer_id);
                }

                if ($request->has('from_date') && !is_null($from_date) && $from_date != '') {
                    $query->where('date', '>=', $from_date);
                }

                if ($request->has('to_date') && !is_null($to_date) && $to_date != '') {
                    $query->where('date', '<=', $to_date);
                }

            })
            ->orderBy('id', 'desc')
            ->get();
        $from_date = $request->input('from_date') ?? date('Y-m-d');
        $to_date   = $request->input('to_date') ?? date('Y-m-d');

        return view('admin.sale.allSalePrint', compact('sales', 'from_date', 'to_date'));
    }

    public function oldList(Request $request) {
        $data = [];

        $data['main_menu']  = 'booking';
        $data['child_menu'] = 'bookingParcellist';
        $data['page_title'] = 'Booking Parcel List';
        $data['customers']  = Customer::active()->get();

        return view('admin.sale.saleList', $data);
    }

    public function oldGetList(Request $request) {

        $model = Sale::with(['sale_details'])
            ->where(function ($query) use ($request) {
                $customer_id = $request->input('customer_id');
                $from_date   = $request->input('from_date');
                $to_date     = $request->input('to_date');

                if ($request->has('customer_id') && !is_null($customer_id) && $customer_id != '') {
                    $query->where('customer_id', $customer_id);
                }

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

            ->editColumn('date', function ($data) {
                return date('d-m-Y', strtotime($data->date));
            })
            ->editColumn('total_quantity', function ($data) {
                return number_format($data->total_quantity, 2);
            })
            ->editColumn('grand_amount', function ($data) {
                return number_format($data->grand_amount, 2);
            })
            ->editColumn('discount_amount', function ($data) {
                return number_format($data->discount_amount, 2);
            })
            ->editColumn('tax_amount', function ($data) {
                return number_format($data->tax_amount, 2);
            })
            ->editColumn('final_amount', function ($data) {
                return number_format($data->final_amount, 2);
            })
            ->addColumn('action', function ($data) {
                $button = '<a href="' . route('admin.sale.salePrint', [$data->id, 1]) . '" class="btn btn-success btn-sm" title="Print Sale Item"
                        target="_blank">
                    <i class="fas fa-print"></i>
                    </a>';
                $button .= '&nbsp; <button class="btn btn-secondary btn-sm view-modal" data-toggle="modal" data-target="#viewModal" booking_id="' . $data->id . '" >
                    <i class="fa fa-eye"></i>
                    </button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->with('total_quantity', $model->sum('total_quantity'))
            ->with('total_grand_amount', $model->sum('grand_amount'))
            ->with('total_discount_amount', $model->sum('discount_amount'))
            ->with('total_tax_amount', $model->sum('tax_amount'))
            ->with('total_final_amount', $model->sum('final_amount'))
            ->make(true);
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
