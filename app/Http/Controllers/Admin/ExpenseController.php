<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseHead;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Branch;
class ExpenseController extends Controller
{

   public function index()
    {
        $data               = [];
        $data['main_menu']  = 'expenseHead';
        $data['child_menu'] = 'expenseIndex';
        $data['page_title'] = 'expenseIndex';
        $data['expenseHeads']=ExpenseHead::get();
        $data['expense']=Expense::with('expenseHead')->get();
        $data['branches']=Branch::where('active_status',1)->get();
        return view('admin.expense2.index', $data);
    }
    
    public function create()
    {
        //
    }
      public function expenseGetList(Request $request){
        $model = Expense::with('expenseHead:id,name')->
            where(function ($query) use ($request) {
                $from_date   = $request->input('from_date');
                $to_date     = $request->input('to_date');
                $branch      = $request->input('branch_name');
                // dd($branch);
                if ($request->has('from_date') && !is_null($from_date) && $from_date != '') {
                    $query->where('date', '>=', $from_date);
                }

                if ($request->has('to_date') && !is_null($to_date) && $to_date != '') {
                    $query->where('date', '<=', $to_date);
                }
                if($branch){
                    $query->where('branch_id', $branch);
                }

                // if ($branch) {
                //     $model->when($seed_season, function ($query) use ($seed_season) {
                //         $query->where('season_id', $seed_season);
                //     });
                // }
            })
            ->orderBy('id', 'desc')
            ->get();
            // dd($model);
            
            return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('expense_head_name', function ($data) {
                return $data->expenseHead ? $data->expenseHead->name : '';
            })
            ->addColumn('branch_name', function ($data) {
                return $data->branch ? $data->branch->name : '';
            })
            ->addColumn('action', function ($data) {
                $button = "";
                $deleteUrl = route('admin.expense.destroy', $data->id);
                $csrfToken = csrf_field();
                $method = method_field('DELETE');
                $button .= '<div class="d-inline-flex align-items-center">
                                <button class="btn btn-primary edit-modal mr-2"
                                    type="button" data-bs-toggle="modal"
                                    data-original-title="View"
                                    data-bs-target="#editModal"
                                    expense_id="' . $data->id . '"
                                    title="Edit Expense">
                                    <i class="fa fa-edit"></i>
                                </button>
                               <form action="' . $deleteUrl . '" method="POST" class="m-0">
                                    ' . $csrfToken . '
                                    ' . $method . '
                                    <button onclick="return confirm(\'Are you sure you want to delete this item?\')" 
                                            type="submit" class="btn btn-danger delete-btn">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>';

              
                return $button;
            })
            ->rawColumns(['action'])
            ->with('total_amount', $model->sum('amount'))
            ->make(true);

    }

    public function store(Request $request)
    {
        $request->validate([
          'amount'=>  'required|numeric',
          'expense_head_id'=>  'required|integer',
          'expense_id'=>  'required',

        ]);
        $check=Expense::create($request->except('_token'));
        if ($check) {
            $this->setMessage('Expense Created Successfully', 'success');
            return redirect()->route('admin.expense.index');
        } else {
            $this->setMessage('Expense Create Failed', 'danger');
            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $item = Expense::findOrFail($id);
        $expenseHeads=ExpenseHead::get();
        $branches=Branch::get();
        return view('admin.expense2.edit', compact('item','expenseHeads','branches'));
    }

   public function update(Request $request, $id)
    {
        $request->validate([
            'amount'=>  'required|numeric',
            'expense_head_id'=>  'required|integer',
            'branch_id'=>  'required|integer',
            'expense_id'=>  'required',

          ]);
          $check=Expense::find($id)->update($request->except('_token'));
          if ($check) {
              $this->setMessage('Expense Updated Successfully', 'success');
              return redirect()->route('admin.expense.index');
          } else {
              $this->setMessage('Expense Updated Failed', 'danger');
              return redirect()->back()->withInput();
          }
    }

    public function destroy($id)
    {
        $check=Expense::find($id)->delete();
        if ($check) {
            $this->setMessage('Expense  Deleted Successfully', 'success');
            return redirect()->route('admin.expense.index');
        } else {
            $this->setMessage('Expense Deleted Failed', 'danger');
            return redirect()->back()->withInput();
        }
    }
    function expensePrint(Request $request){
        $expenses = Expense::
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


        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.expense2.print', compact('expenses'))->render()
            ]);
        }
        return view('admin.buyProduct.print2',compact('buyProductDetails','type','previous_route'));

    }
}
