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

        // Query approved trading units by vendor (one approved unit per approved vendor, no duplicates)
        $query = TradingUnit::query()
            ->whereIn('status', ['ACTIVE', 'Active', 'active', 'APPROVED', 'approved'])
            ->whereHas('vender', function ($vq) {
                $vq->where(function ($subQ) {
                    $subQ->whereIn('status', ['ACTIVE', 'ACCEPTED', 'active', 'accepted', 'APPROVED', 'approved'])
                         ->orWhereIn('application_status', ['ACCEPTED', 'approved', 'APPROVED']);
                });
            })
            ->whereIn('id', function ($sub) {
                $sub->selectRaw('MAX(id)')
                    ->from('trading_units')
                    ->whereIn('status', ['ACTIVE', 'Active', 'active', 'APPROVED', 'approved'])
                    ->whereNotNull('vender_id')
                    ->groupBy('vender_id');
            })
            // Commented out marketplace filter so all approved vendors show up:
            // ->whereHas('hub_setting', function ($q) {
            //     $q->where('is_marketplace', 1);
            // })
            ->with([
                'vender.profile',
                'hub_setting',
                'trading_name',
                'job_types.job_type',
                'payment_methods.payment_method',
                'product_offers',
                'vehicle_specialists.vehicle_specialist',
                'accreditations.accreditation',
                'warranty_jobs.warranty_job'
            ])
            ->latest('id');

        $services = $query->paginate(10);

        foreach ($services as $service) {
            $service->distance = 0.00;
            if ($userId) {
                $linked = LinkVender::where(function ($q) use ($service) {
                        $q->where('vender_id', $service->id)
                          ->orWhere('vender_id', $service->vender_id);
                    })
                    ->where('hub_id', $userId)
                    ->first();
                $service->is_linked = $linked ? 1 : 0;
            } else {
                $service->is_linked = 0;
            }

            // Resolve Vendor & Parent Vendor
            $vender = $service->vender ?? ($service->vender_id ? User::with('profile')->find($service->vender_id) : null);
            if ($vender && !$service->relationLoaded('vender')) {
                $service->setRelation('vender', $vender);
            }

            $parentVendor = null;
            if ($vender) {
                if (!empty($vender->vender_id) && $vender->vender_id != 0) {
                    $parentVendor = User::with('profile')->find($vender->vender_id);
                    $vender->setRelation('parent_vendor', $parentVendor);
                } else {
                    $parentVendor = $vender;
                    $vender->unsetRelation('parent_vendor');
                }
            }
            $service->setRelation('parent_vendor', $parentVendor);
            $service->parent_vendor = $parentVendor;

            // Business name as shown in invoice based on trading_template:
            // 1: Registered Company Name (from vendor/parent profile)
            // 2: Registered Company Name & Trading Name
            // 3: Trading Name only
            $companyName = trim($parentVendor->profile->company_name ?? ($vender->profile->company_name ?? ''));
            $tradingName = trim($service->trading_name->name ?? '');
            $template = (int) ($service->trading_template ?? 0);

            if ($template === 1) {
                $invoiceName = $companyName ?: ($tradingName ?: $service->name);
            } elseif ($template === 2) {
                if (!empty($companyName) && !empty($tradingName)) {
                    $invoiceName = $companyName . ' Trading as ' . $tradingName;
                } else {
                    $invoiceName = $tradingName ?: ($companyName ?: $service->name);
                }
            } elseif ($template === 3) {
                $invoiceName = $tradingName ?: ($companyName ?: $service->name);
            } else {
                // Fallback when template is not explicitly 1, 2, or 3
                if (!empty($companyName) && !empty($tradingName)) {
                    $invoiceName = $companyName . ' Trading as ' . $tradingName;
                } elseif (!empty($tradingName)) {
                    $invoiceName = $tradingName;
                } elseif (!empty($companyName)) {
                    $invoiceName = $companyName;
                } else {
                    $invoiceName = $service->name;
                }
            }

            $service->unit_name = $service->name;
            $service->invoice_name = $invoiceName;
            $service->display_name = $invoiceName;
            $service->business_name = $invoiceName;
            $service->name = $invoiceName ?: $service->name;
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
