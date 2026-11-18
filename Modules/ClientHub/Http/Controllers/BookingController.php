<?php

namespace Modules\ClientHub\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\JobType;
use Modules\Admin\Entities\PriceType;
use Modules\Vender\Entities\Booking;
use Modules\Vender\Entities\BookingJobRequest;
use Modules\Vender\Entities\BookingJobRequestJobType;
use Modules\Vender\Entities\CustomNotification;
use Kutia\Larafirebase\Facades\Larafirebase;
use Modules\Vender\Entities\ContactDetail;
use Modules\Vender\Entities\QuickProduct;
use Modules\Vender\Entities\TradingUnit;
use Modules\Vender\Entities\Vehicle;
use Carbon\Carbon;
use Modules\Vender\Entities\Quotation;

class BookingController extends Controller
{
    public function jobsOverview(Request $request)
    {
        $clientId = $request->user()->id;
        $relations = [
            'vehicle.vehicle_model', 'vehicle.vehicle_make', 'contact_detail', 'service',
            'job_requests.job_type', 'booking_items.job_type', 'vender.profile',
        ];

        $bookings = Booking::with($relations)
            ->whereHas('contact_detail', fn ($query) => $query->where('hub_id', $clientId))
            ->latest('id')
            ->limit(100)
            ->get();

        $quotes = Quotation::with([
            'vehicle.vehicle_model', 'vehicle.vehicle_make', 'contact_detail', 'service',
            'job_requests.job_type', 'vender.profile',
        ])
            ->whereHas('contact_detail', fn ($query) => $query->where('hub_id', $clientId))
            ->latest('id')
            ->limit(100)
            ->get();

        return response()->json([
            'status' => true,
            'quotes' => $quotes,
            'bookings' => $bookings->filter(fn ($booking) => empty($booking->job_id))->values(),
            'jobs' => $bookings->filter(fn ($booking) => !empty($booking->job_id))->values(),
            'message' => 'Jobs overview fetched successfully.',
        ]);
    }

    private function slotsForProviderDate(int $providerId, string $date): array
    {
        $tradingUnit = TradingUnit::with('app_setting')->find($providerId);
        $setting = $tradingUnit?->app_setting;
        // The provider settings form historically displays 10 minutes when an
        // interval has not yet been persisted. Preserve that configured UI
        // behavior for records that already have a booking window.
        $interval = (int) ($setting?->interval ?: 10);

        if (!$setting || !$setting->start_time || !$setting->end_time) {
            return [];
        }

        if ($interval < 1) {
            $interval = 10;
        }

        try {
            $day = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
            $start = Carbon::parse($date . ' ' . $setting->start_time);
            $end = $setting->end_time === '24:00'
                ? $day->copy()->addDay()
                : Carbon::parse($date . ' ' . $setting->end_time);
        } catch (\Throwable $e) {
            return [];
        }

        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        $reserved = Booking::where('trading_id', $providerId)
            ->whereDate('booking_date', $date)
            ->whereNotIn('status', ['CANCELLED', 'DECLINED'])
            ->pluck('booking_time')
            ->map(function ($time) {
                try {
                    return Carbon::parse($time)->format('H:i');
                } catch (\Throwable $e) {
                    return null;
                }
            })
            ->filter()
            ->all();

        $slots = [];
        for ($cursor = $start->copy(); $cursor->lessThan($end); $cursor->addMinutes($interval)) {
            if ($cursor->isPast() || in_array($cursor->format('H:i'), $reserved, true)) {
                continue;
            }
            $slots[] = $cursor->format('g:i A');
        }

        return $slots;
    }

