<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function bank()
    {



        $user = auth()->user();



        $banks = BankAccount::where('vender_id', $user['id'])->get();


        return view('vender::business.banks.index', get_defined_vars());
    }
    public function payout()
    {



        $user = auth()->user();



        $banks = BankAccount::where('vender_id', $user['id'])->where('is_payout', 1)->get();


        return view('vender::business.banks.payout', get_defined_vars());
    }
    public function editPayout()
    {



        $user = auth()->user();



        $banks = BankAccount::where('vender_id', $user['id'])->where('status', 'Verified')->get();


        return view('vender::business.banks.edit_payout', get_defined_vars());
    }
    public function savePayout(Request $req)
    {



        $user = auth()->user();
        BankAccount::where('vender_id', $user['id'])->update([
            'is_payout' => 0
        ]);



        $banks = BankAccount::find($req['bank_id'])->update([
            'is_payout' => 1
        ]);


        return redirect()->route('vender.payout');
    }
    public function addbank()
    {



        $user = auth()->user();




        return view('vender::business.banks.add', get_defined_vars());
    }
    public function bankView($id)
    {



        $site = BankAccount::find($id);


        return view('vender::business.banks.view', get_defined_vars());
    }
    public function bankEdit($id)
    {



        $site = BankAccount::find($id);




        return view('vender::business.banks.edit', get_defined_vars());
    }
    public function storebank(Request $request)
    {

        $user = auth()->user();
        $filePath = Null;
        $fileName = Null;
        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $fileName = $file->getClientOriginalName();
            $fileNames = time() . '_' . $file->getClientOriginalName();
            $filePath = $request->file('proof')->move('uploads', $fileNames);
        }



        BankAccount::create([
            ...$request->all(),
            'vender_id' => $user['id'],
            'proof' => $filePath,
            'status' => 'Pending'
        ]);


        return redirect()->route('vender.bank');
    }
    public function updatebank(Request $request)
    {

        $site = BankAccount::find($request['id']);
        $filePath = $site['proof'];
        $fileName = $site['proof_name'];;
        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $fileName = $file->getClientOriginalName();
            $fileNames = time() . '_' . $file->getClientOriginalName();
            $filePath = $request->file('proof')->move('uploads', $fileNames);
        }
        $address = $request['address_line_1'] . ", " . $request['city'] . ", United Kingdom " . $request['postcode'];
        // $address ="281 Clare Street, London E2 9HD";
        $result = app('geocoder')->geocode($address)->get();
        if (count($result) > 0) {
            $coordinates = $result[0]->getCoordinates();
            $lat = $coordinates->getLatitude();
            $long = $coordinates->getLongitude();
        }


        BankAccount::find($request['id'])->update([
            ...$request->all(),
            'proof' => $filePath,
            'status' => 'Pending'
        ]);


        return redirect()->route('vender.bank');
    }
    public function mainBankVerify($id)
    {


        $user = BankAccount::find($id)->update([
            'status' => 'Todo'
        ]);

        return redirect()->back()->with('message', 'Verification Cancel  Successfully ');
    }
}
