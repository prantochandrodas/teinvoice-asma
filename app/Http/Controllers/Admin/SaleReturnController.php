<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Application;
use App\Models\Customer;
use App\Models\Item;
use App\Models\ReturnSale;
use App\Models\Sale;
use App\Services\ReturnSaleService;
use Cart;
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

class SaleReturnController extends Controller {

    public function returnSale(Sale $sale) {
        $sale->load('sale_details.item', 'customer');

        $data              = [];
        $data['sale']      = $sale;
        $data['customers'] = Customer::active()->get();
        $data['items']     = Item::active()->get();

        if($sale->current_quantity > 0){
            return view('admin.sale.editSale', $data);
        }
        return "No Result found!";
    }

    public function returnSaleConfirm(Request $request, Sale $sale) {

        $validator = Validator::make($request->all(), [
            'bill_date'        => 'required',
            'subtotal_amount'  => 'required',
            'total_item'       => 'required',
            'discount_amount'  => 'required',
            'total_tax_amount' => 'required',
            'total_amount'     => 'required',
            'customer_id'      => 'sometimes',
            'note'             => 'sometimes',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        \DB::beginTransaction();
        try {

            $admin_id       = auth()->guard('admin')->user()->id;
            $customer_id    = $request->input('customer_id');
            $total_quantity = $request->input('return_total_item');
            $grand_amount   = $request->input('return_subtotal_amount');

            /**
             * Return Sale Master Data Set
             */
            $return_sale_data = [
                'date'             => $request->input('bill_date'),
                'return_date'      => $request->input('return_date'),
                'customer_id'      => $customer_id,
                'sale_id'          => $sale->id,
                'note'             => $request->input('note'),
                'total_quantity'   => $total_quantity,
                'grand_amount'     => $grand_amount,
                'created_admin_id' => $admin_id,
            ];
            $returnSale = ReturnSale::create($return_sale_data);

            if ($sale) {

                $return_sale_data = [
                    'return_total_quantity' => \DB::raw("return_total_quantity + $total_quantity"),
                    'return_total_amount'   => \DB::raw("return_total_amount + $grand_amount"),
                    'updated_admin_id'      => $admin_id,
                ];
                Sale::where('id', $sale->id)->update($return_sale_data);

                /**
                 * Sale Details
                 */
                $data = [
                    'sale'       => $sale,
                    'returnSale' => $returnSale,
                    'admin_id'   => $admin_id,
                ];
                (new ReturnSaleService)->insert_return_sale_details($data);

                \DB::commit();
                $this->setMessage('Return Sale  Successfully', 'success');

                return redirect()->route('admin.home');

            } else {
                \DB::rollback();
                $this->setMessage('Return Sale  Failed', 'danger');
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

        return view('admin.sale.saleList', $data);
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
