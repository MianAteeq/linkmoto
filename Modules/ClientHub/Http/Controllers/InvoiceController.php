<?php

namespace Modules\ClientHub\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vender\Entities\Booking;
use Modules\Vender\Entities\BookingTransaction;
use Modules\Vender\Entities\Invoice;
use Modules\Vender\Entities\TradingUnit;

class InvoiceController extends Controller
{
    public function getInvoices(Request $request)
    {
        try {




            $invoices = Invoice::with([
                'booking',
                'booking.contact_detail',
                'booking.service',
                'booking.job_requests',
                'booking.job_requests.job_type',
                'booking.booking_items',
                'booking.booking_items.job_types',
                'booking.booking_items.job_types.job_type',
                'booking.vehicle.vehicle_model',
                'booking.vehicle.vehicle_make',
                'booking.vehicle.engine_size',
                'booking.vehicle.transmission_type',
                'booking.vehicle.fuel_type',
                'booking.vehicle.color',
                'booking.trading_name.trading_name',
                'booking.vender.profile',
                'payment',
                'payments',
            ])->whereHas('contact', function ($q) use ($request) {
                $q->where('hub_id', '=', $request->user()->id);
            })->latest('id')->limit(50)->get();
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

            // $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $invoices = Invoice::with([
                'booking',
                'booking.contact_detail',
                'booking.service',
                'booking.job_requests',
                'booking.job_requests.job_type',
                'booking.booking_items',
                'booking.booking_items.job_types',
                'booking.booking_items.job_types.job_type',
                'booking.vehicle.vehicle_model',
                'booking.vehicle.vehicle_make',
                'booking.vehicle.engine_size',
                'booking.vehicle.transmission_type',
                'booking.vehicle.fuel_type',
                'booking.vehicle.color',
                'booking.trading_name.trading_name',
                'booking.vender.profile',
                'payment',
                'payments',
                'booking.booking_items.price_type',
            ])->find($request['invoice_id']);

            if ($invoices && $invoices->booking) {
                $invoices['invoice_item'] = $invoices['booking']['booking_items'];
            }
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

