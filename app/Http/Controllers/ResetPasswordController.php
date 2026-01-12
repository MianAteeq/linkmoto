<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request)
{
    return view('frontend::reset-password', [
        'token' => $request->query('token'),
        'email' => $request->query('email'),
    ]);
}
 public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        // Check if token expired (1 hour limit)
        if (Carbon::parse($tokenData->created_at)->addHour()->isPast()) {
            return back()->withErrors(['email' => 'Token expired.']);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete token after use
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

               return redirect()->route('website.vendor.login')->with('status', 'Password successfully reset. You can now log in.');

    }
}
