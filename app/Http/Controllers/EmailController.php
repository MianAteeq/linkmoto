<?php

namespace App\Http\Controllers;

use App\Models\EmailAddress;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function Mail()
    {



        $user = auth()->user();



        $banks = EmailAddress::where('vender_id', $user['id'])->get();


        return view('vender::business.mail.index', get_defined_vars());
    }
    public function addMail()
    {



        $user = auth()->user();




        return view('vender::business.mail.add', get_defined_vars());
    }
    public function MailView($id)
    {



        $site = EmailAddress::find($id);


        return view('vender::business.mail.view', get_defined_vars());
    }
    public function MailEdit($id)
    {



        $site = EmailAddress::find($id);




        return view('vender::business.mail.edit', get_defined_vars());
    }
    public function storeMail(Request $request)
    {
         $validator = \Validator::make($request->all(), [
        'email' => ['required', 'email', 'max:255'],
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

        $user = auth()->user();




        EmailAddress::create([
            ...$request->all(),
            'vender_id' => $user['id'],

        ]);


        return redirect()->route('vender.mail');
    }
    public function updateMail(Request $request)
    {
         $validator = \Validator::make($request->all(), [
        'email' => ['required', 'email', 'max:255'],
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

        $site = EmailAddress::find($request['id']);


        EmailAddress::find($request['id'])->update([
            ...$request->all(),
        ]);


        return redirect()->route('vender.mail');
    }
}
