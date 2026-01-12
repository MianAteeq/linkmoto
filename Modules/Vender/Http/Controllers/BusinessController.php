<?php

namespace Modules\Vender\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vender\Entities\VenderAddress;
use Modules\Vender\Entities\VendorProfile;

class BusinessController extends Controller
{
    public function businessDetail()
    {


        $user = auth()->user();




        return view('vender::business.detail', get_defined_vars());
    }
    public function verfication()
    {


        $user = auth()->user();
        $users = collect($user['accounts'])->where('type', '!=', 'App');
        $sites =  VenderAddress::orderBy('is_change', 'desc')->where('vender_id', $user['id'])->get();
        $banks = BankAccount::where('vender_id', $user['id'])->get();




        return view('vender::business.verification', get_defined_vars());
    }

    public function businessInformation()
    {


        $user = auth()->user();




        return view('vender::business.business_information', get_defined_vars());
    }
    public function businessInformationEdit()
    {


        $user = auth()->user();




        return view('vender::business.business_information_edit', get_defined_vars());
    }
    public function businessInformationUpdate(Request $request)
    {

        // return $request;

        $user = auth()->user();

        $filePath = $user['profile']['document_proof'];
        $fileName = $user['profile']['document_proof_name'];;
        if ($request->hasFile('document_proof')) {
            $file = $request->file('document_proof');
            $fileName = $file->getClientOriginalName();
            $fileNames = time() . '_' . $file->getClientOriginalName();
            $filePath = $request->file('document_proof')->move('uploads', $fileNames);
        }

        $tradingfilePath = $user['profile']['trading_activity'];
        if ($request->hasFile('trading_activity')) {
            $file = $request->file('trading_activity');
            $fileName = $file->getClientOriginalName();

            $tradingfilePath = $request->file('trading_activity')->move('uploads', $fileName);
        }

        VendorProfile::where('vender_id', $user['id'])->update([

            'document_proof' => $filePath,
            'trading_activity' => $tradingfilePath,
            'document_proof_name' => $fileName ?? '',
            'business_info' => 'Pending'
        ]);




        return redirect()->route('vender.business.information')->with('message', 'Business Info Save  Successfully ');
    }

    public function businessVAT()
    {


        $user = auth()->user();

        if ($user['profile']['vat_register'] == 'NO') {
            $user['profile']['vat_info'] = "Verified";
        }
        
        // return $user['profile'];




        return view('vender::business.vat', get_defined_vars());
    }
    public function businessVATedit()
    {


        $user = auth()->user();

        if ($user['profile']['vat_register'] == 'NO') {
            $user['profile']['vat_info'] = "Verified";
        }






        return view('vender::business.vat_edit', get_defined_vars());
    }
    public function businessVATupdate(Request $request)
    {


        $user = auth()->user();

        VendorProfile::where('vender_id', $user['id'])->update([

            'vat_register' => $request['vat_register'],
            'uk_vat_no' => $request['uk_vat_no'],

            'vat_info' => $request['vat_register'] == 'NO' ? 'Verified' : "Pending"
        ]);




        return redirect()->route('vender.business.vat')->with('message', 'VAT Info Save  Successfully ');
    }
}
