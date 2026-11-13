<?php

namespace Modules\ClientHub\Http\Controllers;

use App\Models\UserOtp;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Modules\ClientHub\Entities\Client;

class LoginController extends Controller
{
    /***************  Login Api For Client Hub  *************/

    public function login(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'email'    => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ]);
            }

            $user = Client::where('email', $request->email)->first();

            if (!$user || $user->status == 0 || (method_exists($user, 'trashed') && $user->trashed())) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid email address or password.',
                ]);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid email address or password.',
                ]);
            }

            // Update geolocation if provided
            if ($request->filled('lat')) {
                $user->update([
                    'lat'  => $request->lat,
                    'long' => $request->lon ?? $request->long,
                ]);
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status'       => true,
                'access_token' => $tokenResult,
                'token_type'   => 'Bearer',
                'user'         => $user,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'An error occurred during login.',
            ]);
        }
    }
    public function inActive(Request $request)
    {
        try {
            $user = $request->user();
            $client = ($user instanceof Client) ? $user : (isset($user->id) ? Client::find($user->id) : null);

            if ($client) {
                $client->status = 0;
                $client->save();
                if (method_exists($client, 'tokens')) {
                    $client->tokens()->delete();
                }
                $client->delete();
            }

            return response()->json([
                'status'  => true,
                'message' => 'Account has been deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while deleting account.',
            ], 500);
        }
    }

    /***************  Register Api For Client Hub  *************/

    public function register(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'name'     => ['required', 'string', 'max:255'],
                'phone_no' => ['required', 'string', 'max:20'],
                'email'    => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('clients', 'email')->whereNull('deleted_at'),
                ],
                'password' => 'required|confirmed|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ]);
            }

            $client = Client::create([
                'name'     => $request->name,
                'phone_no' => $request->phone_no,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'lat'      => 0,
                'long'     => 0,
            ]);

            return response()->json([
                'status'  => true,
                'client'  => $client,
                'message' => 'Account created successfully.',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'An error occurred during registration.',
            ]);
        }
    }


    public function sendOtp(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = Client::where('email', $request->email)->first();

        if (!$user || $user->status == 0) {
            return response()->json([
                'status'    => false,
                'errorCode' => 'USER_NOT_FOUND',
                'message'   => 'No account found with that email address.',
            ], 404);
        }

        // Generate a secure 6-digit OTP
        $otp = rand(100000, 999999);

        // Delete any existing OTP for this user and create a fresh one
        UserOtp::where('user_id', $user->id)->delete();
        UserOtp::create([
            'user_id' => $user->id,
            'otp'     => $otp,
        ]);

        $mail_details = [
            'subject' => 'Motonos Hub – Password Reset Verification Code',
            'body'    => 'Your 6-digit verification code is: ' . $otp,
        ];

        try {
            Mail::send('email.otp', ['user' => $user, 'otp' => $otp, 'mail_details' => $mail_details], function ($send) use ($user) {
                $send->to($user->email)->subject('Motonos Hub – Password Reset Verification Code');
            });
        } catch (Exception $e) {
            // Log mail exception without blocking response if simulated
        }

        // Mask email for privacy (e.g. z******@gmail.com)
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
            'message'     => 'A 6-digit verification code has been sent to your email.',
            'maskedEmail' => $maskedEmail,
        ]);
    }

    /***************  Verify Otp  *************/

    public function verifyOtp(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'otp'   => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'errorCode' => 'INVALID_FORMAT',
                    'message'   => $validator->errors()->first(),
                ], 422);
            }

            $user = Client::where('email', $request->email)->first();

            if (!$user || $user->status == 0) {
                return response()->json([
                    'status'    => false,
                    'errorCode' => 'USER_NOT_FOUND',
                    'message'   => 'No account found with that email address.',
                ], 404);
            }

            $cleanOtp = trim((string) $request->otp);
            $user_otp = UserOtp::where('user_id', $user->id)
                ->where('otp', $cleanOtp)
                ->first();

            if ($user_otp) {
                $accessToken = $user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'status'       => true,
                    'message'      => 'Code verified successfully.',
                    'user'         => $user,
                    'access_token' => $accessToken,
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'errorCode' => 'INVALID_OTP',
                    'message'   => 'Invalid or expired verification code.',
                ], 422);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while verifying code.',
            ], 500);
        }
    }

    /***************  Reset Password (Forgot Password Flow)  *************/

    public function resetPassword(Request $request)
    {
        try {
            // Normalise input fields from camelCase or snake_case
            $email = trim((string) $request->input('email'));
            $otp = trim((string) $request->input('otp'));
            $password = (string) $request->input('password', $request->input('newPassword'));
            $passwordConfirmation = (string) $request->input('password_confirmation', $request->input('confirmPassword'));

            // 1. Check required fields
            if (empty($email) || empty($otp) || empty(trim($password)) || empty(trim($passwordConfirmation))) {
                $fieldErrors = [];
                if (empty($email)) $fieldErrors['email'] = 'Required';
                if (empty($otp)) $fieldErrors['otp'] = 'Required';
                if (empty(trim($password))) $fieldErrors['newPassword'] = 'Required';
                if (empty(trim($passwordConfirmation))) $fieldErrors['confirmPassword'] = 'Required';

                return response()->json([
                    'status'      => false,
                    'errorCode'   => 'REQUIRED',
                    'message'     => 'Please enter all required fields.',
                    'fieldErrors' => $fieldErrors,
                ], 422);
            }

            // 2. Find user
            $user = Client::where('email', $email)->first();
            if (!$user || $user->status == 0) {
                return response()->json([
                    'status'    => false,
                    'errorCode' => 'USER_NOT_FOUND',
                    'message'   => 'No account found with that email address.',
                ], 404);
            }

            // 3. Verify OTP
            $userOtp = UserOtp::where('user_id', $user->id)
                ->where('otp', $otp)
                ->first();

            if (!$userOtp) {
                return response()->json([
                    'status'      => false,
                    'errorCode'   => 'INVALID_OTP',
                    'message'     => 'Invalid or expired verification code.',
                    'fieldErrors' => [
                        'otp' => 'Invalid or expired code',
                    ],
                ], 422);
            }

            // 4. Password policy (min 8 characters)
            if (strlen($password) < 8) {
                return response()->json([
                    'status'      => false,
                    'errorCode'   => 'POLICY_VIOLATION',
                    'message'     => 'Password should be at least 8 characters.',
                    'fieldErrors' => [
                        'newPassword' => 'Password should be at least 8 characters',
                    ],
                ], 422);
            }

            // 5. Password confirmation match
            if ($password !== $passwordConfirmation) {
                return response()->json([
                    'status'      => false,
                    'errorCode'   => 'PASSWORD_MISMATCH',
                    'message'     => 'Passwords do not match.',
                    'fieldErrors' => [
                        'confirmPassword' => 'Passwords do not match',
                    ],
                ], 422);
            }

            // 6. Update user password
            $user->password = Hash::make($password);
            $user->save();

            // 7. Clear used OTP
            UserOtp::where('user_id', $user->id)->delete();

            // 8. Revoke old access tokens for security
            if (method_exists($user, 'tokens')) {
                $user->tokens()->delete();
            }

            return response()->json([
                'status'  => true,
                'message' => 'Password has been reset successfully. Please log in with your new password.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while resetting password.',
            ], 500);
        }
    }
    
    /***************  Update Password  *************/




    public function updatePassword(Request $request)
    {
        try {
            $client = Client::find($request->user()->id);
            if (!$client) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User not found.',
                ], 404);
            }

            // Normalise input fields from camelCase or snake_case
            $oldPassword = (string) $request->input('old_password', $request->input('oldPassword'));
            $newPassword = (string) $request->input('password', $request->input('newPassword'));
            $confirmPassword = (string) $request->input('password_confirmation', $request->input('confirmPassword'));

            // 1. Check required fields
            if (empty(trim($oldPassword)) || empty(trim($newPassword)) || empty(trim($confirmPassword))) {
                $fieldErrors = [];
                if (empty(trim($oldPassword))) $fieldErrors['oldPassword'] = 'Required';
                if (empty(trim($newPassword))) $fieldErrors['newPassword'] = 'Required';
                if (empty(trim($confirmPassword))) $fieldErrors['confirmPassword'] = 'Required';

                return response()->json([
                    'status'      => false,
                    'message'     => 'Please enter required fields',
                    'errorCode'   => 'REQUIRED',
                    'fieldErrors' => $fieldErrors,
                ], 422);
            }

            // 2. Check old password against database
            if (!Hash::check($oldPassword, $client->password)) {
                return response()->json([
                    'status'      => false,
                    'message'     => 'Could not submit. Please rectify issues.',
                    'errorCode'   => 'INCORRECT_OLD_PASSWORD',
                    'fieldErrors' => [
                        'oldPassword' => 'Incorrect password entered',
                    ],
                ], 422);
            }

            // 3. Check password length policy (min 8 characters)
            if (strlen($newPassword) < 8) {
                return response()->json([
                    'status'      => false,
                    'message'     => 'Could not submit. Please rectify issues.',
                    'errorCode'   => 'POLICY_VIOLATION',
                    'fieldErrors' => [
                        'newPassword' => 'Password should be at least 8 characters',
                    ],
                ], 422);
            }

            // 4. Check password match
            if ($newPassword !== $confirmPassword) {
                return response()->json([
                    'status'      => false,
                    'message'     => 'Could not submit. Please rectify issues.',
                    'errorCode'   => 'PASSWORD_MISMATCH',
                    'fieldErrors' => [
                        'confirmPassword' => 'Passwords do not match',
                    ],
                ], 422);
            }

            // 5. Update and hash password
            $client->password = Hash::make($newPassword);
            $client->save();

            return response()->json([
                'status'  => true,
                'message' => 'Password changed successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while updating password.',
            ], 500);
        }
    }

    public function deleteAccount(Request $request)
    {
        try {
            $user = $request->user();
            $client = ($user instanceof Client) ? $user : (isset($user->id) ? Client::find($user->id) : null);

            if ($client) {
                $client->status = 0;
                $client->save();
                if (method_exists($client, 'tokens')) {
                    $client->tokens()->delete();
                }
                $client->delete();
            }

            return response()->json([
                'status'  => true,
                'message' => 'Account has been deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while deleting account.',
            ], 500);
        }
    }
}
