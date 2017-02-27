<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;



    protected $redirectTo = 'admin/index';

    public  function __construct(){

        $this->middleware('guest:admin',['except'=>'logout']);

    }
    //
    public function guard(){

        return Auth::guard('admin');

    }

    public function showLogin(){

        return view('admin.auth.login');

    }
    public function username()
    {
        return 'username';
    }

    public function logout()
    {
        $this->guard('admin')->logout();

        request()->session()->flush();

        request()->session()->regenerate();

        return redirect('/admin/login');
    }




}
