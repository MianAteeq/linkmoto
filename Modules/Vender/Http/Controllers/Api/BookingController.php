<?php

namespace Modules\Vender\Http\Controllers\Api;

use App\Models\Log;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Kutia\Larafirebase\Facades\Larafirebase;
use Modules\ClientHub\Entities\Client;
use Modules\Vender\Entities\Booking;
use Modules\Vender\Entities\BookingJobItem;
use Modules\Vender\Entities\BookingJobItemJobType;
use Modules\Vender\Entities\BookingJobRequest;
use Modules\Vender\Entities\BookingJobRequestJobType;
use Modules\Vender\Entities\CustomNotification;
use Modules\Vender\Entities\Invoice;
use Modules\Vender\Entities\Quotation;
use stdClass;
use Modules\Vender\Entities\BookingTransaction;
use Modules\Vender\Entities\Deposit;
use Modules\Vender\Entities\WorkStream;

class BookingController extends Controller
{



    // Save Booking to Draft


    public function saveBooking(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'quotation_id' =>  ['required'],
                'booking_date' =>  ['required', 'date'],
                'booking_time' =>  ['required'],

            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            $trading_id = User::find($request->user()->id)['default_trading_unit'];
            $latestOrder = Booking::orderBy('created_at', 'DESC')->first();


            $quotation = Quotation::find($request->quotation_id);

            $already_book = Booking::where('quotation_id', $request['quotation_id'])->first();

            if (isset($already_book)) {

                return response()->json([
                    'status' => false,
                    // 'booking' => $bookings,
                    'message' => "Booking already created for this Booking",
                ]);
            }
            //     'BKG-SVP' . str_pad($latestOrder->id ?? 0 + 1, 8, "0", STR_PAD_LEFT)

            $booking = Booking::create([
                "vender_id" => $vender_id,
                "trading_id" => $trading_id,
                "booking_no" => 'BKG-' . "SVP" . str_pad($vender_id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT),
                "contact_detail_id" => $quotation['contact_detail_id'],
                "vehicle_id" => $quotation['vehicle_id'],
                "service_id" => $quotation['service_id'],
                "total" => $quotation['total'],
                "sub_total" => $quotation['sub_total'],
                "vat" => $quotation['vat'],
                "status" => 'DRAFT',
                "booking_date" => $request['booking_date'],
                "booking_time" => $request['booking_time'],
                "quotation_id" => $request['quotation_id'],
            ]);

            foreach ($quotation['job_requests'] as $key => $job_request) {

                BookingJobRequest::create([
                    'booking_id' => $booking['id'],
                    ...collect($job_request)->except('quotation_id', 'created_at', 'updated_at', 'id'),

                ]);
            }
            foreach ($quotation['quotation_item'] as $key => $job_request) {

                BookingJobItem::create([
                    'booking_id' => $booking['id'],
                    ...collect($job_request)->except('quotation_id', 'created_at', 'updated_at', 'id'),

                ]);
            }


            $quotation->status = "APPROVED";
            $quotation->update();

            $latestOrder = Log::orderBy('created_at', 'DESC')->first();
            $data = new stdClass();
            $data->user_id = $vender_id;
            $data->log_no = 'lOG-' . "SVP" . str_pad($vender_id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
            $data->type = "Book";
            $data->event = "Booking Create";
            $data->event_detail = "Booking Creating ";
            $data->type_id = $booking['id'];

            Log::saveLog($data);




            $bookings = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'booking_items'
            ])->find($booking->id);

