<?php

namespace App\Http\Controllers\AdminController\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    protected $redirect = 'admin/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.authAdmin.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required|min:6',
        ]);
        $credential =[
                'email'=>$request->email,
                'password'=>$request->password
            ];
        if (Auth::guard('admin')->attempt($credential, $request->member)) {
            return redirect()->intended(route('admin.home'));
        }
        return redirect()->back()->withInput($request->only(['email','remember']))->with('warning_login', 'these cerdentials are false');
    }

    public function redirectPath()
    {
        return '/admin/home';
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}