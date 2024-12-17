<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomerLedgerExport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;

class CustomerLedgerController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $customerId = $request->input('customer_id');

        if ($fromDate !== null || $toDate !== null || $customerId !== null) {
            
           
            $ledgerData = $this->fetchLedgerEntries($fromDate, $toDate, $customerId);
            $ledgerEntries = $ledgerData['sales'];
            $setOpeningAmount = $ledgerData['previous_balance'];
            $data               = [];
            $data['main_menu']  = 'setting';
            $data['child_menu'] = 'customerLedger';
            $data['page_title'] = 'Customer Ledger';
            $data['fromDate'] = $fromDate;
            $data['ledgerEntries'] = $ledgerEntries;
            $data['setOpeningAmount'] = $setOpeningAmount;
            $data['customers'] = Customer::all();
            return view('admin.customer_ledger.index', $data);
        } else {
            
            $ledgerEntries = null;
            $data               = [];
            $data['main_menu']  = 'setting';
            $data['child_menu'] = 'customerLedger';
            $data['page_title'] = 'Customer Ledger';
            $data['ledgerEntries'] = $ledgerEntries;
            $data['customers'] = Customer::all();
            return view('admin.customer_ledger.index', $data);
        }
    }

    public function fetchLedgerEntries($from_date, $to_date, $customerId)
    {
        $sales = Sale::select('id', 'date', 'final_amount as amount', 'bill_no as v_no','created_at')
                ->when($from_date, function ($query) use ($from_date) {
                    return $query->whereDate('created_at', '>=', $from_date);
                })
                ->when($to_date, function ($query) use ($to_date) {
                    return $query->whereDate('created_at', '<=', $to_date);
                })
                ->where('customer_id',$customerId)
                ->get()
                ->map(function ($sale) {
                    $sale->type = 'sale';
                    $sale->debit = $sale->amount;
                    $sale->credit = 0;
                    return $sale;
                });

                $payments = Payment::select('id', 'payment_date as date', 'pay_amount as amount', 'voucher_number as v_no','created_at')
                ->when($from_date, function ($query) use ($from_date) {
                    return $query->whereDate('created_at', '>=', $from_date);
                })
                ->when($to_date, function ($query) use ($to_date) {
                    return $query->whereDate('created_at', '<=', $to_date);
                })
                ->where('customer_id',$customerId)
                ->get()
                ->map(function ($payment) {
                    $payment->type = 'payment';
                    $payment->debit = 0;
                    $payment->credit = $payment->amount;
                    return $payment;
                });
                $sales = json_decode(json_encode($sales), true);
                $payments = json_decode(json_encode($payments), true);

                $sales = array_merge($sales, $payments);

                usort($sales, function ($a, $b) {
                    return new DateTime($a['date']) <=> new DateTime($b['date']);
                });

            $balance = 0;
            if ($from_date) {
                $initialIncome = Sale::whereDate('created_at', '<', $from_date)
                ->where('customer_id',$customerId)
                ->sum('final_amount');
                $initialExpense = Payment::whereDate('created_at', '<', $from_date)
                ->where('customer_id',$customerId)
                ->sum('pay_amount');
                $balance = $initialIncome - $initialExpense;
            }

           
            return [
                'sales' => $sales,
                'previous_balance' => $balance,
            ];
    }

    public function excel(Request $request){
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $customerId = $request->input('customer_id');
        // dd($fromDate, $toDate, $customerId);
        
        if($fromDate !==null || $toDate !==null || $customerId !==null){
            
            $ledgerData = $this->fetchLedgerEntries($fromDate, $toDate, $customerId);
            $ledgerEntries = $ledgerData['sales'];
            $setOpeningAmount = $ledgerData['previous_balance'];
            $fileName='Customer_ledger_'. now()->format('Y-m-d_His') . '.xlsx';
            return Excel::download(new CustomerLedgerExport($ledgerEntries,$setOpeningAmount), $fileName);
        }
    } 
    public function pdf(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $customerId = $request->input('customer_id');
        
        if ($fromDate !== null || $toDate !== null || $customerId !== null) {
            $ledgerData = $this->fetchLedgerEntries($fromDate, $toDate, $customerId);
            $ledgerEntries = $ledgerData['sales'];
            $setOpeningAmount = $ledgerData['previous_balance'];
            $customers=Customer::all();
            // Combine all data into a single array
            $data = [
                'ledgerEntries' => $ledgerEntries,
                'setOpeningAmount' => $setOpeningAmount,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'customers' => $customers,
            ];
    
            // Pass the combined data array to the view
            $pdf = Pdf::loadView('admin.customer_ledger.pdf', $data);
            return $pdf->download('Ledger_' . now()->format('Ymd_His') . '.pdf');
        }
    }
    
    public function print(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $customerId = $request->input('customer_id');
        
        if ($fromDate !== null || $toDate !== null || $customerId !== null) {
            $ledgerData = $this->fetchLedgerEntries($fromDate, $toDate, $customerId);
            $ledgerEntries = $ledgerData['sales'];
            $setOpeningAmount = $ledgerData['previous_balance'];
            $customers=Customer::all();
            // Combine all data into a single array
            $data = [
                'ledgerEntries' => $ledgerEntries,
                'setOpeningAmount' => $setOpeningAmount,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'customers' => $customers,
            ];
    
            // // Pass the combined data array to the view
            // $pdf = Pdf::loadView('admin.customer_ledger.print', $data);
            // return $pdf->download('Ledger_' . now()->format('Ymd_His') . '.pdf');

            return view('admin.customer_ledger.print',$data);
        }
    }
    
}
