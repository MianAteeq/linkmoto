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
        // Query vendors that are approved, eager load relationships, latest first, ignore location/distance
        $query = Vendor::query()
            ->with(['trading_name', 'job_types.job_type']) // adjust relation names if camelCase
            ->where(function ($q) {
                // Adjust to your table's approved column (e.g., status, is_approved, or approval_status)
                $q->where('status', 'APPROVED')
                  ->orWhere('status', 'approved')
                  ->orWhere('is_approved', 1)
                  ->orWhere('status', 1);
            })
            ->latest('id'); // Latest first

        // Paginate (10 or 15 per page to match mobile app pagination)
        $services = $query->paginate(10);

        return response()->json([
            'status' => true,
            'services' => $services,
            'message' => 'Vendors fetched successfully'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
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
