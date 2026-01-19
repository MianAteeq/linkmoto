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
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($this->hasTooManyLoginAttempts($request)) {
        $this->fireLockoutEvent($request);
        return $this->sendLockoutResponse($request);
    }

    $user = Admin::where('email', $request->email)->first();

    if ($user && $user->status != 1) {
        return redirect('/admin/login')->withErrors('User is Not Active!');
    }

    if (Auth::guard('admin')->attempt(
        ['email' => $request->email, 'password' => $request->password],
        $request->boolean('remember')
    )) {
        $this->clearLoginAttempts($request);
        return redirect()->route('admin.dashboard'); // or admin/dashboard
    }

    $this->incrementLoginAttempts($request);

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
