<?php

namespace Modules\Vender\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\AgreementAcceptance;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Vender\Entities\TradingUnit;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Support\Renderable;

class LoginController extends Controller
{



    /***************  Login Api For Service Provider  *************/

  public function login(Request $request)
    {
        try {

            // ---------------- VALIDATION ----------------

            $validator = \Validator::make($request->all(), [
                'email'    => ['required', 'email'],
                'password' => ['required', 'string', 'min:6'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'token' => '',
                ]);
            }

            // ---------------- USER ----------------

            $user = User::where('email', $request->email)
                ->whereHas('trading_unit')
                ->with('trading_unit')
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Record Not Found!',
                ]);
            }

            if (in_array($user->status, ['PENDING', 'INACTIVE'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not an active user',
                ]);
            }

            // ---------------- TOKEN ----------------

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // ---------------- VENDOR / PROVIDER LOGIC ----------------

            if ($user->vender_id == 0) {

                $vender_id = $user->id;

                $trading_units = TradingUnit::where('vender_id', $vender_id)
                    ->with('trading_name')
                    ->get();
            } else {

                if (!isset($user->provider_app) || $user->provider_app['status'] == 0) {
                    return response()->json([
                        'status' => false,
                        'message' => "You don't have app access",
                    ]);
                }

                $user_trading_id = collect($user['trading_units'])->pluck('trading_id');

                $trading_units = TradingUnit::whereIn('id', $user_trading_id)
                    ->with('trading_name')
                    ->get();
            }

            $default_trading_unit = $trading_units->first()->id ?? 0;

            // ---------------- LOCATION + DEFAULT UNIT ----------------

            User::where('id', $user->id)->update([
                'lat' => $request->lat ?? $user->lat,
                'long' => $request->lon ?? $user->long,
                'default_trading_unit' => $user->default_trading_unit == 0
                    ? $default_trading_unit
                    : $user->default_trading_unit,
            ]);

            $user = User::where('email', $request->email)
                ->with('trading_unit.trading_name')
                ->first();

            // ---------------- PERMISSIONS ----------------

            if ($user->vender_id == 0) {
                $permissions = Permission::where('group_type', 'APP')->pluck('name');
            } else {

                if ($user['provider_app']['status'] == 0) {
                    return response()->json([
                        'status' => false,
                        'message' => "You don't have app access",
                    ]);
                }

                $permissions = collect($user['provider_app']['group']['permissions'])->pluck('name');
            }

            // ---------------- AGREEMENT STATUS ----------------

            $accepted = AgreementAcceptance::where('user_id', $user->id)
                ->pluck('agreement_type')
                ->toArray();

            $agreements = [
                'nda' => in_array('NDA', $accepted),
                'terms' => in_array('TERMS', $accepted),
                'privacy' => in_array('PRIVACY', $accepted),
            ];

            $agreements['all_completed'] =
                $agreements['nda'] &&
                $agreements['terms'] &&
                $agreements['privacy'];

            // ---------------- RESPONSE ----------------

            return response()->json([
                'status' => true,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
                'permissions' => $permissions,
                'trading_units' => $trading_units,
                'agreements' => $agreements
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /***************  Login Api For Service Provider  *************/

    public function deleteAccount(Request $request)
    {


        try {



            $user = User::find($request->user()->id);

            $user->status = "INACTIVE";
            $user->update();

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Account Delete Successfully',

            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Login",
            ]);
        }
    }


    public function fetchTradingUnit(Request $request)
    {

        $user = User::find($request->user()->id);

        if ($user['vender_id'] == 0 || $user['type'] == "Manager") {

            $vender_id = 0;

            if ($user['vender_id'] == 0) {

                $vender_id = $user['id'];
            } else {
                $vender_id = $user['vender_id'];
            }


            $user_trading_id = collect($user['trading_units'])->pluck('trading_id');
            $trading_units = TradingUnit::whereIn('id', $user_trading_id)->with('trading_name')->get();
        } else {
            $user_trading_id = collect($user['trading_units'])->pluck('trading_id');
            $trading_units = TradingUnit::whereIn('id', $user_trading_id)->with('trading_name')->get();
        }


        if (count($trading_units) > 0) {
            return response()->json([
                'status' => true,

                'trading_units' => $trading_units
            ]);
        } else {

            return response()->json([
                'status' => true,
                'message' => 'Record Not Found',
                'trading_units' => $trading_units
            ]);
        }
    }
    public function setTradingUnit(Request $request)
    {

        $validator = \Validator::make($request->all(), [

            'trading_id' => ['required']
        ]);
        if ($validator->fails()) {

            $responseArr['message'] = $validator->errors()->first();
            $responseArr['token'] = '';
            return response()->json($responseArr);
        }

        $user = User::find($request->user()->id)->update([
            'default_trading_unit' => $request['trading_id']
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Default Trading Unit Set Successfully!'
        ]);
    }


    /***************  Send Otp  *************/

    public function sendOtp(Request $request)
    {
        $validator = \Validator::make($request->all(), [

            'email' => ['required'],
        ]);

        if ($validator->fails()) {

            $responseArr['message'] = $validator->errors()->first();
            $responseArr['token'] = '';
            return response()->json($responseArr);
        }
        $otp = rand(1000, 9999);
        $user = User::where('email', '=', $request->email)->first();

        if ($user) {
            UserOtp::where('user_id', $user['id'])->delete();
            UserOtp::create([
                'user_id' => $user['id'],
                'otp' => $otp

            ]);

            $mail_details = [
                'subject' => 'Register OTP',
                'body' => 'Your OTP is : ' . $otp,
            ];

            Mail::send('email.otp', get_defined_vars(), function ($send) use ($request, $otp) {
                $send->to($request['email'])->subject("Your Motonos OTP security code - {$otp}");
            });


            return response(["status" => true, "message" => "OTP sent successfully"]);
        } else {
            return response(["status" => false, 'message' => 'Invalid']);
        }
    }


    /***************  Verify Otp  *************/

    public function verifyOtp(Request $request)
    {
        try {


            $validator = \Validator::make($request->all(), [

                'email' => ['required'],
                'otp' => ['required'],
            ]);
            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }

            $user = User::where([['email', '=', $request->email]])->first();

            if ($user) {

                $user_otp = UserOtp::where('user_id', $user['id'])->where('otp', $request['otp'])->first();

                if ($user_otp) {
                    $accessToken = $user->createToken('authToken')->plainTextToken;

                    $user = User::find($user['id']);

                    return response(["status" => true, "message" => "Otp Verified Successfully", 'user' => $user, 'access_token' => $accessToken]);
                } else {
                    return response(["status" => false, 'message' => 'Invalid Otp']);
                }
            } else {
                return response(["status" => false, 'message' => 'Invalid Otp']);
            }
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Verify Otp",
            ]);
        }
    }
    /***************  Update Password  *************/

    public function updatePassword(Request $request)
    {
        try {

            $validator = \Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'confirmed'],

            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }

            $user = User::find($request->user()->id)->update([

                'password' => Hash::make($request['password']),
            ]);

             $user = User::find($request->user()->id);

              Mail::send('email.password_confirmation', get_defined_vars(), function ($send) use ($user) {
                $send->to($user['email'])->subject("Your Motonos password has been changed");
            });


            return response()->json([
                'status' => true,
                'message' => "Password Update Successfully"
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Update Password",
            ]);
        }
    }
}
