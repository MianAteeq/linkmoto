<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
     use ThrottlesLogins;

    public function username()
    {
        return 'email';
    }
    public function index()
    {
        return view('admin::admin.auth.login');
    }


  

   public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = Admin::where('email', $request->email)->first();

    if ($user && $user->status != 1) {
        return redirect('/admin/login')->withErrors('User is Not Active!');
    }

    $user_auth = Auth::guard('admin')->attempt(
        [
            'email' => $request->email,
            'password' => $request->password
        ],
        $request->boolean('remember')
    );

    if ($user_auth) {
        return redirect('admin/dashboard');
    }

    return redirect('/admin/login')->withErrors('Please Enter Valid Email ID or Password.');
}



    public function recover()
    {
        return view('admin::admin.auth.forgot_password');
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        return redirect('login');
    }
}