            return response()->json([
                'status' => true,
                'booking' => $bookings,
                'message' => "Booking Added Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Add Booking",
            ]);
        }
    }

    // Save Booking to Pending


    public function saveBookingPending(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'quotation_id' =>  ['required'],
                'booking_date' =>  ['required', 'date'],
                'booking_time' =>  ['required'],

            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            $trading_id = User::find($request->user()->id)['default_trading_unit'];
            $latestOrder = Booking::orderBy('created_at', 'DESC')->first();


            $quotation = Quotation::find($request->quotation_id);


            // $already_book = Booking::where('quotation_id', $request['quotation_id'])->orderBy('id', 'desc')->first();
            $already_book=null;

            if (isset($already_book)) {

                if (isset($request['booking_id'])) {

                    $booking = Booking::find($request['booking_id'])->update([
                        "vender_id" => $vender_id,
                        "booking_no" => 'BKG-' . "SVP" . str_pad($vender_id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT),
                        "contact_detail_id" => $request['contact_detail_id'],
                        "vehicle_id" => $request['vehicle_id'],
                        "service_id" => $quotation['service_id'],
                        "total" => $quotation['total'],
                        "sub_total" => $quotation['sub_total'],
                        "vat" => $quotation['vat'],
                        "status" => $request['status']==='DRAFT'?'DRAFT':'BOOKED',
                        "booking_date" => $request['booking_date'],
                        "post_code" => $request['post_code'],
                        "address_line_1" => $request['address_line_1'],
                        "address_line_2" => $request['address_line_2'],
                        "address_line_3" => $request['address_line_3'],
                        "address_line_4" => $request['address_line_4'],
                        "service_type" => $quotation['service_type'],
                        "city" => $request['city'],
                        'workstream_id'=>$request['workstream_id'],
                        'booking_time'=>$request['booking_time'],
                        "quotation_id" => $request['quotation_id'],
                    ]);

                    $quotation->status = "APPROVED";
                    $quotation->update();
                } else {

                    return response()->json([
                        'status' => false,
                        // 'booking' => $bookings,
                        'message' => "Booking already created for this Booking",
                    ]);
                }
            } else {

                $booking = Booking::create([
                    "vender_id" => $vender_id,
                    "trading_id" => $trading_id,
                    "booking_no" => 'BKG-' . "SVP" . str_pad($vender_id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT),
                    "contact_detail_id" => $quotation['contact_detail_id'],
                    "vehicle_id" => $quotation['vehicle_id'],
                    "service_id" => $quotation['service_id'],
                    "total" => $quotation['total'],
                    "sub_total" => $quotation['sub_total'],
                    "vat" => $quotation['vat'],
                    "status" => $request['status']==='DRAFT'?'DRAFT':'BOOKED',
                    "booking_date" => $request['booking_date'],
                    "booking_time" => $request['booking_time'],
                    "quotation_id" => $request['quotation_id'],
                    "post_code" => $request['postCode'],
                    "address_line_1" => $request['address_line_1'],
                    "address_line_2" => $request['address_line_2'],
                    "address_line_3" => $request['address_line_3'],
                    "address_line_4" => $request['address_line_4'],
                    "service_type" => $quotation['service_type'],
                    'workstream_id'=>$request['workstream_id'],
                    'booking_time'=>$request['booking_time'],
                    "city" => $request['city'],
                ]);

                foreach ($quotation['job_requests'] as $key => $job_request) {

                   $cleanJobRequest = collect($job_request)
                        ->except(['quotation_id', 'created_at', 'updated_at', 'id']) // exclude known fields
                        ->reject(fn($value) => is_array($value)) // remove any array values
                        ->toArray();
                    
                    $object = BookingJobRequest::create(array_merge(
                        [
                            'booking_id' => $booking['id'],
                            'quote_id' => $job_request['quotation_id'],
                        ],
                        $cleanJobRequest
                    ));

                    foreach ($job_request['job_types'] as $key => $job_type) {

                        BookingJobRequestJobType::create([
                            "job_request_id" => $object['id'],
                            "job_type_id" => $job_type['job_type_id'],

                        ]);
                        # code...
                    }
                }
                
                foreach ($quotation['quotation_item'] as $key => $job_request) {

                   $cleanJobRequest = collect($job_request)
    ->except(['quotation_id', 'created_at', 'updated_at', 'id']) // remove unwanted keys
    ->reject(fn($value) => is_array($value)) // remove any nested arrays
    ->toArray();

$obj = BookingJobItem::create(array_merge(
    [
        'booking_id' => $booking['id'],
        'quote_id' => $job_request['quotation_id'],
    ],
    $cleanJobRequest
));
                    foreach ($job_request['job_types'] as $key => $job_type) {

                        BookingJobItemJobType::create([
                            "job_item_id" => $obj['id'],
                            "job_type_id" => $job_type['job_type_id'],

                        ]);
                    }
                }


                $quotation->status = "APPROVED";
                $quotation->update();
            }


            $latestOrder = Log::orderBy('created_at', 'DESC')->first();
            $data = new stdClass();
            $data->user_id = $vender_id;
            $data->log_no = 'lOG-' . "SVP" . str_pad($vender_id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
            $data->type = "Book";
            $data->event = "Booking Create";
            $data->event_detail = "Booking Creating ";
            $data->type_id = $booking['id'];

            Log::saveLog($data);








            $bookings = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'booking_items'
            ])->find($booking->id ?? $already_book->id);

            return response()->json([
                'status' => true,
                'booking' => $bookings,
                'message' => "Booking Confirm Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => $e->getMessage(),
            ]);
        }
    }




    /***********  Get Booking    ***************/

    public function getWorkStream(Request $request)
    {

        try {


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            $trading_id = User::find($request->user()->id)['default_trading_unit'];

            $workstreams = WorkStream::where('vender_id', $vender_id)->where('trading_id', $trading_id)->where('status','Active')->orderBy('id', 'asc')->get();
          
            return response()->json([
                'status' => true,
                'workstreams' => $workstreams,

                'message' => "WorkStream Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting WorkStream",
            ]);
        }
    }
    /***********  cHANGE WorksTREAM    ***************/

    public function changeWorkStream(Request $request)
    {

        try {


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            $trading_id = User::find($request->user()->id)['default_trading_unit'];
            Booking::find($request['booking_id'])->update([
              'workstream_id'=>$request['workstream_id'],
               'status'=>'ARRIVED'
              
              ]);
          
            return response()->json([
                'status' => true,
                'message' => "WorkStream Change Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting WorkStream",
            ]);
        }
    }
    
    
    
    public function getBookingDetail(Request $request)
    {

        // try {


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            $trading_id = User::find($request->user()->id)['default_trading_unit'];

            $quotations = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'job_requests.product', 'job_requests.price_type', 'booking_items', 'booking_items.price_type',
                'job_requests.job_types', 'job_requests.job_types.job_type', 'booking_items.job_types', 'booking_items.job_types.job_type','work_stream',
            ])->where('vender_id', $vender_id)->where('trading_id', $trading_id)->whereIn('status', ['DRAFT', 'BOOKING_REQUEST', 'CUSTOMER_PENDING', 'BOOKED', 'RE_SCHEDULE', 'MISSED', 'DECLINE'])->orderBy('id', 'desc')->get();
            $bookings = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'service', 'job_requests', 'job_requests.product', 'job_requests.price_type', 'booking_items', 'booking_items.price_type',
                'job_requests.job_types', 'job_requests.job_types.job_type', 'booking_items.job_types', 'booking_items.job_types.job_type','work_stream',
            ])->where('vender_id', $vender_id)->where('trading_id', $trading_id)->whereIn('status', ['ARRIVED', 'INPROGRESS', 'FINAL_CHECKS', 'DUE', 'COMPLETED', 'READ_FOR_COLLECTION', 'READ_FOR_DELIVERY', 'COLLECTED', 'DELIVERED', 'VOID'])->orderBy('id', 'desc')->get();
            $booking_array = [];
            foreach ($bookings as $key => $value) {
                $data = new stdClass();
                $data = $value;
                $data['status'] = "BOOKED";
                $data['is_booked'] = 1;

                array_push($booking_array, $data);
            }
            $cancelled_jobs = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color','work_stream',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'job_requests.product', 'job_requests.price_type', 'booking_items', 'booking_items.price_type', 'job_requests.job_types', 'job_requests.job_types.job_type', 'booking_items.job_types', 'booking_items.job_types.job_type'
            ])->where('vender_id', $vender_id)->where('trading_id', $trading_id)->whereIn('status', ['CANCELLED'])->where('job_id', 0)->orderBy('id', 'desc')->get();
            foreach ($cancelled_jobs as $key => $value) {
                $data = new stdClass();
                $data = $value;


                array_push($booking_array, $data);
            }
            $custom_array = array_merge($quotations->toArray(), $booking_array);
            return response()->json([
                'status' => true,
                'bookings' => $custom_array,
                'booking_s' => $bookings,

                'message' => "Booking Fetch Successfully",
            ]);
        // } catch (Exception $e) {

        //     return response()->json([
        //         'status' => false,
        //         'error' => $e->getMessage(),
        //         'message' => "Error while getting Booking",
        //     ]);
        // }
    }


    public function getBookingDetailTest(Request $request)
    {

        try {


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            $trading_id = User::find($request->user()->id)['default_trading_unit'];

            $quotations = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color','work_stream',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'job_requests.product', 'job_requests.price_type', 'booking_items', 'booking_items.price_type', 'job_requests.job_types', 'job_requests.job_types.job_type', 'booking_items.job_types', 'booking_items.job_types.job_type'
            ])->where('vender_id', $vender_id)->where('trading_id', $trading_id)->whereIn('status', ['DRAFT', 'BOOKING_REQUEST', 'CUSTOMER_PENDING', 'BOOKED', 'RE_SCHEDULE', 'MISSED', 'DECLINE'])->orderBy('id', 'desc')->get();
            $bookings = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color','work_stream',
                'contact_detail', 'service', 'job_requests', 'job_requests.product', 'job_requests.price_type', 'booking_items', 'booking_items.price_type', 'job_requests.job_types', 'job_requests.job_types.job_type', 'booking_items.job_types', 'booking_items.job_types.job_type'
            ])->where('vender_id', $vender_id)->where('trading_id', $trading_id)->whereIn('status', ['ARRIVED', 'INPROGRESS', 'FINAL_CHECKS', 'DUE', 'COMPLETED', 'READ_FOR_COLLECTION', 'READ_FOR_DELIVERY', 'COLLECTED', 'DELIVERED', 'VOID'])->orderBy('id', 'desc')->get();
            $booking_array = [];
            foreach ($bookings as $key => $value) {
                $data = new stdClass();
                $data = $value;
                $data['status'] = "BOOKED";
                $data['is_booked'] = 1;

                array_push($booking_array, $data);
            }
            $cancelled_jobs = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color','work_stream',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'job_requests.product', 'job_requests.price_type', 'booking_items', 'booking_items.price_type', 'job_requests.job_types', 'job_requests.job_types.job_type', 'booking_items.job_types', 'booking_items.job_types.job_type'
            ])->where('vender_id', $vender_id)->where('trading_id', $trading_id)->whereIn('status', ['CANCELLED'])->where('job_id', 0)->orderBy('id', 'desc')->get();
            foreach ($cancelled_jobs as $key => $value) {
                $data = new stdClass();
                $data = $value;


                array_push($booking_array, $data);
            }
            $custom_array = array_merge($quotations->toArray(), $booking_array);
            return response()->json([
                'status' => true,
                'bookings' => $custom_array,
                'booking_s' => $bookings,

                'message' => "Booking Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Booking",
            ]);
        }
    }

    /***********  Get Single Booking    ***************/

    public function getSingleBooking(Request $request)
    {

        try {
            $validator = \Validator::make($request->all(), [
                'id' =>  ['required'],


            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $booking = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'job_logs','job_logs.user', 'invoices', 'invoices.payments', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color','work_stream',
                'contact_detail', 'contact_detail.hub', 'invoice', 'service', 'job_invoices', 'job_requests','deposits', 'job_requests.product', 'job_requests.price_type', 'booking_items', 'booking_items.price_type', 'job_requests.job_types', 'job_requests.job_types.job_type', 'booking_items.job_types', 'booking_items.job_types.job_type'
            ])->where('vender_id', $vender_id)->find($request['id']);

            if ($booking == null) {
                return response()->json([
                    'status' => false,
                    'booking' => $booking,
                    'message' => "Booking Not Exist",
                ]);
            }

            return response()->json([
                'status' => true,
                'booking' => $booking,
                'message' => "Booking Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Booking",
            ]);
        }
    }
    /***********  Get InProgress Booking    ***************/

    public function startBooking(Request $request)
    {

        try {
            $validator = \Validator::make($request->all(), [
                'booking_id' =>  ['required'],


            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $booking = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'booking_items', 'job_requests.job_types', 'job_requests.job_types.job_type',
            ])->where('vender_id', $vender_id)->find($request['booking_id']);

            $booking->status = "INPROGRESS";
            $booking->update();

            if ($booking == null) {
                return response()->json([
                    'status' => false,
                    'booking' => $booking,
                    'message' => "Booking Not Exist",
                ]);
            }


            $latestOrder = Log::orderBy('created_at', 'DESC')->first();
            $data = new stdClass();
            $data->log_no = 'lOG-' . "SVP" . str_pad($request->user()->id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
            $data->user_id = $request->user()->id;
            $data->type = "booking";
            $data->event = "booking Move to InPROGRESS ";
            if($request['note']!==null){

                $data->event_detail="Booking Status Change from ".str_replace('_', ' ', strtoupper($quote['status'])). " to ".str_replace('_', ' ', strtoupper($request['status'])) ." With Message ".$request['note'];
            }else{
                $data->event_detail="Booking Status Change from ".str_replace('_', ' ', strtoupper($quote['status'])). " to ".str_replace('_', ' ', strtoupper($request['status'])) ;

            }
            // $data->event_detail = "booking Status Change " . str_replace('_', ' ', strtoupper($booking['status'])) . " to  INPROGRESS";
            $data->type_id = $request['booking_id'];

            Log::saveLog($data);

            return response()->json([
                'status' => true,
                'booking' => $booking,
                'message' => "Booking Start Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Quotation",
            ]);
        }
    }
    /***********  Get cancel Booking    ***************/

    public function cancelBooking(Request $request)
    {

        try {
            $validator = \Validator::make($request->all(), [
                'booking_id' =>  ['required'],


            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $booking = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'booking_items'
            ])->where('vender_id', $vender_id)->find($request['booking_id']);

            $latestOrder = Log::orderBy('created_at', 'DESC')->first();
            $data = new stdClass();
            $data->log_no = 'lOG-' . "SVP" . str_pad($request->user()->id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
            $data->user_id = $request->user()->id;
            $data->type = "Book";
            $data->event = "Booking Status Change ";
            $data->event_detail = "Status Change to " . str_replace('_', ' ', strtoupper($booking['status'])) . " to  Cancelled";
            $data->type_id = $request['booking_id'];

            Log::saveLog($data);

            $booking->status = "REJECTED";
            $booking->update();

            if ($booking == null) {
                return response()->json([
                    'status' => false,
                    'booking' => $booking,
                    'message' => "Booking Not Exist",
                ]);
            }

            $notification = new CustomNotification();
            $notification->vender_id = Booking::find($request['booking_id'])->vender_id;
            $notification->hub_id = Booking::find($request['booking_id'])->contact_detail_id;
            $notification->message = "Service Provider Cancel the Booking  Please View";
            $notification->save();

            $client = Client::find(Booking::find($request['booking_id'])->contact_detail_id);
            if (isset($client)) {
                Larafirebase::fromArray(['title' => 'Booking Request', 'body' => 'Service Provider Cancel the Booking  Please View'])->withAdditionalData([
                    'vender_id' => Booking::find($request['booking_id'])->vender_id,
                    'user_id' => $client['id'],
                ])->sendNotification($client['token']);
            }



            return response()->json([
                'status' => true,
                'booking' => $booking,
                'message' => "Booking Cancel Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Quotation",
            ]);
        }
    }
    /***********  Get Complete Booking    ***************/

    public function completeBooking(Request $request)
    {

        try {
            $validator = \Validator::make($request->all(), [
                'booking_id' =>  ['required'],


            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $booking = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'service', 'job_requests', 'booking_items'
            ])->where('vender_id', $vender_id)->find($request['booking_id']);

            $latestOrder = Log::orderBy('created_at', 'DESC')->first();
            $data = new stdClass();
            $data->log_no = 'lOG-' . "SVP" . str_pad($request->user()->id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
            $data->user_id = $request->user()->id;
            $data->type = "Job";
            $data->event = "Job Status Change ";
            $data->event_detail = "Job Status Change " . str_replace('_', ' ', strtoupper($booking['status'])) . " to  READY FOR COLLECTION";
            $data->type_id = $request['booking_id'];

            Log::saveLog($data);



            $booking->status = "READY_FOR_COLLECTION";
            // $booking->booking_date = $request['booking_date'] ?? null;
            // $booking->booking_time = $request['booking_time'] ?? null;
            $booking->update();

            $single_booking = Booking::find($request['booking_id']);

            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            //     $latestOrder = Invoice::orderBy('created_at', 'DESC')->first();

            //  $invoice=Invoice::create([
            //         "vender_id" => $vender_id,
            //         "invoice_no" => 'INV-SVP' . str_pad($latestOrder->id ?? 0 + 1, 8, "0", STR_PAD_LEFT),
            //         "status" => 'DUE',
            //         "booking_id" => $request['booking_id'],
            //         "contact_id" => $single_booking['contact_detail_id'],
            //         "total" => $single_booking['total'],
            //         "sub_total" => $single_booking['sub_total'],
            //         "vat" => $single_booking['vat'],
            //     ]);

            if ($booking == null) {
                return response()->json([
                    'status' => false,
                    'booking' => $booking,
                    'invoice' => null,
                    'message' => "Booking Not Exist",
                ]);
            }
            $notification = new CustomNotification();
            $notification->vender_id = Booking::find($request['booking_id'])->vender_id;
            $notification->hub_id = Booking::find($request['booking_id'])->contact_detail_id;
            $notification->message = "Service Provider Complete the Booking  Please View";
            $notification->save();

            $client = Client::find(Booking::find($request['booking_id'])->contact_detail_id);
            // if (isset($client)) {
            //     Larafirebase::fromArray(['title' => 'Booking Request', 'body' => 'Service Provider Complete the Booking  Please View'])->withAdditionalData([
            //         'vender_id' => Booking::find($request['booking_id'])->vender_id,
            //         'user_id' => $client['id'],
            //     ])->sendNotification($client['token']);
            // }

            return response()->json([
                'status' => true,
                'booking' => $booking,
                'invoice' => null,
                'message' => "Booking Complete Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Booking",
            ]);
        }
    }
    public function rescheduleBooking(Request $request)
    {

        try {
            $validator = \Validator::make($request->all(), [
                'booking_id' =>  ['required'],


            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;

            $booking = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'booking_items'
            ])->where('vender_id', $vender_id)->find($request['booking_id']);
            $booking->booking_date= $request['booking_date'];
            $booking->booking_time= $request['booking_time'];
            $booking->workstream_id= $request['workstream_id'];
           

          
            $booking->update();
            
            $latestOrder = Log::orderBy('created_at', 'DESC')->first();
             $data = new stdClass();
            $data->log_no = 'lOG-' . "SVP" . str_pad($request->user()->id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
            $data->user_id = $request->user()->id;
            $data->type = "Book";
            $data->event = "Booking Status Change ";
            $data->event_detail = "Booking Status Change " . str_replace('_', ' ', strtoupper($booking['status'])) . " to  Re Schedule";
            $data->type_id = $request['booking_id'];
              Log::saveLog($data);

            $single_booking = Booking::find($request['booking_id']);

            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            $latestOrder = Invoice::orderBy('created_at', 'DESC')->first();



            if ($booking == null) {
                return response()->json([
                    'status' => false,
                    'booking' => $booking,

                    'message' => "Booking Not Exist",
                ]);
            }
            $notification = new CustomNotification();
            $notification->vender_id = Booking::find($request['booking_id'])->vender_id;
            $notification->hub_id = Booking::find($request['booking_id'])->contact_detail_id;
            $notification->message = "Service Provider Reschedule the Booking  Please View";
            $notification->save();

            $client = Client::find(Booking::find($request['booking_id'])->contact_detail_id);
            if (isset($client)) {
                Larafirebase::fromArray(['title' => 'Booking Request', 'body' => 'Service Provider Reschedule the Booking  Please View'])->withAdditionalData([
                    'vender_id' => Booking::find($request['booking_id'])->vender_id,
                    'user_id' => $client['id'],
                ])->sendNotification($client['token']);
            }

            return response()->json([
                'status' => true,
                'booking' => $booking,

                'message' => "Booking Reschedule Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Booking",
            ]);
        }
    }


    /***********  Get InProgress Booking    ***************/

    public function getInProgress(Request $request)
    {



        try {





            $vender_id = $request->user()['vender_id'] == 0 ? $request->user()->id : $request->user()['vender_id'];
            $trading_id = User::find($request->user()->id)['default_trading_unit'];

            $quotations = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color','work_stream',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'booking_items', 'job_requests.job_types', 'job_requests.job_types.job_type'
            ])->where('vender_id', $vender_id)->where('trading_id',$trading_id)->whereIn('status', ['INPROGRESS'])->get();

            /*$notification = new CustomNotification();
            $notification->vender_id = Booking::find($request['booking_id'])->vender_id;
            $notification->hub_id = Booking::find($request['booking_id'])->contact_detail_id;
            $notification->message = "Service Provider InProgress the Booking  Please View";
            $notification->save();
*/

            return response()->json([
                'status' => true,
                'bookings' => $quotations,
                'message' => "Booking Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Booking",
            ]);
        }
    }
    /***********  Get CompleteBooking Booking    ***************/

    public function getCompleteBooking(Request $request)
    {

        try {


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            $trading_id = User::find($request->user()->id)['default_trading_unit'];

            $quotations = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color','work_stream',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'booking_items', 'job_requests.job_types', 'job_requests.job_types.job_type'
            ])->where('vender_id', $vender_id)->where('trading_id',$trading_id)->whereIn('status', ['FINAL_CHECKS', 'READ_FOR_COLLECTION', 'READY_FOR_DELIVERY'])->get();

            $record_array = [];


            return response()->json([
                'status' => true,
                'bookings' => $quotations,
                'message' => "Booking Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Booking",
            ]);
        }
    }

    /***********  Get Past Booking    ***************/

    public function getPastBooking(Request $request)
    {

        try {


            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            $trading_id = User::find($request->user()->id)['default_trading_unit'];

            $quotations = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color','work_stream',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'booking_items', 'job_requests.job_types', 'job_requests.job_types.job_type'
            ])->whereIn('status', ['COLLECTED', 'DELIVERED', 'VOID', 'DUE'])->where('job_delete', 0)->where('trading_id',$trading_id)->get();
            // $quotations = Booking::with([
            //     'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
            //     'contact_detail','contact_detail.hub', 'service', 'job_requests', 'booking_items','job_requests.job_types','job_requests.job_types.job_type'
            // ])->where('vender_id', $vender_id)->whereHas('invoice' ,function ($query) {
            //     $query->where('status', 'PAID');
            // })->get();
            foreach ($quotations as $key => $quotation) {

                $quotation['status'] = $quotation['status'];
            }
            $booking_array = [];

            $cancelled_jobs = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'contact_detail.hub', 'service', 'job_requests', 'job_requests.product', 'job_requests.price_type', 'booking_items', 'booking_items.price_type', 'job_requests.job_types', 'job_requests.job_types.job_type', 'booking_items.job_types', 'booking_items.job_types.job_type'
            ])->where('vender_id', $vender_id)->where('trading_id',$trading_id)->whereIn('status', ['CANCELLED'])->where('job_id', "!=", 0)->orderBy('id', 'desc')->get();
            foreach ($cancelled_jobs as $key => $value) {
                $data = new stdClass();
                $data = $value;


                array_push($booking_array, $data);
            }
            $custom_array = array_merge($quotations->toArray(), $booking_array);


            return response()->json([
                'status' => true,
                'bookings' => $custom_array,
                'message' => "Booking Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Booking",
            ]);
        }
    }

    public function statusBooking(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'booking_id' =>  ['required'],
                'status' =>  ['required'],

            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }
            $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
            $quote = Booking::find($request['booking_id']);
            if ($request['status'] == "ARRIVED") {
              $already_jobs=Booking::find($request['booking_id']);

              if($already_jobs['job_no']==null){
                $latestOrder = Booking::orderBy('job_id', 'DESC')->first();
                Booking::find($request['booking_id'])->update([
                    "status" => $request['status'],
                    'job_id' => $latestOrder->job_id + 1,
                    "job_no" => 'JOB-' . "SVP" . str_pad($vender_id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->job_id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT),
                     "queue_date" => Carbon::now(),
                     "queue_time" => Carbon::now()->format('h:i:s'),
                ]);
                $latestOrder = Log::orderBy('created_at', 'DESC')->first();
                $data = new stdClass();
                $data->log_no = 'lOG-' . "SVP" . str_pad($request->user()->id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
                $data->user_id = $request->user()->id;
                $data->type = "Book";
                $data->event = "Booking Status Change ";
                if($request['note']!==null){

                    $data->event_detail="Booking Status Change from ".str_replace('_', ' ', strtoupper($quote['status'])). " to ".str_replace('_', ' ', strtoupper($request['status'])) ." With Message ".$request['note'];
                }else{
                    $data->event_detail="Booking Status Change from ".str_replace('_', ' ', strtoupper($quote['status'])). " to ".str_replace('_', ' ', strtoupper($request['status'])) ;

                }
                $data->type_id = $request['booking_id'];

                Log::saveLog($data);

              }else{
                // $latestOrder = Booking::orderBy('job_id', 'DESC')->first();
                Booking::find($request['booking_id'])->update([
                    "status" => $request['status'],
                    "queue_date" => Carbon::now(),
                    "queue_time" => Carbon::now()->format('h:i:s'),


                ]);

                $latestOrder = Log::orderBy('created_at', 'DESC')->first();
                $data = new stdClass();
                $data->log_no = 'lOG-' . "SVP" . str_pad($request->user()->id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
                $data->user_id = $request->user()->id;
                $data->type = "Book";
                $data->event = "Booking Status Change ";
                if($quote['status']=="ARRIVED"){
                    $q_status="In Queue";
                }else {

                    $q_status=$quote['status'];
                }
                if($request['note']!==null){

                    $data->event_detail="Booking Status Change from ".str_replace('_', ' ', strtoupper($q_status)). " to ".str_replace('_', ' ', strtoupper($request['status'])) ." With Message ".$request['note'];
                }else{
                    $data->event_detail="Booking Status Change from ".str_replace('_', ' ', strtoupper($q_status)). " to ".str_replace('_', ' ', strtoupper($request['status'])) ;

                }
                $data->type_id = $request['booking_id'];

                Log::saveLog($data);
              }


            } else {
                if($request['status']=='READY_FOR_COLLECTION'){
                    Booking::find($request['booking_id'])->update([
                        "status" => 'READ_FOR_COLLECTION',


                    ]);
                }else{
                    Booking::find($request['booking_id'])->update([
                        "status" => $request['status'],

                    ]);
                }

            }







            $notification = new CustomNotification();
            $notification->vender_id = Booking::find($request['booking_id'])->vender_id;
            $notification->hub_id = Booking::find($request['booking_id'])->contact_detail_id;
            $notification->message = "Service Provider Change the status of the Booking  Please View";
            $notification->save();

            $client = Client::find(Booking::find($request['booking_id'])->contact_detail_id);
            // if (isset($client)) {
            //     if(isset($client['token'])){
            //         Larafirebase::fromArray(['title' => 'Booking Request', 'body' => 'Service Provider Change the status of the Booking  Please View'])->withAdditionalData([
            //             'vender_id' => Booking::find($request['booking_id'])->vender_id,
            //             'user_id' => $client['id'],
            //         ])->sendNotification($client['token']);
            //     }

            // }

            $job = "Book";

            if (
                $request['status'] == "ARRIVED" || $request['status'] == "DIAGNOSING" || $request['status'] == "DIAGNOSING_COMPLETE" || $request['status'] == "PROGRESS" || $request['status'] == "READY_FOR_COLLECTION"
                || $request['status'] == "DUE" || $request['status'] == "INPROGRESS" || $request['status'] == "READY_FOR_FINAL_CHECK" || $request['status'] == "COMPLETED"
            ) {

                $job = "Job";
            }

            if ($request['status'] === "ARRIVED") {
                $latestOrder = Log::orderBy('created_at', 'DESC')->first();
                $data = new stdClass();
                $data->log_no = 'lOG-' . "SVP" . str_pad($request->user()->id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
                $data->user_id = $request->user()->id;
                $data->type = $job;
                $data->event = $job . " Creating ";
                $data->event_detail = $job . " Creating ";
                $data->type_id = $request['booking_id'];

                Log::saveLog($data);
            } else {
                $latestOrder = Log::orderBy('created_at', 'DESC')->first();
                $data = new stdClass();
                $data->log_no = 'lOG-' . "SVP" . str_pad($request->user()->id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
                $data->user_id = $request->user()->id;
                $data->type = $job;
                $data->event = $job . " Status Change ";

                if($quote['status']=="ARRIVED"){
                    $q_status="In Queue";
                }else {

                    $q_status=$quote['status'];
                }


                if($request['note']!==null){

                    $data->event_detail=$job." Status Change from ".str_replace('_', ' ', strtoupper($q_status)). " to ".str_replace('_', ' ', strtoupper($request['status'])) ." With Message ".$request['note'];
                }else{
                    $data->event_detail=$job." Status Change from ".str_replace('_', ' ', strtoupper($q_status)). " to ".str_replace('_', ' ', strtoupper($request['status'])) ;

                }
                $data->type_id = $request['booking_id'];

                Log::saveLog($data);
            }



            if($request['status']=='READY_FOR_COLLECTION'){
                $status='READY_FOR_COLLECTION';
            }else{
                $status=$request['status'];

            }


            return response()->json([
                'status' => true,
                'message' => "Status Change to " . str_replace('_', ' ', strtoupper($status)) . " Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Status Booking ",
            ]);
        }
    }

    public function deleteBooking(Request $request)
    {

        try {
            $validator = \Validator::make($request->all(), [
                'id' =>  ['required'],




            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                $responseArr['status'] = false;
                return response()->json($responseArr);
            }


            $request['id'];


            $contact = Booking::find($request['id']);
            if (isset($contact)) {
                $contact->delete();
            }




            return response()->json([
                'status' => true,

                'message' => "Booking Delete Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Delete Booking",
            ]);
        }
    }
    public function deleteJob(Request $request)
    {

        try {
            $validator = \Validator::make($request->all(), [
                'id' =>  ['required'],




            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                $responseArr['status'] = false;
                return response()->json($responseArr);
            }


            $request['id'];


            Booking::find($request['id'])->update([
                'job_delete' => 1
            ]);





            return response()->json([
                'status' => true,

                'message' => "Job Delete Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Delete Booking",
            ]);
        }
    }

    public function issueInvoice(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'booking_id' =>  ['required'],




        ]);

        $single_booking = Booking::find($request['booking_id']);

        $latestOrder = Invoice::orderBy('created_at', 'DESC')->first();
        
        if(count(Invoice::where('booking_id',$request['booking_id'])->where('status','DUE')->get())>0){
             return response()->json([
            'status' => false,
            'invoice'=>null,

            'message' => "Invoice Already Exist!",
        ]);
        }

        $invoice = Invoice::create([
            "vender_id" => $single_booking['vender_id'],
            "trading_id" => $single_booking['trading_id'],
            "invoice_no" => 'INV-' . "SVP" . str_pad($single_booking['vender_id'], 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT),
            "status" => $single_booking['total'] == 0 ? "PAID" : 'DUE',
            "booking_id" => $request['booking_id'],
            "contact_id" => $single_booking['contact_detail_id'],
            "total" => $single_booking['total'],
            "sub_total" => $single_booking['sub_total'],
            "vat" => $single_booking['vat'],
            'invoice_date' => $request['invoice_date'],
            'contact_email' => $request['email'],
            'address_line_1' => $request['address_line_1'],
            'address_line_2' => $request['address_line_2'],
            'address_line_3' => $request['address_line_3'],
            'address_line_4' => $request['address_line_4'],
            'city' => $request['city'],
            'postal_code' => $request['postal_code'],
            'mobile_no' => $request['mobile_no'],
             'landline_no' => $request['landline_no'],
            'name' => $request['name'],
            'company' => $request['company'],
            'bank_transfer_detail' => $request['bank_transfer_detail'],
        ]);
        
         $deposit_amount=Deposit::where('booking_id',$request['booking_id'])->sum('amount');

        if($deposit_amount>0){
           $remaining_amount=$invoice['total']-$deposit_amount;

           if($remaining_amount>0){
            $latestOrderPay = BookingTransaction::orderBy('created_at', 'DESC')->first();
            BookingTransaction::create([
                'vender_id' => $single_booking['vender_id'],
                "pay_no" => 'PAY-' . "SVP" . str_pad($single_booking['vender_id'], 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrderPay ? $latestOrderPay->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT),
                'invoice_id' => $invoice['id'],
                'payment_date' => Carbon::now(),
                'payment_type' => 'Invoice Received',
                'payment_method' => 'DEPOSIT',
                'amount' => $deposit_amount,
                'payment_ref' => '',
            ]);

           }else if($remaining_amount<0){
                $latestOrderPay = BookingTransaction::orderBy('created_at', 'DESC')->first();
            BookingTransaction::create([
                'vender_id' => $single_booking['vender_id'],
                "pay_no" => 'PAY-' . "SVP" . str_pad($single_booking['vender_id'], 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrderPay ? $latestOrderPay->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT),
                'invoice_id' => $invoice['id'],
                'payment_date' => Carbon::now(),
                'payment_type' => 'Invoice Received',
                'payment_method' => 'DEPOSIT',
                'amount' => $deposit_amount,
                'payment_ref' => '',
            ]);
             Invoice::find($invoice['id'])->update([
                'status'=>'PAID'
                ]);
           }else{
                $latestOrderPay = BookingTransaction::orderBy('created_at', 'DESC')->first();
            BookingTransaction::create([
                'vender_id' => $single_booking['vender_id'],
                "pay_no" => 'PAY-' . "SVP" . str_pad($single_booking['vender_id'], 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrderPay ? $latestOrderPay->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT),
                'invoice_id' => $invoice['id'],
                'payment_date' => Carbon::now(),
                'payment_type' => 'Invoice Received',
                'payment_method' => 'DEPOSIT',
                'amount' => $deposit_amount,
                'payment_ref' => '',
            ]);
             Invoice::find($invoice['id'])->update([
                'status'=>'PAID'
                ]);
           }

        }

        $latestOrder = Log::orderBy('created_at', 'DESC')->first();
        $data = new stdClass();
        $data->log_no = 'lOG-' . "SVP" . str_pad($request->user()->id, 5, "0", STR_PAD_LEFT) . "-" . str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT);
        $data->user_id = $request->user()->id;
        $data->type = "Invoice";
        $data->event = "Invoice Creating";
        $data->event_detail = "Invoice Creating";
        $data->type_id = $invoice['id'];

        Log::saveLog($data);

        // Booking::find($request['booking_id'])->update([
        //     "status" =>"DUE"
        // ]);

        $invoices = Invoice::with(['booking', 'booking.contact_detail', 'booking.service', 'booking.job_requests', 'booking.booking_items', 'booking.vehicle.vehicle_model', 'booking.vehicle.vehicle_make', 'booking.vehicle.engine_size', 'booking.vehicle.transmission_type', 'booking.vehicle.fuel_type', 'booking.vehicle.color', 'payments'])->where('vender_id', $single_booking['vender_id'])->find($invoice['id']);;
        $item_array = $invoices['booking']['booking_items'];



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
            'vender' => User::with('profile')->find($invoices['vender_id']),
            'item_array' => $item_array,
            'first_array' => $first_array,
            'second_array' => $second_array,
            'third_array' => $third_array,
        ];
        $pdf = Pdf::loadView('pdf.invoice', $data);
        $content = $pdf->download()->getOriginalContent();
        file_put_contents('pdf/' . $invoices['invoice_no'] . time()  . ".pdf", $content);

        $data["email"] = $single_booking['contact_detail']['email'];
        $data["title"] = "Invoice Reminder";


        $files = [

            asset('pdf/' . $invoices['invoice_no'] . time() . ".pdf"),
        ];
        
        foreach ($files as $file) {
        Invoice::find($invoice['id'])->update([
            'invoice_path'=>$file
        ]);
        }

        // Mail::send('email.invoice', $data, function ($message) use ($data, $files,$single_booking) {
        //     $message->to($single_booking['vender']["email"])
        //         ->subject($data["title"]);

        //     foreach ($files as $file) {
        //         $message->attach($file);
        //     }
        // });

        return response()->json([
            'status' => true,
            'invoice'=>$invoice,

            'message' => "Invoice Create Successfully",
        ]);
    }
}
