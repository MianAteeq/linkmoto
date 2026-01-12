<?php

namespace Modules\Vender\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vender\Entities\Booking;
use Modules\Vender\Entities\Invoice;
use Modules\Vender\Entities\Vehicle;
use Modules\Vender\Entities\Quotation;
use Modules\Vender\Entities\TradingName;
use Modules\Vender\Entities\TradingUnit;
use Modules\Vender\Entities\ContactDetail;
use Modules\Vender\Entities\VenderAddress;
use Illuminate\Contracts\Support\Renderable;
use Modules\Vender\Entities\BookingTransaction;
use Modules\Vender\Entities\TradingUnitAppSetting;
use Modules\Vender\Entities\TradingUnitHubProfile;
use Modules\Vender\Entities\WorkStream;
use App\Models\BankAccount;

class ServiceProviderController extends Controller
{
    public function serviceProvider()
    {


        return view('vender::service_provider.index', get_defined_vars());
    }

    public function appData()
    {


        return view('vender::service_provider.app_data', get_defined_vars());
    }

    public function tradingUnit()
    {

        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }

        $trading_units = TradingUnit::where('vender_id', $vender_id)->get();

        return view('vender::service_provider.trading_unit.index', get_defined_vars());
    }
    public function tradingUnitAdd()
    {

        $user = auth()->user();
        $trading_names = TradingName::where('vender_id', $user['id'])->get();
        $sites = VenderAddress::where('vender_id', $user['id'])->get();


        return view('vender::service_provider.trading_unit.add', get_defined_vars());
    }
    public function tradingUnitEdit($id)
    {

        $user = auth()->user();
        $trading_names = TradingName::where('vender_id', $user['id'])->get();
        $sites = VenderAddress::where('vender_id', $user['id'])->get();

        $trading_unit = TradingUnit::find($id);


        return view('vender::service_provider.trading_unit.edit', get_defined_vars());
    }
    public function tradingUnitView($id)
    {

        $user = auth()->user();


        $trading_unit = TradingUnit::find($id);


        return view('vender::service_provider.trading_unit.view', get_defined_vars());
    }

    public function appSetting($id)
    {


        $user = auth()->user();

        $is_provider = "on";


        if (isset($user->profile->package)) {

            $package_name = $user->profile->package['name'];

            if ($package_name == "Advertise only") {
                $is_provider = "off";
            }
        }
        $is_hub = "on";

        if (isset($user->profile->package)) {

            $package_name = $user->profile->package['name'];

            if ($package_name == "MINI") {
                // $is_hub="off";
            }
            if ($package_name == "HATCHBACK") {
                $is_hub = "on";
            }
        }


        $trading_unit = TradingUnit::with('hub_setting')->find($id);

        $workstreams = WorkStream::where('trading_id', $id)->get();


        return view('vender::service_provider.trading_unit.app_setting.index', get_defined_vars());
    }
    public function hubSetting($id)
    {

        $user = auth()->user();
        $is_hub = "on";

        if (isset($user->profile->package)) {

            $package_name = $user->profile->package['name'];

            if ($package_name == "MINI") {
                $is_hub = "off";
            }
            if ($package_name == "HATCHBACK") {
                $is_hub = "on";
            }
        }


        $trading_unit = TradingUnit::find($id);

        $hub_setting = TradingUnitHubProfile::where('trading_id', $id)->first();

        if (!isset($hub_setting)) {
            TradingUnitHubProfile::create([
                'trading_id' => $id
            ]);
        }


        return view('vender::service_provider.trading_unit.hub_setting.index', get_defined_vars());
    }
    public function appTradingData($id)
    {

        $user = auth()->user();


        $trading_unit = TradingUnit::find($id);


        return view('vender::service_provider.trading_unit.appData.index', get_defined_vars());
    }

    public function bookingSetting($id)
    {

        $user = auth()->user();

        $trading_unit = TradingUnit::find($id);

        // Use 24-hour format from the start
        $startPeriod = Carbon::parse('01:00');
        $endPeriod   = Carbon::parse('24:00'); // Carbon interprets this as 00:00 next day

        // Generate with 15-minute interval
        $period = CarbonPeriod::create($startPeriod, '15 minutes', $endPeriod);

        $hours = [];
        foreach ($period as $date) {
            $hours[] = $date->format('H:i');
        }

        // ✅ Ensure last element is shown as 24:00 instead of 00:00
        if (!empty($hours)) {
            $hours[count($hours) - 1] = '24:00';
        }

        $interval = 15;
        if ($trading_unit['app_setting'] != null) {
            $interval = $trading_unit['app_setting']['interval'] != 0
                ? (int) $trading_unit['app_setting']['interval']
                : 15;
        }

        $periods = CarbonPeriod::create($startPeriod, $interval . ' minutes', $endPeriod);

        $hour_end_time = [];
        foreach ($periods as $date) {
            $hour_end_time[] = $date->format('H:i');
        }

        // ✅ Ensure last element is shown as 24:00 instead of 00:00
        if (!empty($hour_end_time)) {
            $hour_end_time[count($hour_end_time) - 1] = '24:00';
        }

        // return $hour_end_time;

        return view(
            'vender::service_provider.trading_unit.app_setting.edit_booking_setting',
            get_defined_vars()
        );
    }

    public function bookingSettingSubmit(Request $request)
    {

        // return $request;


        $exist = TradingUnitAppSetting::where('trading_id', $request['id'])->first();

        if (isset($exist)) {

            TradingUnitAppSetting::where('trading_id', $request['id'])->update([

                'trading_id' => $request['id'],
                'start_time' => $request['start_time'],
                'end_time' => $request['end_time'],
                'interval' => $request['interval'],


            ]);
        } else {
            TradingUnitAppSetting::create([

                'trading_id' => $request['id'],
                'start_time' => $request['start_time'],
                'end_time' => $request['end_time'],
                'interval' => $request['interval'],


            ]);
        }

        return  redirect()->route('vender.service.provider.trading.unit.app.setting', $request['id']);
    }

    public function invoiceSetting($id)
    {

        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }


        $trading_unit = TradingUnit::find($id);

        $sites = VenderAddress::where('vender_id', $vender_id)->get();
        $banks = BankAccount::where('vender_id', $vender_id)->where('status','Verified')->get();
        $bank_id=0;
        $bank = BankAccount::where('vender_id', $vender_id)->where('account_name',$trading_unit['app_setting']['account_name'])->where('status','Verified')->first();
        if(isset($bank)){
            $bank_id=$bank['id'];
        }
        


        return view('vender::service_provider.trading_unit.app_setting.edit_invoice_setting', get_defined_vars());
    }

    public function invoiceSettingSubmit(Request $request)
    {


        $exist = TradingUnitAppSetting::where('trading_id', $request['id'])->first();

        if (isset($exist)) {

            TradingUnitAppSetting::where('trading_id', $request['id'])->update($request->except('_token', 'id'));
        } else {
            TradingUnitAppSetting::create([

                'trading_id' => $request['id'],
                ...$request->except('id')


            ]);
        }

        return  redirect()->route('vender.service.provider.trading.unit.app.setting', $request['id']);
    }
    public function vatSetting($id)
    {

        $user = auth()->user();


        $trading_unit = TradingUnit::find($id);


        return view('vender::service_provider.trading_unit.app_setting.edit_vat_setting', get_defined_vars());
    }

    public function vatSettingSubmit(Request $request)
    {


        $exist = TradingUnitAppSetting::where('trading_id', $request['id'])->first();

        if (isset($exist)) {

            TradingUnitAppSetting::where('trading_id', $request['id'])->update($request->except('_token', 'id'));
        } else {
            TradingUnitAppSetting::create([

                'trading_id' => $request['id'],
                ...$request->except('id')


            ]);
        }

        return  redirect()->route('vender.service.provider.trading.unit.app.setting', $request['id']);
    }


    public function tradingUnitActive($id)
    {

        $user = auth()->user();


        $trading_unit = TradingUnit::find($id)->update([

            'status' => 'ACTIVE'

        ]);


        return  redirect()->back();
    }
    public function tradingUnitInActive($id)
    {

        $user = auth()->user();


        $trading_unit = TradingUnit::find($id)->update([

            'status' => 'INACTIVE'

        ]);


        return  redirect()->back();
    }
    public function tradingUnitOnLine($id)
    {

        $user = auth()->user();


        $trading_unit = TradingUnit::find($id)->update([

            'active_status' => 'ONLINE'

        ]);


        return  redirect()->back();
    }
    public function tradingUnitOffLine($id)
    {

        $user = auth()->user();


        $trading_unit = TradingUnit::find($id)->update([

            'active_status' => 'OFFLINE'

        ]);


        return  redirect()->back();
    }

    public function tradingUnitStore(Request $request)
    {



        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:trading_units'],
        ]);


        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }

        $site = VenderAddress::find($request['site_id']);
        
         $operationTypes = $request['operation_type']; // Example input

        // Check count and decide output
        if (count($operationTypes) === 2) {
            $operation = "Both";
        } else {
            $operation = $operationTypes[0] ?? null; // Get first value or null if empty
        }

        $unit = TradingUnit::create([
            'vender_id' => $vender_id,
            'name' => $request['name'],
            'trading_name_id' => $request['trading_name_id'] ?? 0,
            'trading_template' => $request['trading_template'],
            'operation_type' => $operation,
            'city' => $request['city'],
            'postcode' => $request['postcode'],
            'radius' => $request['radius'],
            'mobile' => $request['mobile'],
            'landline' => $request['landline'],
            'lat' => $site['lat'] ?? '',
            'long' => $site['long'] ?? '',
            'email' => $request['email'],
            'site_id' => $request['site_id'] ?? '0',
            'status'=>'Active'


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


        return  redirect()->route('vender.service.provider.trading.unit');
    }
    public function tradingUnitUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:trading_units,name,' . $request->id,
        ]);

        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }

        $site = VenderAddress::find($request['site_id']);
        
           $operationTypes = $request['operation_type']; 
        
         if (count($operationTypes) === 2) {
            $operation = "Both";
        } else {
            $operation = $operationTypes[0] ?? null; // Get first value or null if empty
        }

        TradingUnit::find($request['id'])->update([
            'vender_id' => $vender_id,
            'name' => $request['name'],
            'trading_name_id' => $request['trading_name_id'] ?? 0,
            'operation_type' => $operation,
            'trading_template' => $request['trading_template'],
            'city' => $request['city'],
            'postcode' => $request['postcode'],
            'radius' => $request['radius'],
            'mobile' => $request['mobile'],
            'landline' => $request['landline'],
            'email' => $request['email'],
            'site_id' => $request['site_id'] ?? '0',
            'lat' => $site['lat'] ?? '',
            'long' => $site['long'] ?? '',
            'status'=>'Active'


        ]);


        TradingUnitAppSetting::where('trading_id', $request['id'])->update([


            'header_option' => $request['trading_template'],




        ]);


        return  redirect()->route('vender.service.provider.trading.unit');
    }


    public function contact($id)
    {

        $trading_unit = TradingUnit::find($id);

        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }



        $contacts = ContactDetail::where('vender_id', $vender_id)->where('trading_id', $id)->get();


        return view('vender::service_provider.trading_unit.appData.contact', get_defined_vars());
    }

    public function vehicle($id)
    {

        $trading_unit = TradingUnit::find($id);

        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }

        $contacts = Vehicle::where('vender_id', $vender_id)->where('trading_id', $id)->get();


        return view('vender::service_provider.trading_unit.appData.vehicle', get_defined_vars());
    }

    public function vehicleDetail($id)
    {

        $contact = Vehicle::with('bookings')->find($id);
        $trading_unit = TradingUnit::find($contact['trading_id']);



        return view('vender::service_provider.trading_unit.appData.vehicle_detail', get_defined_vars());
    }
    public function contactDetail($id)
    {

        $contact = ContactDetail::with('bookings')->find($id);
        $trading_unit = TradingUnit::find($contact['trading_id']);



        return view('vender::service_provider.trading_unit.appData.contact_detail', get_defined_vars());
    }

    public function quoteDetail($id)
    {

        $contact = Quotation::find($id);
        $trading_unit = TradingUnit::find($contact['trading_id']);



        return view('vender::service_provider.trading_unit.appData.quote_detail', get_defined_vars());
    }

    public function quotes($id)
    {

        $trading_unit = TradingUnit::find($id);

        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }

        $contacts = Quotation::where('vender_id', $vender_id)->where('trading_id', $id)->get();


        return view('vender::service_provider.trading_unit.appData.quotes', get_defined_vars());
    }
    public function bookingDetail($id)
    {

        $contact = Booking::find($id);
        $trading_unit = TradingUnit::find($contact['trading_id']);



        return view('vender::service_provider.trading_unit.appData.booking_detail', get_defined_vars());
    }

    public function booking($id)
    {

        $trading_unit = TradingUnit::find($id);

        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }

        $contacts = Booking::where('vender_id', $vender_id)->where('trading_id', $id)->get();


        return view('vender::service_provider.trading_unit.appData.booking', get_defined_vars());
    }

    public function jobs($id)
    {

        $trading_unit = TradingUnit::find($id);

        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }

        $contacts = Booking::with([
            'vehicle.vehicle_model',
            'vehicle.vehicle_make',
            'vehicle.engine_size',
            'vehicle.transmission_type',
            'vehicle.fuel_type',
            'vehicle.color',
            'contact_detail',
            'service',
            'job_requests',
            'booking_items',
            'job_requests.job_types',
            'job_requests.job_types.job_type',
        ])->where('vender_id', $vender_id)->whereIn('status', ['ARRIVED', 'INPROGRESS', 'FINAL_CHECKS', 'READ_FOR_COLLECTION', 'READY_FOR_DELIVERY', 'COLLECTED', 'DELIVERED'])->where('trading_id', $id)->get();


        return view('vender::service_provider.trading_unit.appData.jobs', get_defined_vars());
    }

    public function jobDetail($id)
    {

        $contact = Booking::find($id);

        $trading_unit = TradingUnit::find($contact['trading_id']);




        return view('vender::service_provider.trading_unit.appData.job_detail', get_defined_vars());
    }

    public function invoices($id)
    {

        $trading_unit = TradingUnit::find($id);

        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }

        $contacts = Invoice::where('vender_id', $vender_id)->where('trading_id', $id)->get();


        return view('vender::service_provider.trading_unit.appData.invoices', get_defined_vars());
    }
    public function invoiceDetail($id)
    {

        // return $id;
        $user = auth()->user();
        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }

        $contact = Invoice::find($id);


        $trading_unit = TradingUnit::find($contact['trading_id']);



        return view('vender::service_provider.trading_unit.appData.invoice_detail', get_defined_vars());
    }

    public function payments($id)
    {

        $trading_unit = TradingUnit::find($id);

        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }

        $contacts = BookingTransaction::where('vender_id', $vender_id)->with(['invoice' => function ($q) use ($id) {
            $q->where("trading_id", $id);
        }])->get();


        return view('vender::service_provider.trading_unit.appData.payments', get_defined_vars());
    }

    public function paymentDetail($id)
    {

        $user = auth()->user();

        $vender_id = 0;

        if ($user['vender_id'] == 0) {
            $vender_id = $user['id'];
        } else {
            $vender_id = $user['vender_id'];
        }

        $contact = BookingTransaction::where('vender_id', $vender_id)->find($id);
        $trading_unit = TradingUnit::find($contact['invoice']['trading_id']);



        return view('vender::service_provider.trading_unit.appData.payment_detail', get_defined_vars());
    }


    public function generateTime(Request $request)
    {

        $startPeriod = Carbon::parse($request['startTime']);
        $endPeriod   = Carbon::parse('24:00'); // will roll over to 00:00 next day

        $period = CarbonPeriod::create($startPeriod, $request['interval'] . ' minutes', $endPeriod);

        $hours = [];
        foreach ($period as $date) {
            $hours[] = $date->format('H:i');
        }

        // If last element is "00:00" (next day) OR not exactly "24:00", fix it
        $last = end($hours);
        if ($last !== '24:00') {
            $hours[count($hours) - 1] = '24:00';
        }

        return response()->json([
            'hours'  => $hours,
            'status' => true
        ]);
    }
}
