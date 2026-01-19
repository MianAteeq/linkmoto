<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Admin;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin::admin.auth.login');
    }

    public function store(Request $request)
{
    $user = Admin::where('email', $request->email)->first();

    // if user exists check status
    if ($user && $user->status != 1) {
        return redirect('/admin/login')->withErrors('User is Not Active!');
    }

    // Optional: validate request
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt login
    $user_auth = Auth::guard('admin')->attempt(
        [
            'email' => $request->email,
            'password' => $request->password
        ],
        $request->remember ?? false
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
