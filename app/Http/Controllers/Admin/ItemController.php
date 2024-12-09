<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller {

    public function index() {

        if (!auth_admin_user_permission('item.list')) {
            abort(403, "Unauthorized Access Item List to view");
        }

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'item';
        $data['page_title'] = 'Items';
        return view('admin.setting.item.index', $data);
    }

    public function barcode(Request $request,$id){
        $data['item'] = Item::find($id);

        return view('admin.setting.item.bar_code', $data);
    }

    public function getItems(Request $request) {

        if (!auth_admin_user_permission('item.list')) {
            abort(403, "Unauthorized Access  Item List to view");
        }

        $model = Item::select();

        return DataTables::of($model)
            ->addIndexColumn()
            ->editColumn('price', function ($data) {
                return number_format($data->price,2);
            })
            ->editColumn('purchase_price', function ($data) {
                return number_format($data->purchase_price,2);
            })
            ->addColumn('full_name', function ($data) {
                return $data->full_name;
            })
            ->addColumn('image', function ($data) {
                $image = "";

                if (!empty($data->image)) {
                    $image = ' <img src="' . asset('uploads/item/' . $data->image) . '"
                                class="img-fluid img-thumbnail"
                                style="height: 55px !important;
                                width: 100px !important;" alt="Customer Photo">';
                }

                return $image;
            })
            ->addColumn('status', function ($data) {

                if ($data->status == 1) {
                    $class = "success"; $status = 0; $status_name =  __('message.active') ;
                } else {
                    $class = "danger"; $status = 1; $status_name =  __('message.inactive') ;
                }

                $updateStatus = auth_admin_user_permission('item.updateStatus') ? "updateStatus" : "";
                return '<a class="' . $updateStatus . ' text-bold text-' . $class . '" href="javascript:void(0)" style="font-size:20px;" item_id="' . $data->id . '" status="' . $status . '"> ' . $status_name . '</a>';

            })
            ->addColumn('action', function ($data) {
                $button = "";
                $button .= '&nbsp;&nbsp;&nbsp; <a href="' . route('admin.item.barcode-print', $data->id) . '" class="btn btn-success" target="_blank"> <i class="fa fa-barcode"></i> </a> &nbsp;&nbsp;&nbsp;';

                if (auth_admin_user_permission('item.view')) {
                    $button .= '<button class="btn btn-secondary view-modal" data-toggle="modal" data-target="#viewModal" item_id="' . $data->id . '}" >
                                    <i class="fa fa-eye"></i> </button>';
                }

                if (auth_admin_user_permission('item.edit')) {
                    $button .= '&nbsp;&nbsp;&nbsp; <a href="' . route('admin.item.edit', $data->id) . '" class="btn btn-success"> <i class="fa fa-edit"></i> </a>';
                }

                if (auth_admin_user_permission('item.delete')) {

                    $button .= '&nbsp;&nbsp;&nbsp; <button class="btn btn-danger delete-btn" item_id="' . $data->id . '">
                        <i class="fa fa-trash"></i> </button>';

                }

                return $button;
            })
            ->rawColumns(['status', 'action', 'image'])
            ->make(true);
    }

    public function create() {

        if (!auth_admin_user_permission('item.create')) {
            abort(403, "Unauthorized Access  Item Create");
        }

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'item';
        $data['page_title'] = 'Create Item';
        return view('admin.setting.item.create', $data);
    }

    public function store(Request $request) {

        if (!auth_admin_user_permission('item.create')) {
            abort(403, "Unauthorized Access Item Create");
        }

        $validator = Validator::make($request->all(), [
            'code'              => 'required|min:3|max:30|unique:items',
            'name'              => 'required|unique:items',
            'price'             => 'required',
            'price_without_tax' => 'required',
            'tax'               => 'required',
            'purchase_price'    => 'sometimes',
            'details'           => 'sometimes',
            // 'quantity'          => 'sometimes',
            'image'             => 'sometimes|image|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $image_name = null;

        if ($request->hasFile('image')) {
            $image_name = $this->uploadFile($request->file('image'), "item");
        }

        $data = [
            'code'              => $request->input('code'),
            'name'              => $request->input('name'),
            'price'             => $request->input('price') ?? 0,
            'quantity'          => $request->input('quantity') ?? 0,
            'price_without_tax' => $request->input('price_without_tax') ?? 0,
            'tax'               => $request->input('tax') ?? 0,
            'purchase_price'    => $request->input('purchase_price') ?? 0,
            'details'           => $request->input('details'),
            'image'             => $image_name,
            'manufacture_date'              => $request->input('manufacture_date'),
            'expiry_date'              => $request->input('expiry_date'),
            
            'created_admin_id'  => auth()->guard('admin')->user()->id,
        ];

        $item = Item::create($data);

        if ($item) {
            $this->setMessage('Item Create Successfully', 'success');
            return redirect()->route('admin.item.index');
        } else {
            $this->setMessage('Item Create Failed', 'danger');
            return redirect()->back()->withInput();
        }

    }

    public function show(Item $item) {

        if (!auth_admin_user_permission('item.view')) {
            abort(403, "Unauthorized Access  Customer View");
        }

        return view('admin.setting.item.show', compact('item'));
    }

    public function edit(Item $item) {

        if (!auth_admin_user_permission('item.edit')) {
            abort(403, "Unauthorized Access  Customer Edit");
        }

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'item';
        $data['page_title'] = 'Edit Item ';
        $data['item']       = $item;
        return view('admin.setting.item.edit', $data);
    }

    public function update(Request $request, Item $item) {

        if (!auth_admin_user_permission('item.edit')) {
            abort(403, "Unauthorized Access Item Edit");
        }

        $validator = Validator::make($request->all(), [
            'code'              => 'required|min:3|max:30|unique:items,code,' . $item->id,
            'name'              => 'required|unique:items,name,' . $item->id,
            'price'             => 'required',
            'tax'               => 'required',
            'price_without_tax' => 'required',
            'purchase_price'           => 'sometimes',
            'details'           => 'sometimes',
            // 'quantity'          => 'sometimes',
            'image'             => 'sometimes|image|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $image_name = $item->image;

        if ($request->hasFile('image')) {
            $image_name = $this->uploadFile($request->file('image'), "item");
            $this->removeFile($item->image, "item");
        }

        $data = [
            'code'              => $request->input('code'),
            'name'              => $request->input('name'),
            'price'             => $request->input('price') ?? 0,
            'quantity'          => $request->input('quantity') ?? 0,
            'tax'               => $request->input('tax') ?? 0,
            'price_without_tax' => $request->input('price_without_tax') ?? 0,
            'purchase_price' => $request->input('purchase_price') ?? 0,
            'details'           => $request->input('details'),
            'image'             => $image_name,
            'manufacture_date'              => $request->input('manufacture_date'),
            'expiry_date'              => $request->input('expiry_date'),
            'updated_admin_id'  => auth()->guard('admin')->user()->id,
        ];

        $check = Item::where('id', $item->id)->update($data) ? true : false;

        if ($check) {
            $this->setMessage('Item Update Successfully', 'success');
            return redirect()->route('admin.item.index');
        } else {
            $this->setMessage('Item Update Failed', 'danger');
            return redirect()->back()->withInput();
        }

    }

    public function updateStatus(Request $request) {

        if (!auth_admin_user_permission('item.updateStatus')) {
            abort(403, "Unauthorized Access  Item Update Status");
        }

        $response = [
            'error' => 'Error Found',
        ];

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'item_id' => 'required',
                'status'  => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'error' => 'Error Found',
                ];
            } else {
                $check = Item::where('id', $request->item_id)->update(['status' => $request->status]) ? true : false;

                if ($check) {
                    $response = [
                        'success' => 'Item Status Update Successfully',
                        'status'  => $request->status,
                    ];
                } else {
                    $response = [
                        'error' => 'Database Error Found',
                    ];
                }

            }

        }

        return response()->json($response);
    }

    public function destroy(Item $item) {

        if (!auth_admin_user_permission('item.delete')) {
            abort(403, "Unauthorized Access  Item Delete");
        }

        if (!empty($item->image)) {
            $this->removeFile($item->image, "item");
        }

        $check = $item->delete() ? true : false;

        if ($check) {
            $this->setMessage('Item Delete Successfully', 'success');
        } else {
            $this->setMessage('Item Delete Failed', 'danger');
        }

        return redirect()->route('admin.item.index');
    }

    public function delete(Request $request) {

        if (!auth_admin_user_permission('item.delete')) {
            abort(403, "Unauthorized Access  Item Delete");
        }

        $response = ['error' => 'Error Found'];

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'item_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = ['error' => 'Error Found'];
            } else {

                $item  = Item::where('id', $request->item_id)->first();
                $check = Item::where('id', $request->item_id)->delete() ? true : false;

                if ($check) {

                    if (!empty($item->image)) {
                        $this->removeFile($item->image, "item");
                    }

                    $response = ['success' => 'Item Delete Update Successfully'];
                } else {
                    $response = ['error' => 'Database Error Found'];
                }

            }

        }

        return response()->json($response);
    }

}
