<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    
    public function getforgetPassword(){
        
        return view('frontend::forgetpassword',get_defined_vars());
    }
    
    public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $token = Str::random(64);

    // Save token in DB
    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        ['token' => $token, 'created_at' => Carbon::now()]
    );

    // Send email
    Mail::send('email.password_reset', [
        'token' => $token,
        'email' => $request->email
    ], function($message) use ($request) {
        $message->to($request->email);
        $message->subject('Reset Your Password');
    });
    
    return back()->with('status', 'Password reset link sent to your email.');

}

}
