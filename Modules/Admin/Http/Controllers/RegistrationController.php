<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Support\Renderable;
use Modules\Vender\Entities\VenderAddress;
use Modules\Vender\Entities\VendorProfile;

class RegistrationController extends Controller
{
    public function prospects()
    {


        return view('admin::admin.registration.prospects');
    }
    public function interests()
    {


        $users = User::whereIn('status', ['NEW', 'ACCEPTED', 'DECLINE'])->latest()->get();

        return view('admin::admin.registration.interest', get_defined_vars());
    }
    public function register()
    {


        $users = User::whereIn('application_status', ['ACCEPTED', 'INACTIVE'])->where('vender_id', 0)->latest()->get();


        return view('admin::admin.registration.register', get_defined_vars());
    }
    public function registerDetail($id)
    {


        $user = User::with('profile')->find($id);
        // return $user['profile']['phone_no'];
        $users = $user['accounts'];
        $tarding_names = $user['trading_names'];
        $sites = $user['sites'];
        $banks = BankAccount::where('vender_id', $user['id'])->get();

        return view('admin::admin.registration.register_detail', get_defined_vars());
    }
    public function registerDetailSite($id)
    {


        $site = VenderAddress::find($id);

        return view('admin::admin.registration.mian_account.site', get_defined_vars());
    }

    public function registerDetailSiteVerify($id)
    {



        VenderAddress::find($id)->update([
            'status' => 'Verified'
        ]);

        return redirect()->back()->with('success', 'Site Verified Successfully');
    }
    public function registerDetailSiteRejected($id)
    {


        VenderAddress::find($id)->update([
            'status' => 'Rejected'
        ]);

        return redirect()->back()->with('success', 'Site Rejected Successfully');
    }
    public function registerDetailBank($id)
    {


        $site = BankAccount::find($id);

        return view('admin::admin.registration.mian_account.bank', get_defined_vars());
    }

    public function registerDetailBankVerify($id)
    {



        BankAccount::find($id)->update([
            'status' => 'Verified'
        ]);

        return redirect()->back()->with('success', 'Bank Verified Successfully');
    }
    public function registerDetailBankRejected($id)
    {


        BankAccount::find($id)->update([
            'status' => 'Rejected'
        ]);

        return redirect()->back()->with('success', 'Bank Rejected Successfully');
    }
    public function registerDetailMianContact($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.mian_account.view', get_defined_vars());
    }
    public function registerDetailVerify($id)
    {


        $user = User::find($id);
        VendorProfile::where('vender_id', $id)->update([
            'business_info' => 'Verified'
        ]);

        return redirect()->back()->with('success', 'business information Verified Successfully');
    }
    public function registerDetailMianContactVerify($id)
    {


        $user = User::find($id)->update([
            'user_verified' => 'Verified'
        ]);

        return redirect()->back()->with('success', 'User Verified Successfully');
    }

    public function registerDetailMianContactRejected($id)
    {


        $user = User::find($id)->update([
            'user_verified' => 'Rejected'
        ]);

        return redirect()->back()->with('success', 'User Rejected Successfully');
    }
    public function registerDetailRejected($id)
    {


        $user = User::find($id);
        VendorProfile::where('vender_id', $id)->update([
            'business_info' => 'Rejected'
        ]);

        return redirect()->back()->with('success', 'business information Reject Successfully');
    }
    public function registerDetailVatVerify($id)
    {


        $user = User::find($id);
        VendorProfile::where('vender_id', $id)->update([
            'vat_info' => 'Verified'
        ]);

        return redirect()->back()->with('success', 'business vat Verified Successfully');
    }
    public function registerDetailVatRejected($id)
    {


        $user = User::find($id);
        VendorProfile::where('vender_id', $id)->update([
            'vat_info' => 'Rejected'
        ]);

        return redirect()->back()->with('success', 'business vat Reject Successfully');
    }
    public function interestDetail($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.interest_detail', get_defined_vars());
    }
    public function interestBusinessDetail($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.interest_detail_business', get_defined_vars());
    }
    public function interestContactDetail($id)
    {


        $user = User::find($id);

        return view('admin::admin.registration.interest_detail_contact', get_defined_vars());
    }
    public function interestAccept($id)
    {


        User::find($id)->update([
            'status' => 'ACCEPTED'
        ]);
        $user = User::find($id);

        Mail::send('email.interest_accept', get_defined_vars(), function ($send) use ($user) {
            $send->to($user['email'])->subject("Interest Accepted Email");
        });

        return redirect()->back()->with('success', 'Interest Accept Successfully');
    }
    public function registerInActive($id)
    {


        User::find($id)->update([
            'application_status' => 'INACTIVE'
        ]);
        $user = User::find($id);

        // Mail::send('email.interest_accept', get_defined_vars(), function ($send) use ($user) {
        //     $send->to($user['email'])->subject("Interest Accepted Email");
        // });

        return redirect()->back()->with('success', 'Profile IN ACTIVE Successfully');
    }
    public function registerActive($id)
    {


        User::find($id)->update([
            'application_status' => 'ACCEPTED'
        ]);
        $user = User::find($id);

        // Mail::send('email.interest_accept', get_defined_vars(), function ($send) use ($user) {
        //     $send->to($user['email'])->subject("Interest Accepted Email");
        // });

        return redirect()->back()->with('success', 'Profile IN ACTIVE Successfully');
    }
    public function interestDecline($id)
    {



        User::find($id)->update([
            'status' => 'DECLINE'
        ]);


        return redirect()->back()->with('success', 'Interest Decline Successfully');
    }
}