    public function availableSlots(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'provider_id' => ['required', 'integer', 'exists:trading_units,id'],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'slots' => [],
            ], 422);
        }

        return response()->json([
            'status' => true,
            'date' => $request->input('date'),
            'slots' => $this->slotsForProviderDate(
                $request->integer('provider_id'),
                $request->input('date')
            ),
        ]);
    }

    public function requestBooking(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'provider_id' => ['required', 'integer', 'exists:trading_units,id'],
            'vehicle_id' => ['required', 'integer'],
            'service_type' => ['required', 'in:On-site,Mobile'],
            'booking_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'booking_time' => ['required', 'string', 'max:50'],
            'note' => ['nullable', 'string', 'max:2000'],
            'address_line_1' => ['nullable', 'string', 'max:1000'],
            'city_and_postcode' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'job_requests' => ['required', 'array', 'min:1'],
            'job_requests.*.service_id' => ['nullable', 'integer'],
            'job_requests.*.job_type_id' => ['nullable', 'integer'],
            'job_requests.*.price_type_id' => ['nullable', 'integer'],
            'job_requests.*.product_id' => ['nullable', 'integer'],
            'job_requests.*.name' => ['required', 'string', 'max:500'],
            'job_requests.*.description' => ['nullable', 'string', 'max:2000'],
            'job_requests.*.note' => ['nullable', 'string', 'max:2000'],
            'job_requests.*.coverage' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $availableSlots = $this->slotsForProviderDate(
            $request->integer('provider_id'),
            $request->input('booking_date')
        );
        $requestedTime = Carbon::parse($request->input('booking_time'))->format('g:i A');
        if (!in_array($requestedTime, $availableSlots, true)) {
            return response()->json([
                'status' => false,
                'message' => 'The selected booking time is no longer available.',
            ], 422);
        }

        $client = $request->user();
        $vehicle = Vehicle::where('vender_id', $client->id)->find($request->integer('vehicle_id'));
        if (!$vehicle) {
            return response()->json([
                'status' => false,
                'message' => 'The selected vehicle does not belong to this account.',
            ], 422);
        }

        $tradingUnit = TradingUnit::findOrFail($request->integer('provider_id'));

        try {
            $booking = DB::transaction(function () use ($request, $client, $vehicle, $tradingUnit) {
                $contact = ContactDetail::firstOrCreate(
                    ['hub_id' => $client->id, 'vender_id' => $tradingUnit->vender_id],
                    [
                        'contact_no' => 'CON-SVP' . str_pad((string) $tradingUnit->vender_id, 5, '0', STR_PAD_LEFT) . '-' . str_pad((string) (ContactDetail::max('id') + 1), 5, '0', STR_PAD_LEFT),
                        'name' => $client->name,
                        'mobile_no' => $client->phone_no,
                        'email' => $client->email,
                    ]
                );

                $jobRequests = $request->input('job_requests', []);
                $resolvedJobRequests = [];

                foreach ($jobRequests as $jobRequest) {
                    // 1. Resolve job_type_id:
                    // Check direct job_type_id or service_id
                    $jobTypeId = $jobRequest['job_type_id'] ?? $jobRequest['service_id'] ?? null;

                    // If not present, try product_id
                    if (!$jobTypeId && !empty($jobRequest['product_id'])) {
                        $jobTypeId = QuickProduct::where('id', $jobRequest['product_id'])->value('job_type_id');
                    }

                    // If not present, try matching JobType by name
                    if (!$jobTypeId && !empty($jobRequest['name'])) {
                        $name = trim($jobRequest['name']);
                        $jobTypeId = JobType::where('name', $name)->value('id')
                            ?? JobType::whereRaw('LOWER(TRIM(name)) = ?', [strtolower($name)])->value('id');
                    }

                    // If not present, try matching JobType by description
                    if (!$jobTypeId && !empty($jobRequest['description'])) {
                        $desc = trim($jobRequest['description']);
                        $jobTypeId = JobType::where('name', $desc)->value('id')
                            ?? JobType::whereRaw('LOWER(TRIM(name)) = ?', [strtolower($desc)])->value('id');
                    }

                    // 2. Resolve price_type_id:
                    // Check direct price_type_id
                    $priceTypeId = $jobRequest['price_type_id'] ?? null;

                    // If not present, resolve from coverage / price_type string
                    $coverage = trim($jobRequest['coverage'] ?? $jobRequest['price_type'] ?? '');
                    if (!$priceTypeId && $coverage !== '') {
                        $normalized = strtolower($coverage);
                        if (str_contains($normalized, 'labour') && str_contains($normalized, 'part')) {
                            $priceTypeId = PriceType::whereRaw('LOWER(TRIM(name)) = ?', ['labour and parts'])->value('id')
                                ?? PriceType::where('name', 'Labour and Parts')->value('id')
                                ?? 1;
                        } elseif (str_contains($normalized, 'labour')) {
                            $priceTypeId = PriceType::whereRaw('LOWER(TRIM(name)) = ?', ['labour only'])->value('id')
                                ?? PriceType::where('name', 'Labour only')->value('id')
                                ?? 2;
                        } elseif (str_contains($normalized, 'part')) {
                            $priceTypeId = PriceType::whereRaw('LOWER(TRIM(name)) = ?', ['parts only'])->value('id')
                                ?? PriceType::where('name', 'Parts only')->value('id')
                                ?? 3;
                        } else {
                            $priceTypeId = PriceType::whereRaw('LOWER(TRIM(name)) = ?', [$normalized])->value('id')
                                ?? PriceType::where('name', $coverage)->value('id');
                        }
                    }

                    // If not present, try product_id job_coverage_id
                    if (!$priceTypeId && !empty($jobRequest['product_id'])) {
                        $priceTypeId = QuickProduct::where('id', $jobRequest['product_id'])->value('job_coverage_id');
                    }

                    // Ensure name is populated
                    $itemName = $jobRequest['name'] ?? null;
                    if (empty($itemName) && $jobTypeId) {
                        $itemName = JobType::where('id', $jobTypeId)->value('name');
                    }

                    $resolvedJobRequests[] = [
                        'job_type_id' => $jobTypeId ? (int) $jobTypeId : null,
                        'price_type_id' => $priceTypeId ? (int) $priceTypeId : null,
                        'product_id' => !empty($jobRequest['product_id']) ? (int) $jobRequest['product_id'] : null,
                        'name' => $itemName ?? '',
                        'job_description' => $jobRequest['description'] ?? $itemName ?? '',
                        'note' => $jobRequest['note'] ?? null,
                    ];
                }

                $firstServiceId = collect($resolvedJobRequests)->pluck('job_type_id')->filter()->first()
                    ?? collect($jobRequests)->pluck('service_id')->filter()->first();
                $nextBookingId = (int) Booking::max('id') + 1;

                $booking = Booking::create([
                    'vender_id' => $tradingUnit->vender_id,
                    'trading_id' => $tradingUnit->id,
                    'contact_detail_id' => $contact->id,
                    'vehicle_id' => $vehicle->id,
                    'service_id' => $firstServiceId ?: 0,
                    'is_hub' => 1,
                    'booking_no' => 'BKG-SVP' . str_pad((string) $tradingUnit->vender_id, 5, '0', STR_PAD_LEFT) . '-' . str_pad((string) $nextBookingId, 5, '0', STR_PAD_LEFT),
                    'service_type' => $request->input('service_type'),
                    'status' => 'BOOKING_REQUEST',
                    'booking_date' => $request->input('booking_date'),
                    'booking_time' => $request->input('booking_time'),
                    'note' => $request->input('note'),
                    'address_line_1' => $request->input('address_line_1'),
                    'city' => $request->input('city_and_postcode'),
                ]);

                foreach ($resolvedJobRequests as $item) {
                    $createdJobRequest = BookingJobRequest::create([
                        'vender_id' => $tradingUnit->vender_id,
                        'trading_id' => $tradingUnit->id,
                        'booking_id' => $booking->id,
                        'job_type_id' => $item['job_type_id'],
                        'price_type_id' => $item['price_type_id'],
                        'product_id' => $item['product_id'],
                        'name' => $item['name'],
                        'job_description' => $item['job_description'],
                        'note' => $item['note'],
                        'is_job' => 0,
                    ]);

                    if ($item['job_type_id']) {
                        BookingJobRequestJobType::create([
                            'job_request_id' => $createdJobRequest->id,
                            'job_type_id' => $item['job_type_id'],
                        ]);
                    }
                }

                $notification = new CustomNotification();
                $notification->vender_id = $tradingUnit->vender_id;
                $notification->hub_id = $client->id;
                $notification->message = 'You have a new booking request from a customer. Please view it.';
                $notification->save();

                return $booking->load([
                    'vehicle.vehicle_model',
                    'vehicle.vehicle_make',
                    'contact_detail',
                    'service',
                    'job_requests',
                    'job_requests.job_type',
                    'job_requests.price_type',
                ]);
            });

            return response()->json([
                'status' => true,
                'booking' => $booking,
                'message' => 'Booking request sent successfully.',
            ], 201);
        } catch (Exception $e) {
            \Log::error('Client booking request failed.', [
                'client_id' => $client->id,
                'provider_id' => $request->input('provider_id'),
                'vehicle_id' => $request->input('vehicle_id'),
                'exception' => $e,
            ]);
            return response()->json([
                'status' => false,
                'message' => 'Unable to send the booking request. Please try again.',
            ], 500);
        }
    }

    public function saveBooking(Request $request)
    {

        try {
            $validator = \Validator::make($request->all(), [
                'vehicle_id' =>  ['required'],
                'trading_id' =>  ['required'],
                'service_id' =>  ['required'],

            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }


            $vender_id = TradingUnit::find($request['trading_id'])->vender_id;
            $latestOrderContact = ContactDetail::orderBy('created_at', 'DESC')->first();
            // return 'BKG-SVP' . str_pad($latestOrder->id? $latestOrder->id+1 :0 + 1, 8, "0", STR_PAD_LEFT);
            $contact_detail=ContactDetail::where('hub_id',$request->user()->id)->where('vender_id',$vender_id)->first();
            if($contact_detail==null){
                $contact_detail = ContactDetail::create([
                    "vender_id" => $vender_id,
                    "contact_no"=>'CON-'."SVP".str_pad($vender_id, 5, "0", STR_PAD_LEFT)."-". str_pad($latestOrderContact?$latestOrderContact->id+1: 0 + 1, 5, "0", STR_PAD_LEFT),
                    'name'=>$request->user()->name,
                    'mobile_no'=>$request->user()->phone_no,
                    'email'=>$request->user()->email,
                    'hub_id'=>$request->user()->id

                ]);
            }
            $latestOrder = Booking::orderBy('created_at', 'DESC')->first();
            $obj = Booking::create([
                "vender_id" => $vender_id,
                "trading_id" => $request->trading_id,
                "contact_detail_id" => $contact_detail->id,
                'is_hub' => 1,
                "booking_no" => 'BKG-'."SVP".str_pad($vender_id, 5, "0", STR_PAD_LEFT)."-". str_pad($latestOrder ? $latestOrder->id + 1 : 0 + 1, 5, "0", STR_PAD_LEFT),
                ...$request->all(),
            ]);

            $bookings = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'service', 'job_requests', 'booking_items'
            ])->find($obj->id);

            return response()->json([
                'status' => true,
                'booking' => $bookings,
                'message' => "Booking Added Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Add Booking" . $e,
            ]);
        }
    }

    public function getSingleBooking(Request $request)
    {
        // return $request->all();

        try {
            $validator = \Validator::make($request->all(), [
                'id' =>  ['required'],


            ]);

            if ($validator->fails()) {

                $responseArr['message'] = $validator->errors()->first();
                $responseArr['token'] = '';
                return response()->json($responseArr);
            }


            $vender_id = $request->user()->id;

            $booking = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'service', 'job_requests', 'job_requests.job_type', 'job_requests.price_type', 'booking_items','booking_items.job_type','booking_items.price_type', 'vender',
                 'vender.profile','job_requests.job_types','job_requests.job_types.job_type','booking_items', 'booking_items.price_type','booking_items.job_types','booking_items.job_types.job_type', 'job_requests.job_types',
            ])->find((int)$request['id']);

            if ($booking == null) {
                return response()->json([
                    'status' => false,
                    'Booking' => $booking,
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
                'message' => "Error while getting Quotation",
            ]);
        }
    }

    public function confirmBooking(Request $request)
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




            Booking::find($request['booking_id'])->update([
                "status" => 'BOOKING_REQUEST',
                "booking_date"=>$request['booking_date'],
                "booking_time"=>$request['booking_time'],

            ]);



            $booking = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'service', 'job_requests', 'job_requests.job_type', 'job_requests.price_type', 'booking_items', 'vender', 'vender.profile'
            ])->find($request['booking_id']);

            $notification = new CustomNotification();
            $notification->vender_id = Booking::find($request['booking_id'])->vender_id;
            $notification->hub_id = $request->user()->id;
            // $notification->hub_id = $request->user()->id;
            $notification->message = "You Have the new Booking Request from Customer Please View";
            $notification->save();

            // Larafirebase::fromArray(['title' => 'Booking Request', 'body' => 'You Have the new Booking Request from Customer Please View'])->withAdditionalData([
            //     'vender_id' => Booking::find($request['booking_id'])['vender_id']??null,
            //     'user_id' => $request->user()->id,

            // ])->sendNotification(User::find(Booking::find($request['booking_id'])['vender_id'])['token']);




            return response()->json([
                'status' => true,
                'booking' => $booking,
                'message' => "Booking Send Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Send Booking ",
            ]);
        }
    }

    public function getBookingDetail(Request $request)
    {

        try {


            $vender_id = $request->user()->id;

            $quotations = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'service', 'job_requests', 'booking_items', 'vender', 'vender.profile'
            ])->whereHas('contact_detail', function($q) use($vender_id){
                $q->where('hub_id', '>=', $vender_id);
            })->limit(20)->get();
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





            Booking::find($request['booking_id'])->update([
                "status" => $request['status'],
                "note" => $request['note'] ?? '',
            ]);
            $notification = new CustomNotification();
            $notification->vender_id = Booking::find($request['booking_id'])->vender_id;
            $notification->hub_id = $request->user()->id;
            // $notification->hub_id = $request->user()->id;
            $notification->message = "You Have the new Booking status has Been Change Please View";
            $notification->save();


            // Larafirebase::fromArray(['title' => 'Booking Request', 'body' => 'You Have the new Booking status has Been Change Please View'])->withAdditionalData([
            //     'vender_id' => Booking::find($request['booking_id'])['vender_id'] ?? null,
            //     'user_id' => $request->user()->id,

            // ])->sendNotification(User::find(Booking::find($request['booking_id'])['vender_id'])['token']);




            return response()->json([
                'status' => true,
                'message' => "Booking " . $request['status'] . " Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while Status Booking ",
            ]);
        }
    }

    /***********  Get Past Booking    ***************/

    public function getPastBooking(Request $request)
    {

        try {


            $vender_id = $request->user()->id;

            $quotations = Booking::with([
                'vehicle.vehicle_model', 'vehicle.vehicle_make', 'vehicle.engine_size', 'vehicle.transmission_type', 'vehicle.fuel_type', 'vehicle.color',
                'contact_detail', 'service', 'job_requests', 'booking_items','vender', 'vender.profile'
            ])->whereHas('contact_detail', function($q) use($request){
                $q->where('hub_id', '=', $request->user()->id);
            })->whereIn('status',['COLLECTED','DELIVERED','VOID','DUE'])->get();

            // foreach ($quotations as $key => $quotation) {

            //     $quotation['status'] = "PAID";
            // }

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
}
