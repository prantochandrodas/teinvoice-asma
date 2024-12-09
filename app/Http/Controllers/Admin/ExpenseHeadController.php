<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseHead;

class ExpenseHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data               = [];
        $data['main_menu']  = 'expenseHead';
        $data['child_menu'] = 'expenseHeadIndex';
        $data['page_title'] = 'expenseHeadIndex';
        $data['expense_head']=ExpenseHead::all();
        return view('admin.expense.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|string',
        ]);
        $check=ExpenseHead::create($request->except('_token'));
        if ($check) {
            $this->setMessage('Expense Head Created Successfully', 'success');
            return redirect()->route('admin.expense-head.index');
        } else {
            $this->setMessage('Expense Head Create Failed', 'danger');
            return redirect()->back()->withInput();
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
        //
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
        $request->validate([
            'name' =>'required|string',
            'status' =>'required',
        ]);
        $check=ExpenseHead::find($id)->update($request->except('_token'));
        if ($check) {
            $this->setMessage('Expense Head Updated Successfully', 'success');
            return redirect()->route('admin.expense-head.index');
        } else {
            $this->setMessage('Expense Head Updated Failed', 'danger');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check=ExpenseHead::find($id)->delete();
        if ($check) {
            $this->setMessage('Expense Head Deleted Successfully', 'success');
            return redirect()->route('admin.expense-head.index');
        } else {
            $this->setMessage('Expense Head Deleted Failed', 'danger');
            return redirect()->back()->withInput();
        }
    }
}