            // $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $invoices = Invoice::with([
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
                'payments',
            ])->whereHas('contact', function ($q) use ($request) {
                $q->where('hub_id', '=', $request->user()->id);
            })->find($request['invoice_id']);

            if (!$invoices) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invoice not found',
                ], 404);
            }

            $fileExists = false;
            if (!empty($invoices->invoice_path)) {
                $fileName = basename($invoices->invoice_path);
                $filePath = public_path('pdf/' . $fileName);
                $fileExists = file_exists($filePath);
            }

            if ($invoices->invoice_path != null && $fileExists) {
                return response()->json([
                    'status' => true,
                    'invoice' => $invoices->invoice_path,
                    'message' => "Invoice Pdf Fetch Successfully",
                ]);
            }

            $folder = public_path('pdf/');
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $trading_unit = $invoices->booking ? TradingUnit::find($invoices->booking->trading_id) : null;
            $vender = User::with('profile')->find($invoices->vender_id);
            $profile = $vender ? $vender->profile : null;

            $item_array = $invoices->booking ? ($invoices->booking->booking_items ?? []) : [];
            $first_array = [];
            $second_array = [];
            $third_array = [];
            $count = 0;

            foreach ($item_array as $key => $value) {
                if ($count <= 9) {
                    $first_array[$key] = $value;
                    $first_array[$key]['totalPrice'] = $value['total_price'];
                    if ($value['is_inclusive'] == 1 && !empty($value['qty'])) {
                        $first_array[$key]['unit_price'] = $value['unit_price'] - ($value['vat_price'] / $value['qty']);
                    }
                } else if ($count <= 19) {
                    $second_array[$key] = $value;
                    $second_array[$key]['totalPrice'] = $value['total_price'];
                    if ($value['is_inclusive'] == 1 && !empty($value['qty'])) {
                        $second_array[$key]['unit_price'] = $value['unit_price'] - ($value['vat_price'] / $value['qty']);
                    }
                } else {
                    $third_array[$key] = $value;
                    $third_array[$key]['totalPrice'] = $value['total_price'];
                    if ($value['is_inclusive'] == 1 && !empty($value['qty'])) {
                        $third_array[$key]['unit_price'] = $value['unit_price'] - ($value['vat_price'] / $value['qty']);
                    }
                }
                $count++;
            }

            $data = [
                'invoice' => $invoices,
                'vender' => $vender,
                'item_array' => $item_array,
                'first_array' => $first_array,
                'second_array' => $second_array,
                'third_array' => $third_array,
                'trading_unit' => $trading_unit,
                'profile' => $profile,
            ];

            $pdf = Pdf::loadView('pdf.invoice', $data);
            $content = $pdf->download()->getOriginalContent();
            $filename = ($invoices['invoice_no'] ?: 'INV-' . $invoices->id) . '_' . time() . ".pdf";
            file_put_contents($folder . $filename, $content);

            return response()->json([
                'status' => true,
                'invoice' => asset('pdf/' . $filename),
                'message' => "Invoice Pdf Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Invoice",
            ]);
        }
    }

    public function fetchSinglePayment(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'payment_id' => ['required'],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ]);
            }

            $payment = BookingTransaction::with([
                'invoice',
                'invoice.booking',
                'invoice.booking.trading_name.trading_name',
                'invoice.booking.vender.profile',
            ])->whereHas('invoice.contact', function ($q) use ($request) {
                $q->where('hub_id', '=', $request->user()->id);
            })->find($request['payment_id']);

            if (!$payment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not found',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'payment' => $payment,
                'message' => "Payment Fetch Successfully",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Payment",
            ]);
        }
    }

    public function fetchPaymentPdf(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'payment_id' => ['required'],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ]);
            }

            $transaction = BookingTransaction::with(['invoice', 'invoice.booking'])
                ->whereHas('invoice.contact', function ($q) use ($request) {
                    $q->where('hub_id', '=', $request->user()->id);
                })
                ->find($request['payment_id']);

            if (!$transaction) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not found',
                ], 404);
            }

            $folder = public_path('pdf/');
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $trading_unit = ($transaction->invoice && $transaction->invoice->booking)
                ? TradingUnit::find($transaction->invoice->booking->trading_id)
                : null;
            $vender = User::with('profile')->find($transaction->vender_id);
            $profile = $vender ? $vender->profile : null;

            $item_array = [];
            $first_array = [];
            $second_array = [];
            $third_array = [];

            $book_invoice = Invoice::with([
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
                'job_logs',
            ])->find($transaction->invoice_id);

            $data = [
                'invoice' => $transaction,
                'book_invoice' => $book_invoice,
                'trading_unit' => $trading_unit,
                'profile' => $profile,
                'vender' => $vender,
                'item_array' => $item_array,
                'first_array' => $first_array,
                'second_array' => $second_array,
                'third_array' => $third_array,
            ];

            $pdf = Pdf::loadView('pdf.payment', $data);
            $content = $pdf->download()->getOriginalContent();
            $filename = ($transaction['pay_no'] ?: 'PAY-' . $transaction->id) . '_' . time() . ".pdf";
            file_put_contents($folder . $filename, $content);

            return response()->json([
                'status' => true,
                'payment_pdf' => asset('pdf/' . $filename),
                'invoice' => asset('pdf/' . $filename),
                'message' => "Payment Pdf Fetch Successfully",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Payment PDF",
            ]);
        }
    }

    public function payInvoice(Request $request)
    {
        try {

            $validator = \Validator::make($request->all(), [
                'invoice_id' =>  ['required'],
                'payment_date' =>  ['required', 'date'],
                'payment_type' =>  ['required'],
                'payment_method' =>  ['required'],
                'amount' =>  ['required', 'numeric'],

            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }

            $vender_id = $request->user()->id;

            $invoice = Invoice::find($request['invoice_id']);

            if (isset($invoice)) {

                if ($invoice['status'] == "PAID") {
                    return response()->json([
                        'status' => false,
                        'message' => "Invoice Already Paid",
                    ]);
                }
                BookingTransaction::create([
                    'vender_id' => $invoice->vender_id,
                    'contact_id' => $invoice->contact_id,
                    'invoice_id' => $request['invoice_id'],
                    'payment_date' => $request['payment_date'],
                    'payment_type' => $request['payment_type'],
                    'payment_method' => $request['payment_method'],
                    'amount' => $request['amount'],
                    'payment_ref' => $request['payment_ref'],
                    'payment_id' => $request['payment_id']??null,
                ]);

                $invoice->status = "PAID";
                $invoice->update();


                return response()->json([
                    'status' => true,
                    'message' => "Invoice Paid Successfully",
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Error while Paying Invoice",
                ]);
            }
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Paying Invoice",
            ]);
        }
    }

    public function paymentIntent(Request $request)
    {
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        $paymentIntent=    $stripe->paymentIntents->create([
            'amount' => 2000,
            'currency' => 'gbp',
            'payment_method_types' => ['card'],
        ]);
        echo json_encode(
            [
                'paymentIntent' => $paymentIntent->client_secret,
                // 'ephemeralKey' => $ephemeralKey->secret,

                'publishableKey' => env('STRIPE_KEY')
            ]
        );
        http_response_code(200);
        }

}
