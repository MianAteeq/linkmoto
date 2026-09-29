<?php

namespace Modules\ClientHub\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Services;
use Modules\Vender\Entities\TradingUnit;
use Modules\ClientHub\Entities\LinkVender;
use Illuminate\Contracts\Support\Renderable;

class ServiceController extends Controller
{

    public function fetchServices(Request $request)
{
    try {
        $userId = $request->user() ? $request->user()->id : null;

        // Query TradingUnits (approved/active, marketplace enabled, latest first, ignore location)
        $query = TradingUnit::query()
            ->where(function ($q) {
                $q->where('status', 'ACTIVE')
                  ->orWhere('status', 'APPROVED')
                  ->orWhere('status', 'approved');
            })
            ->whereHas('hub_setting', function ($q) {
                $q->where('is_marketplace', 1);
            })
            ->with([
                'vender',
                'hub_setting',
                'trading_name',
                'job_types.job_type',
                'payment_methods.payment_method',
                'product_offers',
                'vehicle_specialists.vehicle_specialist',
                'accreditations.accreditation',
                'warranty_jobs.warranty_job'
            ])
            ->latest('id'); // Latest first

        $services = $query->paginate(10);

        // Set is_linked and default distance (0.00)
        foreach ($services as $service) {
            $service->distance = 0.00;
            if ($userId) {
                $linked = LinkVender::where('vender_id', $service->vender_id ?? $service->id)
                    ->where('hub_id', $userId)
                    ->first();
                $service->is_linked = $linked ? 1 : 0;
            } else {
                $service->is_linked = 0;
            }
        }

        return response()->json([
            'status' => true,
            'services' => $services,
            'message' => 'Services Fetch Successfully',
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'error' => $e->getMessage(),
            'message' => 'Error while getting Services',
        ], 500);
    }
}


   public function fetchByServicesID(Request $request)
   {

        try {

            $latitude=$request->user()->lat;
            $longtitude=$request->user()->long;

            $vender_ids=User::where('status', 'ACCEPTED')->pluck('id');

            $services=TradingUnit::where('status','ACTIVE')->whereIn('vender_id',$vender_ids)->with('vender')->whereHas("hub_setting",function($q) {
                $q->where("is_marketplace",1);
            })->whereHas('job_types', function($query) use ($request) {
                    $query->where('job_type_id',$request['service_id']);
                })->with(['hub_setting','trading_name','job_types.job_type','payment_methods.payment_method','product_offers','vehicle_specialists.vehicle_specialist','accreditations.accreditation','warranty_jobs.warranty_job'])
                ->select("trading_units.*" ,DB::raw("3959* acos(cos(radians(" . $latitude . "))
            * cos(radians(trading_units.lat))
           * cos(radians(trading_units.long) - radians(" . $longtitude . "))
            + sin(radians(" .$latitude. "))
            * sin(radians(trading_units.lat))) AS distance"))->havingRaw("distance < 25")->take(10)->get();

            // $services = User::where('status', 'ACTIVE')->whereHas('vender_services', function($query) use ($request) {
            //     $query->where('service_id',$request['service_id']);
            // })->with('profile', 'services', 'vender_services')->select("users.*" ,DB::raw("3959* acos(cos(radians(" . $latitude . "))
            // * cos(radians(users.lat))
            // * cos(radians(users.long) - radians(" . $longtitude . "))
            // + sin(radians(" .$latitude. "))
            // * sin(radians(users.lat))) AS distance"))->take(10)->get();
            return response()->json([
                'status' => true,
                'services' => $services,
                'message' => "Services Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Services",
            ]);
        }


   }
   public function fetchCategories(Request $request)
   {

        try {



            $categories = Services::take(2)->get();
            return response()->json([
                'status' => true,
                'categories' => $categories,
                'message' => "Services Category Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Services Category",
            ]);
        }


   }
   public function fetchAllCategories(Request $request)
   {

        try {



            $categories = Services::take(6)->where('parent_id',0)->get();
            return response()->json([
                'status' => true,
                'categories' => $categories,
                'message' => "Services Category Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Services Category",
            ]);
        }


   }
   public function fetchAllServices(Request $request)
   {

        try {



            $categories = Services::where('parent_id',0)->get();
            return response()->json([
                'status' => true,
                'categories' => $categories,
                'message' => "Services Category Fetch Successfully",
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => "Error while getting Services Category",
            ]);
        }


   }
}
