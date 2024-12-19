<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;
class DuePaymenController extends Controller
{
    public function index()
    {

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'DuePayment';
        $data['page_title'] = 'Due Payment';
        $data['customers'] = Customer::where('due_payment', '>', 0)
            ->orderBy('due_payment', 'desc')
            ->get();
        return view('admin.due_payment.index', $data);
    }

    public function getDuePayment($id)
    {
        $customer = Customer::find($id); // Assuming `Customer` is the model for the customers table

        if ($customer) {
            return response()->json(['due_payment' => $customer->due_payment]);
        } else {
            return response()->json(['error' => 'Customer not found'], 404);
        }
    }

    public function adjustment(Request $request)
    {
       
        
        $request->validate([
            'customer_id' => 'required|string',
            'pay_amount' => 'required|numeric|min:0.01',
            'payment_type' => 'required',
        ]);

        $customer = Customer::find($request->customer_id);
        // Check if the pay_amount is greater than the current due_payment
        if ($customer->due_payment < $request->pay_amount) {
            $this->setMessage('The payment amount cannot be greater than the due payment.', 'danger');
            return back();
        }
       
        $newDuePayment = $customer->due_payment - $request->pay_amount;

        $customer->update([
            'due_payment' => $newDuePayment,
        ]);

        $ref = Payment::latest()->first();

        if ($ref) {
            $invoice_no = 'PAY_00' . ($ref->id + 1);
        } else {
            $invoice_no = 'PAY_001';
        }
        $payment_data=[
            'payment_type' => $request->input('payment_type'),
            'customer_id' => $request->input('customer_id'),
            'type' => 2,
            'voucher_number' => $invoice_no,
            'pay_amount' => $request->input('pay_amount'),
            'payment_date' => Carbon::today()->toDateString(),
        ];
        $data= Payment::create($payment_data);
        // $this->setMessage('payment Done.', 'success');
        // return redirect()->route('admin.due-payment.index');
        // $data = Payment::with(['saleInfo', 'customer'])->find($id);
        $type = 0;
        $previous_route = url()->previous();
        return view('admin.sales_payment_list.print', compact('data','type','previous_route'));
    }

}
