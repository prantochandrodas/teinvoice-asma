<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Admin;

class LoginController extends Controller {

    public function showLoginForm() {
        $data                = [];
        $data['application'] = Application::first();
        return view('login', $data);
    }

    public function login(Request $request) {

        $Validator = Validator::make($request->all(), [
            'email'    => 'required',
            'password' => 'required|min:5',
        ],
            [
                'email.required'    => 'Email is Required',
                'password.required' => 'Password is Required',
                'password.min'      => 'Password is Required',
            ]);

        if ($Validator->fails()) {
            return redirect()->back()->withInput()->withErrors($Validator);
        }

        $user_name = "email";

        if (is_numeric($request->input('email'))) {
            $user_name = "phone";
        }

        /** Admin Login */
        if (auth()->guard('admin')->attempt([
            $user_name => $request->input('email'),
            'password' => $request->input('password'),
            'status'   => 1,
        ])) {

            $application = Application::first();

            app()->setLocale($application->locale);
            session()->put('locale', $application->locale);

            activity()
                ->causedBy(auth()->guard('admin')->user())
                ->log('login');

            $this->setMessage('Admin Login Successfully', 'success');
            return redirect()->route('admin.home');
        }


        $this->setMessage('Login Failed', 'danger');

        throw ValidationException::withMessages([
            $user_name => [trans('auth.failed')],
        ]);

    }

}
