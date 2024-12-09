<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        if (!auth_admin_user_permission('application.view')) {
            abort(403, "Unauthorized Access Application to view");
        }

        $data               = [];
        $data['main_menu']  = 'setting';
        $data['child_menu'] = 'application';
        $data['page_title'] = 'Application ';
        return view('admin.setting.application.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application) {

        if (!auth_admin_user_permission('application.edit')) {
            abort(403, "Unauthorized Access Application to Edit");
        }

        $data                = [];
        $data['main_menu']   = 'setting';
        $data['child_menu']  = 'application';
        $data['page_title']  = 'Edit Application ';
        $data['application'] = $application;
        return view('admin.setting.application.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application) {

        if (!auth_admin_user_permission('application.edit')) {
            abort(403, "Unauthorized Access Application to Update");
        }

        $validator = Validator::make($request->all(), [
            'name'             => 'required|min:3',
            'email'            => 'required',
            'contact_number'   => 'required',
            'locale'           => 'required',
            'photo'            => 'sometimes|image',
            'cr_no'            => 'sometimes',
            'meta_author'      => 'sometimes',
            'meta_keywords'    => 'sometimes',
            'meta_description' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->hasFile('photo')) {
            $photo_name = $this->uploadFile($request->file('photo'), "application");
            $this->removeFile($application->photo, "application");

        } else {
            $photo_name = $application->photo;
        }

        $data = [
            'name'             => $request->input('name'),
            'arabic_name'      => $request->input('arabic_name'),
            'vat_percent'      => $request->input('vat_percent'),
            'develop_by'       => $request->input('develop_by'),
            'email'            => $request->input('email'),
            'contact_number'   => $request->input('contact_number'),
            'address'          => $request->input('address'),
            'photo'            => $photo_name,
            'locale'           => $request->input('locale'),
            'vat_number'       => $request->input('vat_number'),
            'cr_no'            => $request->input('cr_no'),
            'meta_author'      => $request->input('meta_author'),
            'meta_keywords'    => $request->input('meta_keywords'),
            'meta_description' => $request->input('meta_description'),
            'admin_id'         => auth()->guard('admin')->user()->id,
        ];

        app()->setLocale($request->input('locale'));
        session()->put('locale', $request->input('locale'));

        $check = Application::where('id', $application->id)->update($data) ? true : false;

        if ($check) {
            $this->setMessage('Application Update Successfully', 'success');
            return redirect()->route('admin.application.index');
        } else {
            $this->setMessage('Application Update Failed', 'danger');
            return redirect()->back()->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
