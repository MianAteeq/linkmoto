<?php

namespace Modules\ClientHub\Http\Controllers;

use File;
use stdClass;
use Exception;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\ClientHub\Entities\Client;
use Modules\Vender\Entities\TradingUnit;
use Modules\ClientHub\Entities\LinkVender;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {

        $auth_id = $request->profile_id;

        $latitude=$request->user()->lat;
        $longtitude=$request->user()->long;


        $user =TradingUnit::where('status','ACTIVE')->with('vender')->with(['hub_setting','site','trading_name','job_types.job_type','payment_methods.payment_method','product_offers','vehicle_specialists.vehicle_specialist','accreditations.accreditation','warranty_jobs.warranty_job'])
    //     ->select("trading_units.*" ,DB::raw("3959* acos(cos(radians(" . $latitude . "))
    //     * cos(radians(trading_units.lat))
    //    * cos(radians(trading_units.long) - radians(" . $longtitude . "))
    //     + sin(radians(" .$latitude. "))
    //     * sin(radians(trading_units.lat))) AS distance"))
        ->find($auth_id);

       $array=collect($user['job_types']);

       $vender_services=[];
       foreach ($array as $key => $value) {

        $data=new stdClass();
        $data=$value['job_type'];
        $data->child=[];

        array_push($vender_services,$data);

       }


    //    $user->vender_services=$vender_services;

        $linked = LinkVender::where('vender_id', $auth_id)->where('hub_id', $request->user()->id)->first();

        if(isset($linked)){

            $user['is_linked']=1;

        }else{
            $user['is_linked'] = 0;
        }


        return response()->json([
            'status' => true,
            'profile' => $user,
            'vender_services'=>$vender_services,
            'message' => "Profile Fetch Successfully",
        ]);
    }

    public function fetchProfile(Request $request)
    {
        $auth_id = $request->user()->id;
        $user = Client::find($auth_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => "User not found",
            ], 404);
        }

        return response()->json([
            'status' => true,
            'profile' => $user,
            'user' => $user,
            'message' => "Profile Fetch Successfully",
        ]);
    }

    public function updateToken(Request $request)
    {

        try {
            $validator = \Validator::make($request->all(), [
                'token' =>  ['required'],

            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }

          $client=  Client::find($request->user()->id);

            $client->token=$request['token'];
            $client->save();



            return response()->json([
                'status' => true,

                'message' => "Token Save Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Add Token",
            ]);
        }

    }
    public function updateLatLong(Request $request)
    {
        try {
            $user = $request->user();
            $client = ($user instanceof Client) ? $user : Client::find($user->id ?? 0);

            if (!$client) {
                return response()->json([
                    'status'    => false,
                    'errorCode' => 'USER_NOT_FOUND',
                    'message'   => 'User not found.',
                ], 404);
            }

            // Normalise coordinate inputs (lat / latitude, long / lng / lon / longitude)
            $rawLat = $request->input('lat', $request->input('latitude'));
            $rawLong = $request->input('long', $request->input('lng', $request->input('lon', $request->input('longitude'))));
            $rawLocation = $request->input('location', $request->input('address', $request->input('fullAddress', $request->input('displayName'))));

            // Validate that lat and long are COMPULSORY
            $fieldErrors = [];
            if ($rawLat === null || $rawLat === '' || !is_numeric($rawLat)) {
                $fieldErrors['lat'] = 'Latitude is required and must be a valid number.';
            }
            if ($rawLong === null || $rawLong === '' || !is_numeric($rawLong)) {
                $fieldErrors['long'] = 'Longitude is required and must be a valid number.';
            }

            if (!empty($fieldErrors)) {
                return response()->json([
                    'status'      => false,
                    'errorCode'   => 'COORDINATES_REQUIRED',
                    'message'     => 'Latitude and longitude coordinates are compulsory.',
                    'fieldErrors' => $fieldErrors,
                ], 422);
            }

            $lat = (float) $rawLat;
            $long = (float) $rawLong;

            // Validate geographical coordinate boundaries
            if ($lat < -90.0 || $lat > 90.0 || $long < -180.0 || $long > 180.0) {
                return response()->json([
                    'status'      => false,
                    'errorCode'   => 'INVALID_COORDINATES',
                    'message'     => 'Coordinates out of valid geographical range (-90..90, -180..180).',
                    'fieldErrors' => [
                        'lat'  => ($lat < -90.0 || $lat > 90.0) ? 'Latitude must be between -90 and 90.' : null,
                        'long' => ($long < -180.0 || $long > 180.0) ? 'Longitude must be between -180 and 180.' : null,
                    ],
                ], 422);
            }

            $locationString = is_string($rawLocation) ? trim($rawLocation) : '';

            $validator = \Validator::make($request->all(), [
                'postcode' => ['sometimes', 'nullable', 'string', 'max:16'],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid postcode.',
                    'fieldErrors' => $validator->errors(),
                ], 422);
            }

            // Older clients send only address text; never retain a previous location's postcode.
            $postcode = $request->input('postcode');
            if (!$request->exists('postcode')) {
                $address = implode(', ', array_filter([
                    $locationString,
                    is_string($request->input('cityAndPostcode')) ? $request->input('cityAndPostcode') : '',
                ]));
                preg_match('/\b(?:GIR\s*0AA|[A-Z]{1,2}\d[A-Z\d]?\s*\d[A-Z]{2})\b/i', $address, $matches);
                $postcode = $matches[0] ?? '';
            }

            $client->lat = (string) $lat;
            $client->long = (string) $long;
            $client->postcode = strtoupper(preg_replace('/\s+/', '', $postcode ?? '')) ?: null;
            if (!empty($locationString)) {
                $client->location = $locationString;
            }
            $client->save();

            return response()->json([
                'status'   => true,
                'message'  => 'Location updated successfully.',
                'user'     => $client,
                'location' => [
                    'lat'             => $lat,
                    'long'            => $long,
                    'lng'             => $long,
                    'location'        => $client->location,
                    'address'         => $client->location,
                    'displayName'     => $client->location,
                    'postcode'        => $client->postcode,
                    'cityAndPostcode' => (string) $request->input('cityAndPostcode', ''),
                    'street'          => (string) $request->input('street', ''),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while updating location coordinates.',
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $clientId = $request->user()->id;

            $validator = \Validator::make($request->all(), [
                'email'      => [
                    'sometimes',
                    'nullable',
                    'email',
                    'max:255',
                    Rule::unique('clients', 'email')->ignore($clientId)->whereNull('deleted_at'),
                ],
                'name'       => 'sometimes|nullable|string|max:255',
                'first_name' => 'sometimes|nullable|string|max:120',
                'last_name'  => 'sometimes|nullable|string|max:120',
                'phone_no'   => 'sometimes|nullable|string|max:30',
                'mobile'     => 'sometimes|nullable|string|max:30',
                'path'       => 'sometimes|nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $client = Client::find($clientId);
            if (!$client) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User not found.',
                ], 404);
            }

            // Handle name / first_name / last_name
            if ($request->has('first_name') || $request->has('last_name')) {
                $nameParts = explode(' ', trim($client->name ?? ''), 2);
                $first = $request->has('first_name')
                    ? trim((string)$request->input('first_name'))
                    : ($nameParts[0] ?? '');
                $last = $request->has('last_name')
                    ? trim((string)$request->input('last_name'))
                    : ($nameParts[1] ?? '');

                $combinedName = trim("$first $last");
                if (!empty($combinedName)) {
                    $client->name = $combinedName;
                }
            } elseif ($request->filled('name')) {
                $client->name = trim((string)$request->input('name'));
            }

            // Handle phone_no / mobile
            if ($request->filled('phone_no')) {
                $client->phone_no = trim((string)$request->input('phone_no'));
            } elseif ($request->filled('mobile')) {
                $client->phone_no = trim((string)$request->input('mobile'));
            }

            // Handle email
            if ($request->filled('email')) {
                $client->email = trim((string)$request->input('email'));
            }

            // Handle optional profile picture
            if ($request->filled('path') && ($request->input('is_Update') == true || str_contains($request->input('path'), ';base64,'))) {
                $img = $request->input('path');
                if (str_contains($img, ';base64,')) {
                    $folderPath = 'images/';
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, 0777, true, true);
                    }

                    $image_parts = explode(';base64,', $img);
                    $image_type_aux = explode('image/', $image_parts[0]);
                    $image_type = isset($image_type_aux[1]) ? $image_type_aux[1] : 'png';
                    $image_base64 = base64_decode($image_parts[1]);
                    $uniqid = uniqid();
                    $file = $folderPath . $uniqid . '.' . $image_type;
                    file_put_contents($file, $image_base64);
                    $client->profile_pic = $file;
                } else {
                    $client->profile_pic = $img;
                }
            }

            $client->save();

            return response()->json([
                'status'  => true,
                'message' => 'Profile updated successfully',
                'user'    => $client,
                'profile' => $client,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while updating profile',
            ], 500);
        }
    }

    /**
     * Send OTP for email change to the requested new email address
     */
    public function sendEmailChangeOtp(Request $request)
    {
        try {
            $user = Client::find($request->user()->id);
            if (!$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User not found.',
                ], 404);
            }

            $validator = \Validator::make($request->all(), [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('clients', 'email')->ignore($user->id)->whereNull('deleted_at'),
                ],
            ]);

            if ($validator->fails()) {
                $errorMsg = $validator->errors()->first();
                $isUniqueError = str_contains(strtolower($errorMsg), 'already been taken') || str_contains(strtolower($errorMsg), 'in use');
                return response()->json([
                    'status'    => false,
                    'errorCode' => $isUniqueError ? 'IN_USE' : 'INVALID_FORMAT',
                    'message'   => $isUniqueError ? 'Email address is already in use.' : $errorMsg,
                    'errors'    => $validator->errors(),
                ], 422);
            }

            $newEmail = trim($request->email);

            // Generate a 6-digit OTP
            $otp = (string) rand(100000, 999999);

            // Store in user_otps table
            UserOtp::where('user_id', $user->id)->delete();
            UserOtp::create([
                'user_id' => $user->id,
                'otp'     => $otp,
            ]);

            // Send verification email to the new email address
            $mail_details = [
                'subject' => 'Motonos Hub – Email Verification Code',
                'body'    => 'Your 6-digit verification code is: ' . $otp,
            ];

            Mail::send('email.otp', ['user' => $user, 'otp' => $otp, 'mail_details' => $mail_details], function ($send) use ($newEmail) {
                $send->to($newEmail)->subject('Motonos Hub – Email Verification Code');
            });

            return response()->json([
                'status'  => true,
                'message' => 'Verification code sent to your new email address.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Failed to send verification code. Please try again.',
            ], 500);
        }
    }

    /**
     * Verify OTP and update email address
     */
    public function verifyEmailChangeOtp(Request $request)
    {
        try {
            $user = Client::find($request->user()->id);
            if (!$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User not found.',
                ], 404);
            }

            $validator = \Validator::make($request->all(), [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('clients', 'email')->ignore($user->id)->whereNull('deleted_at'),
                ],
                'otp'   => ['required', 'string', 'size:6'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'errorCode' => 'INVALID_OTP',
                    'message'   => $validator->errors()->first(),
                    'errors'    => $validator->errors(),
                ], 422);
            }

            $cleanOtp = trim($request->otp);
            $userOtp = UserOtp::where('user_id', $user->id)
                ->where('otp', $cleanOtp)
                ->first();

            if (!$userOtp) {
                return response()->json([
                    'status'    => false,
                    'errorCode' => 'INVALID_OTP',
                    'message'   => 'Invalid verification code.',
                ], 422);
            }

            // OTP valid — apply email change
            $user->email = trim($request->email);
            $user->save();

            // Clear the used OTP
            UserOtp::where('user_id', $user->id)->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Email address updated successfully.',
                'user'    => $user,
                'profile' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Failed to verify email code. Please try again.',
            ], 500);
        }
    }

    /**
     * Send OTP for mobile change to user's registered email
     */
    public function sendMobileChangeOtp(Request $request)
    {
        try {
            $user = Client::find($request->user()->id);
            if (!$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User not found.',
                ], 404);
            }

            $validator = \Validator::make($request->all(), [
                'mobile' => ['required', 'string', 'min:10', 'max:30'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'errorCode' => 'INVALID_FORMAT',
                    'message'   => $validator->errors()->first(),
                    'errors'    => $validator->errors(),
                ], 422);
            }

            if (empty($user->email)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'No registered email found for your account to receive the verification code.',
                ], 422);
            }

            // Generate a 6-digit OTP
            $otp = (string) rand(100000, 999999);

            // Store in user_otps table
            UserOtp::where('user_id', $user->id)->delete();
            UserOtp::create([
                'user_id' => $user->id,
                'otp'     => $otp,
            ]);

            $mail_details = [
                'subject' => 'Motonos Hub – Mobile Change Verification Code',
                'body'    => 'Your 6-digit verification code is: ' . $otp,
            ];

            // Send to registered email
            Mail::send('email.otp', ['user' => $user, 'otp' => $otp, 'mail_details' => $mail_details], function ($send) use ($user) {
                $send->to($user->email)->subject('Motonos Hub – Mobile Change Verification Code');
            });

            // Mask email (e.g. z******@gmail.com)
            $emailParts = explode('@', $user->email);
            $maskedEmail = $user->email;
            if (count($emailParts) === 2) {
                $namePart = $emailParts[0];
                $domainPart = $emailParts[1];
                $maskedName = strlen($namePart) > 1
                    ? $namePart[0] . str_repeat('*', min(6, strlen($namePart) - 1))
                    : $namePart . '******';
                $maskedEmail = $maskedName . '@' . $domainPart;
            }

            return response()->json([
                'status'      => true,
                'message'     => 'Verification code sent to your registered email.',
                'maskedEmail' => $maskedEmail,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Failed to send verification code. Please try again.',
            ], 500);
        }
    }

    /**
     * Verify OTP and update mobile number
     */
    public function verifyMobileChangeOtp(Request $request)
    {
        try {
            $user = Client::find($request->user()->id);
            if (!$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User not found.',
                ], 404);
            }

            $validator = \Validator::make($request->all(), [
                'mobile' => ['required', 'string', 'min:10', 'max:30'],
                'otp'    => ['required', 'string', 'size:6'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'errorCode' => 'INVALID_OTP',
                    'message'   => $validator->errors()->first(),
                    'errors'    => $validator->errors(),
                ], 422);
            }

            $cleanOtp = trim($request->otp);
            $userOtp = UserOtp::where('user_id', $user->id)
                ->where('otp', $cleanOtp)
                ->first();

            if (!$userOtp) {
                return response()->json([
                    'status'    => false,
                    'errorCode' => 'INVALID_OTP',
                    'message'   => 'Invalid verification code.',
                ], 422);
            }

            // OTP valid — apply mobile change
            $mobileNumber = trim($request->input('mobile', $request->input('phone_no')));
            $user->phone_no = $mobileNumber;
            $user->save();

            // Clear the used OTP
            UserOtp::where('user_id', $user->id)->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Mobile number updated successfully.',
                'user'    => $user,
                'profile' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Failed to verify mobile code. Please try again.',
            ], 500);
        }
    }
}
