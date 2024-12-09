<?php

namespace App\Http\Controllers\Admin;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'branch';
        $data['page_title'] = 'Application ';
        $data['branches']=Branch::get();
        return view('admin.branch.branch.index', $data);
    }

    public function getdata(Request $request){
        $model = Branch::orderBy('id', 'desc')->select();
        return DataTables::of($model)
            ->addIndexColumn()
      
            ->addColumn('action', function ($data) {
                $button = '';
                $deleteUrl = route('admin.branches.distroy', $data->id);
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
            ->make(true);

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'arabic_name' => 'required|string',
            'contact_number' => 'required|string|min:5',
            'email' => 'required|email',
            'address' => 'required|string',
            'vat_number' => 'required',
            'cr_no' => 'required',
        ]);
       
        Branch::create([
            'name' => $request->name,
            'arabic_name' => $request->arabic_name,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'address' => $request->address,
            'vat_number' => $request->vat_number,
            'cr_no' => $request->cr_no,
        ]);
        $this->setMessage('Branch created successfully', 'success');
        return redirect()->route('admin.branches.index');
    }


    public function edit($id)
    {
        $item = Branch::findOrFail($id);
        return view('admin.branch.branch.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string',
            'arabic_name' => 'nullable|string',
            'contact_number' => 'nullable|string|min:5',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'vat_number' => 'nullable',
            'cr_no' => 'nullable',
        ]);
       
        
        $data = Branch::findOrFail($id);
        
        $data->update([
            'name' => $request->input('name'),
            'arabic_name' => $request->input('arabic_name'),
            'contact_number' => $request->input('contact_number'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'vat_number' => $request->input('vat_number'),
            'cr_no' => $request->input('cr_no'),
        ]);
        $this->setMessage('Branch Update Successfully', 'success');
        return redirect()->route('admin.branches.index');
    }

    public function distroy($id)
    {
        $data = Branch::findOrFail($id);
        
        $data->delete();
        $this->setMessage('Branch Deleted Successfully', 'success');
        return redirect()->route('admin.branches.index');
    }
}
