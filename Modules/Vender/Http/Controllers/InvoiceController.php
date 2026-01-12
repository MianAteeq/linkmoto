<?php

namespace Modules\Vender\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vender\Entities\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Modules\Vender\Entities\Booking;
use Modules\Vender\Entities\BookingTransaction;
// use App\Models\User;
use stdClass;
use Illuminate\Support\Facades\Log as InLog;


class InvoiceController extends Controller
{
    public function getInvoices(Request $request)
    {
        try {


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            $trading_id = User::find($request->user()->id)['default_trading_unit'];

            $invoices = Invoice::with(['booking', 'booking.contact_detail', 'booking.service', 'booking.job_requests', 'booking.booking_items', 'booking.vehicle.vehicle_model', 'booking.vehicle.vehicle_make', 'booking.vehicle.engine_size', 'booking.vehicle.transmission_type', 'booking.vehicle.fuel_type', 'booking.vehicle.color', 'payment', 'payments'])->where('vender_id', $vender_id)->where('trading_id', $trading_id)->orderBy('invoice_date','desc')->get();
            return response()->json([
                'status' => true,
                'invoices' => $invoices,
                'message' => "Invoice Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Invoice",
            ]);
        }
    }
    public function fetchSingleInvoice(Request $request)
    {
        try {

            $validator = \Validator::make($request->all(), [
                'invoice_id' =>  ['required'],


            ]);
            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }

            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $invoices = Invoice::with(['booking', 'booking.contact_detail', 'booking.service', 'booking.job_requests', 'booking.booking_items', 'booking.booking_items.price_type', 'booking.vehicle.vehicle_model', 'booking.vehicle.vehicle_make', 'booking.vehicle.engine_size', 'booking.vehicle.transmission_type', 'booking.vehicle.fuel_type', 'booking.vehicle.color', 'payment', 'payments', 'job_logs','booking.booking_items.job_types', 'booking.booking_items.job_types.job_type'])->where('vender_id', $vender_id)->find($request['invoice_id']);

            $invoices['invoice_item'] = $invoices['booking']['booking_items'];
            $invoices['invoice_item'] = $invoices['booking']['booking_items'];
            return response()->json([
                'status' => true,
                'invoice' => $invoices,
                'message' => "Invoice Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Invoice",
            ]);
        }
    }
 public function sendMail(Request $request)
{
    try {
        // 1️⃣ Validate input
        $validator = \Validator::make($request->all(), [
            'invoice_id' => ['required'],
            'email'      => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        // 2️⃣ Determine vendor ID
        $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

        // 3️⃣ Load invoice with relationships
        $invoice = Invoice::with([
            'booking',
            'trading_name',
            'trading_name.app_setting',
            'booking.contact_detail',
            'booking.service',
            'booking.job_requests',
            'booking.booking_items',
            'booking.booking_items.price_type',
            'booking.vehicle.vehicle_model',
            'booking.vehicle.vehicle_make',
            'booking.vehicle.engine_size',
            'booking.vehicle.transmission_type',
            'booking.vehicle.fuel_type',
            'booking.vehicle.color',
            'payment',
            'payments',
            'job_logs'
        ])->where('vender_id', $vender_id)->find($request->invoice_id);

        if (!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'Invoice not found.',
            ]);
        }

        // 4️⃣ Load vendor info
        $vender = User::with('profile')->find(auth()->user()->id);

        // 5️⃣ Ensure invoice file exists
       $files = [];
$invoicePath = $invoice['invoice_path'];

// Remove domain if it's a full URL
$relativePath = parse_url($invoicePath, PHP_URL_PATH); // e.g., /pdf/INV-TRU00048-00280_1765775201.pdf

$fullPath = public_path($relativePath); // e.g., /home2/.../public/pdf/INV-TRU00048-00280_1765775201.pdf

if (file_exists($fullPath)) {
    $files[] = $fullPath;
} else {
    InLog::error('Invoice file not found', ['path' => $fullPath]);
}

        // 6️⃣ Prepare data for email (keep objects for Blade)
        $data = [
            'invoice' => $invoice, // object for optional() in Blade
            'vender'  => $vender,  // object
        ];

        // 7️⃣ Log info safely (convert trading_name to array for logging)
        $tradingName = $invoice->trading_name ? $invoice->trading_name->toArray() : [];

        InLog::info('Invoice email sending', [
            
            'file'        => $invoice['trading_name']['app_setting'],
        ]);

        // 8️⃣ Send email
        Mail::send('email.invoice', $data, function ($message) use ($data, $files, $request) {
            $message->to($request->email)
                ->subject('Invoice Reminder');

            foreach ($files as $file) {
                $message->attach($file);
            }
        });

        // 9️⃣ Log success
        InLog::info('Invoice email sent successfully', [
            'invoice_id' => $invoice->id,
            'vender_id'  => $vender->id,
            'email'      => $request->email,
        ]);

        return response()->json([
            'status' => true,
            'invoice' => $invoice,
            'message' => "Invoice Email Sent Successfully",
        ]);

    } catch (\Exception $e) {
        // 10️⃣ Log failure
        InLog::error('Invoice email failed', [
            'invoice_id' => $invoice->id ?? null,
            'vender_id'  => auth()->user()->id ?? null,
            'email'      => $request->email ?? 'N/A',
            'error'      => $e->getMessage(),
        ]);

        return response()->json([
            'status' => false,
            'error' => $e->getMessage(),
            'message' => "Error while sending Invoice",
        ]);
    }
}

    public function sendPaymentMail(Request $request)
    {
        try {

            $validator = \Validator::make($request->all(), [
                'payment_id' =>  ['required'],


            ]);
            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }

            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $invoices = BookingTransaction::with('invoice')->where('vender_id', $vender_id)->find($request['payment_id']);

            $item_array = [];



            $first_array = [];
            $second_array = [];
            $third_array = [];
            $count = 0;

             foreach ($item_array as $key => $value) {
        if ($count <= 9) {
            $first_array[$key] = $value;
            $first_array[$key]['exlusive_vat'] = $value['sub_total_ex_vat'];
            $first_array[$key]['totalPrice'] = $value['total_price'];
        } else if ($count <= 19) {
            $second_array[$key] = $value;
              $second_array[$key]['exlusive_vat'] = $value['sub_total_ex_vat'];
            $second_array[$key]['totalPrice'] = $value['total_price'];
        } else {
            $third_array[$key] = $value;
             $third_array[$key]['exlusive_vat'] = $value['sub_total_ex_vat'];
            $third_array[$key]['totalPrice'] = $value['total_price'];
        }

        $count++;
    }

            $data = [
                'invoice'    => $invoices,
                'vender' => User::with('profile')->find(auth()->user()->id),
                'item_array' => $item_array,
                'first_array' => $first_array,
                'second_array' => $second_array,
                'third_array' => $third_array,
            ];
            $pdf = Pdf::loadView('pdf.payment',$data);
            $content = $pdf->download()->getOriginalContent();
            file_put_contents('pdf/' . $invoices['pay_no'].time()  . ".pdf", $content);
            $files = [

                public_path('pdf/' . $invoices['pay_no'] . time() . ".pdf"),
            ];
            Mail::send('email.payment', $data, function ($message) use ($data, $files,$request) {
                $message->to($request["email"])
                    ->subject('Payment Receipt');

                foreach ($files as $file) {
                    $message->attach($file);
                }
            });
            return response()->json([
                'status' => true,
                'invoice' => $invoices,
                'message' => "Payment Receipt Email Send Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Invoice",
            ]);
        }
    }

    public function fetchInvoicePdf(Request $request)
    {
        try {

            $validator = \Validator::make($request->all(), [
                'invoice_id' =>  ['required'],


            ]);
            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }

            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $invoices = Invoice::with(['booking', 'booking.contact_detail', 'booking.service', 'booking.job_requests', 'booking.booking_items', 'booking.vehicle.vehicle_model', 'booking.vehicle.vehicle_make', 'booking.vehicle.engine_size', 'booking.vehicle.transmission_type', 'booking.vehicle.fuel_type', 'booking.vehicle.color', 'payments'])->where('vender_id', $vender_id)->find($request['invoice_id']);
            if($invoices['invoice_path']==null){
                
            
            $item_array = $invoices['booking']['booking_items'];

            $first_array = [];
            $second_array = [];
            $third_array = [];
            $count = 0;

            foreach ($item_array as $key => $value) {
                if ($count <= 9) {
                    $first_array[$key] = $value;
                    $first_array[$key]['totalPrice'] = $value['total_price'];
                } else if ($count <= 19) {
                    $second_array[$key] = $value;
                    $second_array[$key]['totalPrice'] = $value['total_price'];
                } else {
                    $third_array[$key] = $value;
                    $third_array[$key]['totalPrice'] = $value['total_price'];
                }

                $count++;
            }





            // return User::with('profile')->find(auth()->user()->id);
            $data = [
                'invoice'    => $invoices,
                'vender' => User::with('profile')->find(auth()->user()->id),
                'item_array' => $item_array,
                'first_array' => $first_array,
                'second_array' => $second_array,
                'third_array' => $third_array,
            ];

            //     // return $records;
            //     $data = [
            //         'invoice'    => $invoices,
            //         'vender'=>User::with('profile')->find(auth()->user()->id),
            //         'item_array'=>$item_array
            //    ];
            $pdf = Pdf::loadView('pdf.invoice', $data);
            $content = $pdf->download()->getOriginalContent();
            file_put_contents('pdf/' . $invoices['invoice_no'] . time()  . ".pdf", $content);

            return response()->json([
                'status' => true,
                'invoice' => asset('pdf/' . $invoices['invoice_no'] . time() . ".pdf"),
                // 'invoice' => $pdf->download('invoice.pdf'),

                'message' => "Invoice Pdf Fetch Successfully",
            ]);
            }else{
                 return response()->json([
                'status' => true,
                'invoice' =>$invoices['invoice_path'] ,
                // 'invoice' => $pdf->download('invoice.pdf'),

                'message' => "Invoice Pdf Fetch Successfully",
            ]);
            }
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Invoice",
            ]);
        }
    }
    public function fetchPaymentPdf(Request $request)
    {
        try {

            $validator = \Validator::make($request->all(), [
                'payment_id' =>  ['required'],


            ]);
            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }

            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $invoices = BookingTransaction::with('invoice')->where('vender_id', $vender_id)->find($request['payment_id']);;
            $item_array = [];

            $first_array = [];
            $second_array = [];
            $third_array = [];
            $count = 0;

            foreach ($item_array as $key => $value) {
        if ($count <= 9) {
            $first_array[$key] = $value;
            $first_array[$key]['exlusive_vat'] = $value['sub_total_ex_vat'];
            $first_array[$key]['totalPrice'] = $value['total_price'];
        } else if ($count <= 19) {
            $second_array[$key] = $value;
              $second_array[$key]['exlusive_vat'] = $value['sub_total_ex_vat'];
            $second_array[$key]['totalPrice'] = $value['total_price'];
        } else {
            $third_array[$key] = $value;
             $third_array[$key]['exlusive_vat'] = $value['sub_total_ex_vat'];
            $third_array[$key]['totalPrice'] = $value['total_price'];
        }

        $count++;
    }






            // return $records;
            $data = [
                'invoice'    => $invoices,
                'vender' =>  User::with('profile')->find($invoices['vender_id']),
                'item_array' => $item_array,
                'first_array' => $first_array,
                'second_array' => $second_array,
                'third_array' => $third_array,
            ];

            //     // return $records;
            //     $data = [
            //         'invoice'    => $invoices,
            //         'vender'=>User::with('profile')->find(auth()->user()->id),
            //         'item_array'=>$item_array
            //    ];
            $pdf = Pdf::loadView('pdf.payment', $data);
            $content = $pdf->download()->getOriginalContent();
            file_put_contents('pdf/' . $invoices['pay_no'] . time()  . ".pdf", $content);

            return response()->json([
                'status' => true,
                'invoice' => asset('pdf/' . $invoices['pay_no'] . time() . ".pdf"),
                // 'invoice' => $pdf->download('invoice.pdf'),

                'message' => "Payment Pdf Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Invoice",
            ]);
        }
    }


    public function index()
    {

        $vender_id = auth()->user()->id;

        $invoices = Invoice::with(['booking', 'booking.contact_detail', 'booking.service', 'booking.job_requests', 'booking.booking_items', 'booking.vehicle.vehicle_model', 'booking.vehicle.vehicle_make', 'booking.vehicle.engine_size', 'booking.vehicle.transmission_type', 'booking.vehicle.fuel_type', 'booking.vehicle.color', 'payment'])->where('vender_id', $vender_id)->limit(20)->get();





        return view('vender::invoice.index', get_defined_vars());
    }

    public function printInvoice($id)
    {
        $vender_id = auth()->user()->id;

        $invoice = Invoice::with(['booking', 'booking.contact_detail', 'booking.service', 'booking.job_requests', 'booking.booking_items', 'booking.vehicle.vehicle_model', 'booking.vehicle.vehicle_make', 'booking.vehicle.engine_size', 'booking.vehicle.transmission_type', 'booking.vehicle.fuel_type', 'booking.vehicle.color', 'payment'])->where('vender_id', $vender_id)->find($id);


        return view('vender::invoice.final_invoice', get_defined_vars());
    }


   public function payInvoice(Request $request)
{
    try {

             $validator = \Validator::make($request->all(), [
            'invoice_id'     => ['required'],
            'payment_date'   => ['required', 'date'],
            'payment_type'   => ['required', 'in:Invoice Received,Refund,Credit Note'],
            'amount'         => ['required', 'numeric', 'gt:0'],
            'payment_method' => ['required_if:payment_type,Invoice Received,Refund'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        // ---------------- VENDOR ----------------
        $vender_id = $request->user()->vender_id == 0
            ? $request->user()->id
            : $request->user()->vender_id;

        // ---------------- INVOICE ----------------
        $invoice = Invoice::with('payments')->find($request->invoice_id);

        if (!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'Invoice not found',
            ]);
        }

        if ($invoice->status === 'PAID' && $request->payment_type !== 'Refund') {
            return response()->json([
                'status' => false,
                'message' => 'Invoice already paid',
            ]);
        }

        // ---------------- NORMALIZE AMOUNT ----------------
        $amount = $request->amount;
        if (in_array($request->payment_type, ['Refund'])) {
            $amount = -abs($request->amount); // store negative
        }

        // ---------------- TOTAL PAID ----------------
        $total_paid = BookingTransaction::where('invoice_id', $invoice->id)->sum('amount');
        $new_total_paid = $total_paid + $amount;

        // ---------------- PAY NUMBER ----------------
        $lastPayment = BookingTransaction::latest('id')->first();
        $pay_number = 'PAY-SVP' . str_pad($vender_id, 5, '0', STR_PAD_LEFT)
            . '-' . str_pad(($lastPayment ? $lastPayment->id + 1 : 1), 5, '0', STR_PAD_LEFT);

        // ---------------- SAVE TRANSACTION ----------------
        BookingTransaction::create([
            'vender_id'      => $vender_id,
            'pay_no'         => $pay_number,
            'invoice_id'     => $invoice->id,
            'payment_date'   => $request->payment_date,
            'payment_type'   => $request->payment_type,
            'payment_method' => $request->payment_method,
            'amount'         => $amount,
            'payment_ref'    => $request->payment_ref,
        ]);

        // ---------------- INVOICE STATUS ----------------
        $balance = $invoice->total - $new_total_paid;

        if ($balance <= 0 && $new_total_paid > 0) {
            $invoice->status = 'PAID';
        } elseif ($balance > 0) {
            $invoice->status = 'DUE';
        } else {
            $invoice->status = 'CREDIT';
        }

        $invoice->save();

        // ---------------- LOG ----------------
        $lastLog = Log::latest('id')->first();
        $log_no = 'LOG-SVP' . str_pad($request->user()->id, 5, '0', STR_PAD_LEFT)
            . '-' . str_pad(($lastLog ? $lastLog->id + 1 : 1), 5, '0', STR_PAD_LEFT);

        Log::saveLog((object) [
            'log_no'   => $log_no,
            'user_id'  => $request->user()->id,
            'type'     => 'Invoice',
            'event'    => 'Invoice Payment',
            'event_detail' => 'Invoice payment updated',
            'type_id'  => $invoice->id,
        ]);

        // -------- PDF GENERATION ----------
        $invoice = Invoice::with([
            'booking',
            'booking.contact_detail',
            'booking.service',
            'booking.job_requests',
            'booking.booking_items',
            'booking.vehicle.vehicle_model',
            'booking.vehicle.vehicle_make',
            'booking.vehicle.engine_size',
            'booking.vehicle.transmission_type',
            'booking.vehicle.fuel_type',
            'booking.vehicle.color',
            'payments'
        ])->find($invoice->id);

        $items = $invoice->booking->booking_items;

        // SPLIT ITEMS INTO 3 ARRAYS
        $first_array = [];
        $second_array = [];
        $third_array = [];

        foreach ($items as $index => $row) {
            $row['exlusive_vat'] = $row['sub_total_ex_vat'];
            $row['totalPrice']    = $row['total_price'];

            if ($index < 10) {
                $first_array[] = $row;
            } elseif ($index < 20) {
                $second_array[] = $row;
            } else {
                $third_array[] = $row;
            }
        }
        
         InLog::error('Invoice file not found', ['path' => $first_array]);

        $data = [
            'invoice'      => $invoice,
            'vender'       => User::with('profile')->find($invoice->vender_id),
            'item_array'   => $items,
            'first_array'  => $first_array,
            'second_array' => $second_array,
            'third_array'  => $third_array,
        ];

        $pdf = Pdf::loadView('pdf.invoice', $data);
        $content = $pdf->download()->getOriginalContent();

        // SAVE PDF
        $folder = public_path("pdf/");
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $filename = $invoice->invoice_no . '_' . time() . ".pdf";
        file_put_contents($folder . $filename, $content);

        // Store PDF path in invoice
        $invoice->invoice_path = asset("pdf/" . $filename);
        $invoice->save();

        return response()->json([
            'status' => true,
            'message' => "Invoice Paid Successfully",
        ]);

    } catch (Exception $e) {

        return response()->json([
            'status'  => false,
            'error'   => $e->getMessage(),
            'message' => "Error while Paying Invoice",
        ]);
    }
}


    public function voidInvoice(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'invoice_id' =>  ['required'],


            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }
            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $invoice = Invoice::find($request['invoice_id']);

            //    Booking::find($invoice['booking_id'])->update([

            //     'status'=>'READY_FOR_COLLECTION'
            //    ]);

            Invoice::find($request['invoice_id'])->update([
                "status" => "REJECTED"
            ]);

            $latestOrder = Log::orderBy('created_at', 'DESC')->first();
            $data = new stdClass();
            $data->log_no = 'lOG-' . "SVP" . str_pad($request->user()->id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
            $data->user_id = $request->user()->id;
            $data->type = "Invoice";
            $data->event = "Invoice Void";
            $data->event_detail = "Invoice Void";
            $data->type_id = $request['invoice_id'];

            Log::saveLog($data);




            return response()->json([
                'status' => true,
                'message' => "Invoice Void Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Status Invoice ",
            ]);
        }
    }
}
