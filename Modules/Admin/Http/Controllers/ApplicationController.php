<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vender\Entities\TradingName;
use Modules\Vender\Entities\VenderAddress;
use Modules\Vender\Entities\VendorProfile;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Vender\Entities\TradingUnit;
use Modules\Vender\Entities\TradingUnitAppSetting;
use Modules\Vender\Entities\UserApp;
use Modules\Vender\Entities\UserTradingUnit;
use Modules\Vender\Entities\WorkStream;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ApplicationController extends Controller
{
    public function application()
    {


        $users = User::whereIn('application_status', ['IN_REVIEW', 'ACCEPTED', 'DECLINE'])->where('type', null)->latest()->get();

        return view('admin::admin.registration.application.index', get_defined_vars());
    }

    public function applicationDetail($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.application_detail', get_defined_vars());
    }
    public function applicationInfo($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.application_info', get_defined_vars());
    }

    // Business Info

    public function businessInfo($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.business_info', get_defined_vars());
    }
    public function businessInfoVerify($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.business_info_verify', get_defined_vars());
    }
    public function businessVerify($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'business_status' => 1
        ]);

        return redirect()->back()->with('success', 'business information Accept Successfully');
    }
    public function businessDecline($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'business_status' => 3
        ]);

        return redirect()->back()->with('success', 'business information Decline Successfully');
    }


    // VAT Info

    public function vatInfo($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.vat', get_defined_vars());
    }
    public function vatInfoVerify($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.vat_verify', get_defined_vars());
    }
    public function vatVerify($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'vat_status' => 1
        ]);

        return redirect()->back()->with('success', 'Vat Accept Successfully');
    }
    public function vatDecline($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'vat_status' => 3
        ]);

        return redirect()->back()->with('success', 'Vat Decline Successfully');
    }
    // Trading Name Info

    public function tradingInfo($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.trading_name', get_defined_vars());
    }
    public function tradingInfoVerify($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.trading_name_verify', get_defined_vars());
    }
    public function tradingVerify($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'trading_name_status' => 1
        ]);

        return redirect()->back()->with('success', 'Trading Name Accept Successfully');
    }
    public function tradingDecline($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'trading_name_status' => 3
        ]);

        return redirect()->back()->with('success', 'Trading Name Decline Successfully');
    }

    // businessActivity Info

    public function businessActivityInfo($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.business_activity', get_defined_vars());
    }
    public function businessActivityInfoVerify($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.business_activities_verify', get_defined_vars());
    }
    public function businessActivityVerify($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'business_activities_status' => 1
        ]);

        return redirect()->back()->with('success', 'business Activity Accept Successfully');
    }
    public function businessActivityDecline($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'business_activities_status' => 3
        ]);

        return redirect()->back()->with('success', 'business Activity Decline Successfully');
    }

    // TradeUnit Info

    public function TradeUnitInfo($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.trade_unit', get_defined_vars());
    }
    public function TradeUnitInfoVerify($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.trade_unit_verify', get_defined_vars());
    }
    public function TradeUnitVerify($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'trade_unit_status' => 1
        ]);

        return redirect()->back()->with('success', 'Trading Unit Accept Successfully');
    }
    public function TradeUnitDecline($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'trade_unit_status' => 3
        ]);

        return redirect()->back()->with('success', 'Trading Unit Decline Successfully');
    }

    // MainAccount Info

    public function MainAccountInfo($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.main_account', get_defined_vars());
    }
    public function MainAccountInfoVerify($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.main_account_verify', get_defined_vars());
    }
    public function MainAccountVerify($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'main_account_status' => 1
        ]);

        return redirect()->back()->with('success', 'Main Account Accept Successfully');
    }
    public function MainAccountDecline($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'main_account_status' => 3
        ]);

        return redirect()->back()->with('success', 'Main Account Decline Successfully');
    }
    // MainAccount Info

    public function SubscriptionInfo($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.subscription', get_defined_vars());
    }
    public function SubscriptionInfoVerify($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.subscription_verify', get_defined_vars());
    }
    public function SubscriptionVerify($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'subscription_status' => 1
        ]);



        return redirect()->back()->with('success', 'Subscription Accept Successfully');
    }
    public function SubscriptionDecline($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'subscription_status' => 3
        ]);

        return redirect()->back()->with('success', 'Subscription Decline Successfully');
    }

    public function agreementInfo($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.agreement', get_defined_vars());
    }

    public function agreementInfoVerify($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.agreement_verify', get_defined_vars());
    }
    public function agreementVerify($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'agreement_status' => 1
        ]);



        return redirect()->back()->with('success', 'Subscription Accept Successfully');
    }
    public function agreementDecline($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'agreement_status' => 3
        ]);

        return redirect()->back()->with('success', 'Subscription Decline Successfully');
    }

    public function applicationAccept($id)
    {



        $user = User::with('profile')->find($id);

        $site = VenderAddress::where('vender_id', $id)->first();

        if ($user->profile->operation_type == 'On-site') {
            $operation_type = 'On-site';
        } elseif ($user->profile->operation_type == 'Mobile') {
            $operation_type = 'Mobile';
        } else {
            $operation_type = 'Both';
        }


        $unit = TradingUnit::create([
            'vender_id' => $user->id,
            'name' => 'Main',
            'trading_name_id' =>  0,
            'trading_template' => 1,
            'operation_type' => $operation_type,
            'city' => $operation_type == 'On-site' ? $site['city'] ?? '' : '',
            'postcode' => $operation_type == 'On-site' ? $site['postcode'] ?? '' : '',
            'radius' => 10,
            'mobile' => '',
            'landline' => '',
            'lat' => '',
            'long' => '',
            'email' => '',
            'website' => '',
            'site_id' => $operation_type == 'On-site' ? $site['id'] ?? '0' : '0',
            'status' => 'Active'


        ]);

        //  Business Manager Group Create

        $roles = ["Manager", "Customer Services", "Operations", "Technician"];

        foreach ($roles as $key => $role) {
            $role = Role::create([
                'name' => $role . "SVP_B_" . $user->id,
                'group_type' => 'System Default',
                'type' => 'BUSINESS',
                'guard_name' => 'web',
                'vender_id' => $user->id
            ]);

            $permissions = Permission::where('group_type', 'BUSINESS')->where('guard_name', 'web')->get()->pluck('id');

            $role->syncPermissions($permissions);
        }
        $business_role = Role::where('vender_id', $user->id)->where('type', 'BUSINESS')->first();

        // User App Role Create

        DB::transaction(function () use ($user) {

            $roles = ["Manager", "Customer Services", "Operations", "Technician"];
            $userId = $user->id;

            // lock existing roles for this vendor
            $existingRoles = Role::where('vender_id', $user->id)
                ->where('group_type', 'System Default')
                ->where('type', 'APP')
                ->lockForUpdate()
                ->pluck('name')
                ->toArray();

            $permissions = Permission::where('group_type', 'APP')->pluck('id');

            foreach ($roles as $roleName) {

                $fullName = $roleName . "SVP_" . $userId;

                // create only if missing
                if (!in_array($fullName, $existingRoles)) {

                    $role = Role::create([
                        'name' => $fullName,
                        'group_type' => 'System Default',
                        'type' => 'APP',
                        'vender_id' => $userId,
                        'guard_name' => 'web',
                    ]);

                    $role->syncPermissions($permissions);
                }
            }
        });

        $app_role = Role::where('vender_id', $user->id)->where('type', 'APP')->first();

        WorkStream::create([
            'vender_id' => $user->id,
            'workstream_name' => 'Main',
            'trading_id' => $unit->id,
            'status' => 'ACTIVE'
        ]);

        UserApp::create([
            'app_name' => 'Service Provider',
            'status' => 1,
            'vender_id' => $user['id'],
            'role_id' => $app_role['id']
        ]);
        UserApp::create([
            'app_name' => 'Business Manager',
            'status' => 1,
            'vender_id' => $user['id'],
            'role_id' => $business_role['id']
        ]);

        UserTradingUnit::create([
            'user_id' => $user->id,
            'trading_id' => $unit->id,

        ]);

         TradingUnitAppSetting::create([

            'trading_id' => $unit['id'],
            'site_id' => $unit['site_id'] ?? '0',
            'header_option' => $unit['trading_template'],
            'address_line_1' => $site['address_line_1'] ?? ' ',
            'address_line_2' => $site['address_line_2'] ?? ' ',
            'address_line_3' => $site['address_line_3'] ?? ' ',
            'address_line_4' => $site['address_line_4'] ?? ' ',
            'city' => $unit['city'],
            'postcode' => $unit['postcode'],
            'landline' => $unit['landline'],
            'mobile' => $unit['mobile'],



        ]);




        User::find($id)->update([
            'application_status' => 'ACCEPTED'
        ]);







        vendorProfile::where('vender_id', $id)->update([
            'step' => 11,
            'business_status' => 1,
            'trading_name_status' => 1,
            'vat_status' => 1,
            'business_activities_status' => 1,
            'main_account_status' => 1,
            'subscription_status' => 1,
            'trade_unit_status' => 1,
            'bank_status' => 1,
        ]);
        $user = User::find($id);

        VenderAddress::where('vender_id', $id)->update([
            'status' => 'Verified'
        ]);

        Mail::send('email.vendor_status', [
            'vendor' => $user,
            'status' => 1
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject(
                    'Your Profile Has Been Approved'
                );
        });

        return redirect()->back()->with('success', 'Application Accept Successfully');
    }
    public function applicationDecline($id, Request $request)
    {


        User::find($id)->update([
            'application_status' => 'DECLINE',
            'note' => $request->reason
        ]);
        $user = User::find($id);
        Mail::send('email.vendor_status', [
            'vendor' => $user,
            'status' => 2
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject(
                    'Your Profile Has Been Decline'
                );
        });


        return redirect()->back()->with('success', 'Application Decline Successfully');
    }
    public function applicationRequestInfo($id, Request $request)
    {
        // return $request->all();


        User::find($id)->update([
            'application_status' => 'Request for Info',
            'note' => $request->reason
        ]);
        $user = User::find($id);
        Mail::send('email.vendor_status', [
            'vendor' => $user,
            'status' => 2
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject(
                    'Your Profile Has Been Request For More Information'
                );
        });


        return redirect()->back()->with('success', 'Application Request For Info Successfully');
    }


    // MainAccount Info

    public function bankInfo($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.bank', get_defined_vars());
    }
    public function bankInfoVerify($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.application.bank_verify', get_defined_vars());
    }
    public function bankVerify($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'bank_status_verify' => 1
        ]);



        return redirect()->back()->with('success', 'Bank Accept Successfully');
    }
    public function bankDecline($id)
    {


        VendorProfile::where('vender_id', $id)->update([
            'bank_status_verify' => 3
        ]);

        return redirect()->back()->with('success', 'Bank Decline Successfully');
    }
}
