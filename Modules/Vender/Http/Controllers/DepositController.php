<?php

namespace Modules\Vender\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vender\Entities\Deposit;

class DepositController extends Controller
{
     /***********  Save Job Request    ***************/

   public function saveDeposit(Request $request)
     {

         // return $request;

        //  try {
             $validator = \Validator::make($request->all(), [
                 'booking_id' =>  ['required'],
                 'contact_id' =>  ['required'],
                 'amount' =>  ['required'],
                 'payment_method' =>  ['required'],

             ]);

             if ($validator->fails()) {

                 $responseArr['message'] = $validator->errors()->first();
                 $responseArr['token'] = '';
                 return response()->json($responseArr);
             }


             $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
             $latestOrder = Deposit::orderBy('created_at', 'DESC')->first();

             $obj = Deposit::create([
                 "vender_id" => $vender_id,
                 "deposit_no" => 'DP-'."SVP".str_pad($vender_id, 5, "0", STR_PAD_LEFT)."-". str_pad($latestOrder?$latestOrder->id+1: 0 + 1, 5, "0", STR_PAD_LEFT),
                 "booking_id" => $request->booking_id,
                 "contact_id"=>$request->contact_id??null,
                 "amount" => $request->amount,
                 "payment_method" => $request->payment_method,
                 "deposit_date" => $request->deposit_date,
                 "note" => $request->note,

             ]);


             $job_request = Deposit::find($obj->id);

             return response()->json([
                 'status' => true,
                 'deposit' => $job_request,
                 'message' => "Deposit Added Successfully",
             ]);
        //  } catch (Exception $e) {

        //      return response()->json([
        //          'status' => false,
        //          'error' => $e->getMessage(),
        //          'message' => "Error while Add Deposit",
        //      ]);
        //  }
     }


     public function updateDeposit(Request $request)
     {

         try {
             $validator = \Validator::make($request->all(), [
                'booking_id' =>  ['required'],
                'contact_id' =>  ['required'],
                'amount' =>  ['required'],
                'payment_method' =>  ['required'],

             ]);

             if ($validator->fails()) {

                 $responseArr['message'] = $validator->errors()->first();
                 $responseArr['token'] = '';
                 return response()->json($responseArr);
             }


             $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;


             $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
             $latestOrder = Deposit::orderBy('created_at', 'DESC')->first();

             $obj = Deposit::find($request['deposit_id'])->update([
                 "booking_id" => $request->booking_id,
                 "contact_id"=>$request->contact_id??null,
                 "amount" => $request->amount,
                 "payment_method" => $request->payment_method,
                 "deposit_date" => $request->deposit_date,
                 "note" => $request->note,

             ]);

             $job_request = Deposit::find($request['deposit_id']);

             return response()->json([
                 'status' => true,
                 'deposit' => $job_request,
                 'message' => "Deposit Update Successfully",
             ]);
         } catch (Exception $e) {

             return response()->json([
                 'status' => false,
                 'error' => $e->getMessage(),
                 'message' => "Error while Update Deposit",
             ]);
         }
     }

     public function deleteDeposit(Request $request)
     {

         try {


             $job_request = Deposit::find($request->deposit_id);


             if ($job_request) {
                 $job_request->delete();
                 return response()->json([
                     'status' => true,

                     'message' => "Deposit Delete Successfully",
                 ]);
             } else {
                 return response()->json([
                     'status' => false,

                     'message' => "Deposit Not Found",
                 ]);
             }
         } catch (Exception $e) {

             return response()->json([
                 'status' => false,
                 'error' => $e->getMessage(),
                 'message' => "Error while Add Deposit",
             ]);
         }
     }

     public function getJobRequests(Request $request)
     {



             $job_request = Deposit::where('booking_id',$request->booking_id)->get();

             if(count($job_request)>0){
                 return response()->json([
                     'status' => true,
                     'job_requests' => $job_request,
                     'message' => "Deposit Fetch Successfully",
                 ]);

             }else{
                 return response()->json([
                     'status' => false,
                     'job_requests' =>[],
                     'message' => "Deposit Not Found",
                 ]);

             }


     }
}
