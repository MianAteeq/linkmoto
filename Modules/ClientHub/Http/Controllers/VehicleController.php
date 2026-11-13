<?php

namespace Modules\ClientHub\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\Entities\CarMaker;
use Modules\Admin\Entities\CarModel;
use Modules\Admin\Entities\EngineSize;
use Modules\Admin\Entities\FuelType;
use Modules\Admin\Entities\TransmissionType;
use Modules\Admin\Entities\VehicleColor;
use Modules\ClientHub\Services\DvsaMotHistoryService;
use Modules\Vender\Entities\Vehicle;

class VehicleController extends Controller
{
    protected DvsaMotHistoryService $dvsaService;

    public function __construct(DvsaMotHistoryService $dvsaService)
    {
        $this->dvsaService = $dvsaService;
    }

    /**
     * Look up UK vehicle by registration (VRM) using official DVSA MOT History API.
     */
    public function lookupVehicle(Request $request)
    {
        try {
            $vrm = (string) $request->input('vrm', $request->input('search', $request->route('vrm')));

            if (empty(trim($vrm))) {
                return response()->json([
                    'status'  => false,
                    'found'   => false,
                    'message' => 'Please provide a registration number.',
                ], 422);
            }

            $result = $this->dvsaService->lookupVehicle($vrm);
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'found'   => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while looking up vehicle details.',
            ], 500);
        }
    }

    /**
     * Add / Save a new vehicle for the authenticated client.
     */
    public function saveVehicleDetail(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'vrm' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $clientId = $request->user()->id;
            $cleanVrm = strtoupper(str_replace(' ', '', trim($request->vrm)));

            // Auto-resolve relational foreign keys if names were passed
            $makeId = $request->input('vehicle_make_id')
                ?? DvsaMotHistoryService::findOrCreateMake($request->input('make'));

            $modelId = $request->input('vehicle_model_id')
                ?? DvsaMotHistoryService::findOrCreateModel($request->input('model'), $makeId);

            $fuelId = $request->input('fuel_type_id')
                ?? DvsaMotHistoryService::findOrCreateFuel($request->input('fuelType', $request->input('fuel_type')));

            $colorId = $request->input('color_id')
                ?? DvsaMotHistoryService::findOrCreateColor($request->input('colour', $request->input('color')));

            $engineId = $request->input('engine_size_id')
                ?? DvsaMotHistoryService::findOrCreateEngineSize($request->input('engineSize', $request->input('engine_size')));

            $transId = $request->input('transmission_type_id')
                ?? DvsaMotHistoryService::findOrCreateTransmission($request->input('transmissionType', $request->input('transmission_type')));

            $vinNumber = $request->input('vin_number', $request->input('vin', ''));
            $year = $request->input('year', date('Y'));
            $vehicleNo = $request->input('vehicle_no', 'VEH-HUB' . str_pad((string)$clientId, 7, '0', STR_PAD_LEFT) . '-' . str_pad((string)rand(1, 999999), 6, '0', STR_PAD_LEFT));

            $veh = Vehicle::create([
                'vender_id'            => $clientId,
                'type'                 => 'Client',
                'vrm'                  => $cleanVrm,
                'vin_number'           => $vinNumber,
                'vehicle_make_id'      => $makeId,
                'vehicle_model_id'     => $modelId,
                'fuel_type_id'         => $fuelId,
                'color_id'             => $colorId,
                'engine_size_id'       => $engineId,
                'transmission_type_id' => $transId,
                'year'                 => $year,
                'vehicle_no'           => $vehicleNo,
            ]);

            $vehicleWithRelations = Vehicle::with([
                'vehicle_make',
                'vehicle_model',
                'engine_size',
                'transmission_type',
                'fuel_type',
                'color',
            ])->find($veh->id);

            if ($request->has('checks') && is_array($request->input('checks'))) {
                Cache::put("vehicle_checks_{$veh->id}", $request->input('checks'), 86400 * 30);
                Cache::put("vehicle_checks_{$cleanVrm}", $request->input('checks'), 86400 * 30);
            }

            $isFirstVehicle = Vehicle::where('vender_id', $clientId)->count() === 1;
            if ($isFirstVehicle || !Cache::has("client_{$clientId}_default_vehicle")) {
                Cache::forever("client_{$clientId}_default_vehicle", (int) $veh->id);
            }

            $defaultId = Cache::get("client_{$clientId}_default_vehicle");
            $isDefault = $defaultId ? ($veh->id == $defaultId) : true;
            $formatted = $this->formatClientVehicle($vehicleWithRelations, $isDefault);

            return response()->json([
                'status'         => true,
                'message'        => 'Vehicle Added Successfully',
                'vehicle'        => $formatted,
                'contact_detail' => $vehicleWithRelations,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while adding vehicle.',
            ], 500);
        }
    }

    /**
     * Get all vehicles for the authenticated client.
     */
    public function getVehicleDetail(Request $request)
    {
        try {
            $clientId = $request->user()->id;

            $vehicles = Vehicle::with([
                'vehicle_make',
                'vehicle_model',
                'engine_size',
                'transmission_type',
                'fuel_type',
                'color',
            ])
            ->where('vender_id', $clientId)
            ->where(function ($q) {
                $q->where('type', 'Client')->orWhereNull('type');
            })
            ->latest()
            ->get();

            $defaultId = Cache::get("client_{$clientId}_default_vehicle");
            $formattedVehicles = $vehicles->map(function ($v, $idx) use ($defaultId) {
                $isDefault = $defaultId ? ($v->id == $defaultId) : ($idx === 0);
                return $this->formatClientVehicle($v, $isDefault);
            })->values();

            return response()->json([
                'status'          => true,
                'message'         => 'Vehicles Fetch Successfully',
                'vehicles'        => $formattedVehicles,
                'contact_details' => $vehicles,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while getting vehicles.',
            ], 500);
        }
    }

    /**
     * Get a single vehicle by ID.
     */
    public function getSingleVehicle(Request $request, $id)
    {
        try {
            $clientId = $request->user()->id;

            $vehicle = Vehicle::with([
                'vehicle_make',
                'vehicle_model',
                'engine_size',
                'transmission_type',
                'fuel_type',
                'color',
            ])
            ->where('vender_id', $clientId)
            ->where('id', $id)
            ->first();

            if (!$vehicle) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Vehicle not found.',
                ], 404);
            }

            return response()->json([
                'status'  => true,
                'vehicle' => $this->formatClientVehicle($vehicle),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while getting vehicle.',
            ], 500);
        }
    }

    /**
     * Search vehicle by VRM or VIN for the authenticated client.
     */
    public function searchVehicleDetail(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'search' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $clientId = $request->user()->id;
            $term = trim($request->input('search'));

            $vehicles = Vehicle::with([
                'vehicle_make',
                'vehicle_model',
                'engine_size',
                'transmission_type',
                'fuel_type',
                'color',
            ])
            ->where('vender_id', $clientId)
            ->where(function ($q) use ($term) {
                $q->where('vrm', 'LIKE', "%{$term}%")
                  ->orWhere('vin_number', 'LIKE', "%{$term}%");
            })
            ->get();

            $defaultId = Cache::get("client_{$clientId}_default_vehicle");
            $formattedVehicles = $vehicles->map(function ($v, $idx) use ($defaultId) {
                $isDefault = $defaultId ? ($v->id == $defaultId) : ($idx === 0);
                return $this->formatClientVehicle($v, $isDefault);
            })->values();

            return response()->json([
                'status'          => true,
                'message'         => 'Vehicles Fetch Successfully',
                'vehicles'        => $formattedVehicles,
                'contact_details' => $vehicles,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while searching vehicles.',
            ], 500);
        }
    }

    /**
     * Update an existing vehicle.
     */
    public function updateVehicleDetail(Request $request, $id = null)
    {
        try {
            $vehicleId = $id ?? $request->route('id') ?? $request->input('id', $request->input('vehicle_id'));

            if (!$vehicleId) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Vehicle ID is required.',
                ], 422);
            }

            $clientId = $request->user()->id;
            $vehicle = Vehicle::where('vender_id', $clientId)->find($vehicleId);

            if (!$vehicle) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Vehicle not found.',
                ], 404);
            }

            if ($request->filled('vrm')) {
                $vehicle->vrm = strtoupper(str_replace(' ', '', trim($request->vrm)));
            }
            if ($request->filled('vin_number') || $request->filled('vin')) {
                $vehicle->vin_number = $request->input('vin_number', $request->input('vin'));
            }
            if ($request->filled('year')) {
                $vehicle->year = $request->input('year');
            }

            // Update relations if names provided
            if ($request->filled('make') || $request->filled('vehicle_make_id')) {
                $vehicle->vehicle_make_id = $request->input('vehicle_make_id')
                    ?? DvsaMotHistoryService::findOrCreateMake($request->input('make'));
            }
            if ($request->filled('model') || $request->filled('vehicle_model_id')) {
                $vehicle->vehicle_model_id = $request->input('vehicle_model_id')
                    ?? DvsaMotHistoryService::findOrCreateModel($request->input('model'), $vehicle->vehicle_make_id);
            }
            if ($request->filled('colour') || $request->filled('color') || $request->filled('color_id')) {
                $vehicle->color_id = $request->input('color_id')
                    ?? DvsaMotHistoryService::findOrCreateColor($request->input('colour', $request->input('color')));
            }
            if ($request->filled('fuelType') || $request->filled('fuel_type') || $request->filled('fuel_type_id')) {
                $vehicle->fuel_type_id = $request->input('fuel_type_id')
                    ?? DvsaMotHistoryService::findOrCreateFuel($request->input('fuelType', $request->input('fuel_type')));
            }
            if ($request->filled('engineSize') || $request->filled('engine_size') || $request->filled('engine_size_id')) {
                $vehicle->engine_size_id = $request->input('engine_size_id')
                    ?? DvsaMotHistoryService::findOrCreateEngineSize($request->input('engineSize', $request->input('engine_size')));
            }
            if ($request->filled('transmissionType') || $request->filled('transmission_type') || $request->filled('transmission_type_id')) {
                $vehicle->transmission_type_id = $request->input('transmission_type_id')
                    ?? DvsaMotHistoryService::findOrCreateTransmission($request->input('transmissionType', $request->input('transmission_type')));
            }

            $vehicle->save();

            $refreshed = Vehicle::with([
                'vehicle_make',
                'vehicle_model',
                'engine_size',
                'transmission_type',
                'fuel_type',
                'color',
            ])->find($vehicle->id);

            return response()->json([
                'status'         => true,
                'message'        => 'Vehicle Update Successfully',
                'vehicle'        => $this->formatClientVehicle($refreshed),
                'contact_detail' => $refreshed,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while updating vehicle.',
            ], 500);
        }
    }

    /**
     * Delete vehicle for authenticated client.
     */
    public function vehicleDelete(Request $request, $id = null)
    {
        try {
            $vehicleId = $id ?? $request->route('id') ?? $request->input('vehicle_id', $request->input('id'));
            $clientId = $request->user()->id;

            $vehicle = Vehicle::where('vender_id', $clientId)->find($vehicleId);

            if ($vehicle) {
                $vehicle->delete();
            }

            return response()->json([
                'status'  => true,
                'message' => 'Vehicle Delete Successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while deleting vehicle.',
            ], 500);
        }
    }

    /**
     * Set a vehicle as default for the authenticated client.
     */
    public function setDefaultVehicle(Request $request, $id = null)
    {
        try {
            $vehicleId = $id ?? $request->input('vehicle_id', $request->input('id'));
            $clientId = $request->user()->id;

            $vehicle = Vehicle::where('vender_id', $clientId)->find($vehicleId);
            if (!$vehicle) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Vehicle not found.',
                ], 404);
            }

            Cache::forever("client_{$clientId}_default_vehicle", (int) $vehicle->id);

            return response()->json([
                'status'  => true,
                'message' => 'Default vehicle updated.',
                'vehicle' => $this->formatClientVehicle($vehicle, true),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while setting default vehicle.',
            ], 500);
        }
    }

    /**
     * Refresh vehicle MOT & tax checks from DVSA.
     */
    public function refreshVehicleChecks(Request $request, $id = null)
    {
        try {
            $vehicleId = $id ?? $request->input('vehicle_id', $request->input('id'));
            $clientId = $request->user()->id;

            $vehicle = Vehicle::where('vender_id', $clientId)->find($vehicleId);
            if (!$vehicle) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Vehicle not found.',
                ], 404);
            }

            Cache::forget("vehicle_checks_{$vehicle->id}");
            Cache::forget("vehicle_checks_{$vehicle->vrm}");

            $lookup = $this->dvsaService->lookupVehicle($vehicle->vrm);
            $checks = !empty($lookup['vehicle']['checks'])
                ? $lookup['vehicle']['checks']
                : $this->dvsaService->computeDynamicChecksForVrm($vehicle->vrm, (string)$vehicle->year);

            $checks['lastChecked'] = 'Just now';
            Cache::put("vehicle_checks_{$vehicle->id}", $checks, 86400 * 30);
            Cache::put("vehicle_checks_{$vehicle->vrm}", $checks, 86400 * 30);

            return response()->json([
                'status' => true,
                'checks' => $checks,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'error'   => $e->getMessage(),
                'message' => 'Error while refreshing vehicle checks.',
            ], 500);
        }
    }

    /**
     * Helper to format Eloquent Vehicle for Motonos Hub Mobile App domain model.
     */
    protected function formatClientVehicle(Vehicle $v, ?bool $isDefault = null): array
    {
        $clientId = $v->vender_id;
        if ($isDefault === null) {
            $defaultId = Cache::get("client_{$clientId}_default_vehicle");
            $isDefault = $defaultId ? ($v->id == $defaultId) : false;
        }

        $make = $v->vehicle_make?->name ?? '';
        $model = $v->vehicle_model?->name ?? '';
        $colour = $v->color?->color ?? '';
        $fuel = $v->fuel_type?->name ?? '';
        $engine = $v->engine_size?->eng_size ?? '';
        $trans = $v->transmission_type?->transmission_types ?? 'Automatic';

        $checks = Cache::get("vehicle_checks_{$v->id}")
            ?? Cache::get("vehicle_checks_{$v->vrm}")
            ?? $this->dvsaService->computeDynamicChecksForVrm($v->vrm, (string)$v->year);

        return [
            'id'                 => (string) $v->id,
            'vehicleId'          => $v->vehicle_no ?: ('VEH-HUB' . str_pad((string)$v->vender_id, 7, '0', STR_PAD_LEFT) . '-' . str_pad((string)$v->id, 6, '0', STR_PAD_LEFT)),
            'registrationNumber' => $v->vrm,
            'make'               => $make,
            'model'              => $model,
            'vin'                => $v->vin_number,
            'year'               => (string) ($v->year ?? ''),
            'engineSize'         => $engine,
            'transmissionType'   => $trans,
            'fuelType'           => $fuel,
            'colour'             => $colour,
            'isDefault'          => $isDefault,
            'createdAt'          => $v->created_at?->toIso8601String() ?? now()->toIso8601String(),
            'checks'             => $checks,
            'linkedInfo'         => [
                'quotesCount'   => 0,
                'quotes'        => [],
                'bookingsCount' => 0,
                'bookings'      => [],
                'jobsCount'     => 0,
                'jobs'          => [],
            ],
            'documents'          => [],
        ];
    }

    /**
     * Get dynamic vehicle reference data:
     * makes, years, engine sizes, transmission types, fuel types, and colours.
     */
    public function getReferenceData(Request $request)
    {
        try {
            $data = Cache::remember('client_vehicle_ref_data_v1', 86400, function () {
                // 1. Makes
                $makes = CarMaker::whereNotNull('name')
                    ->where('name', '!=', '')
                    ->orderBy('name', 'ASC')
                    ->pluck('name')
                    ->unique()
                    ->values()
                    ->all();

                if (empty($makes)) {
                    $makes = [
                        'Chery', 'Volkswagen', 'Audi', 'BMW', 'Ford', 'Mercedes-Benz',
                        'Toyota', 'Nissan', 'Honda', 'Hyundai', 'Kia', 'Vauxhall',
                        'Land Rover', 'Jaguar', 'Volvo', 'Peugeot', 'Renault', 'Skoda',
                        'SEAT', 'Tesla', 'Other'
                    ];
                }

                // 2. Years: dynamic range from current year + 1 down to 1980
                $currentYear = (int) date('Y');
                $years = [];
                for ($y = $currentYear + 1; $y >= 1980; $y--) {
                    $years[] = (string) $y;
                }

                // 3. Engine Sizes
                $rawEngines = EngineSize::whereNotNull('eng_size')
                    ->where('eng_size', '!=', '')
                    ->pluck('eng_size')
                    ->map(fn($v) => trim($v))
                    ->unique()
                    ->values()
                    ->all();

                if (!empty($rawEngines)) {
                    if (!in_array('Electric', $rawEngines, true)) {
                        $rawEngines[] = 'Electric';
                    }
                    $engineSizes = $rawEngines;
                } else {
                    $engineSizes = [
                        '1.0 l', '1.2 l', '1.4 l', '1.5 l', '1.6 l', '1.8 l',
                        '2.0 l', '2.2 l', '2.5 l', '3.0 l', '3.5 l', '4.0 l', 'Electric'
                    ];
                }

                // 4. Transmission Types
                $rawTrans = TransmissionType::whereNotNull('transmission_types')
                    ->where('transmission_types', '!=', '')
                    ->pluck('transmission_types')
                    ->map(fn($v) => trim($v))
                    ->unique()
                    ->values()
                    ->all();

                if (!empty($rawTrans)) {
                    $priority = ['Automatic', 'Manual', 'Semi Automatic', 'CVT'];
                    $transmissionTypes = array_values(array_unique(array_merge(
                        array_intersect($priority, $rawTrans),
                        $rawTrans
                    )));
                } else {
                    $transmissionTypes = ['Automatic', 'Manual', 'Semi-Automatic'];
                }

                // 5. Fuel Types
                $rawFuels = FuelType::whereNotNull('name')
                    ->where('name', '!=', '')
                    ->pluck('name')
                    ->map(fn($v) => trim($v))
                    ->unique()
                    ->values()
                    ->all();

                if (!empty($rawFuels)) {
                    $fuelPriority = ['Petrol', 'Diesel', 'Hybrid', 'Petrol / Hybrid', 'Diesel / Hybrid', 'Electric', 'Plug-in Hybrid'];
                    $fuelTypes = array_values(array_unique(array_merge(
                        array_intersect($fuelPriority, $rawFuels),
                        $rawFuels
                    )));
                } else {
                    $fuelTypes = ['Petrol', 'Diesel', 'Hybrid / Petrol', 'Hybrid / Diesel', 'Electric', 'Plug-in Hybrid'];
                }

                // 6. Colours: Common automotive colours first, followed by all DB colors
                $primaryColours = [
                    'Black', 'White', 'Silver', 'Grey', 'Blue', 'Red', 'Green',
                    'Yellow', 'Orange', 'Brown', 'Beige', 'Gold', 'Bronze',
                    'Purple', 'Pink', 'Burgundy', 'Navy'
                ];
                $dbColours = VehicleColor::whereNotNull('color')
                    ->where('color', '!=', '')
                    ->orderBy('color', 'ASC')
                    ->pluck('color')
                    ->map(fn($c) => ucwords(strtolower(trim($c))))
                    ->unique()
                    ->values()
                    ->all();

                $allColours = array_values(array_unique(array_merge($primaryColours, $dbColours)));

                return [
                    'makes'             => $makes,
                    'years'             => $years,
                    'engineSizes'       => $engineSizes,
                    'transmissionTypes' => $transmissionTypes,
                    'fuelTypes'         => $fuelTypes,
                    'colours'           => $allColours,
                ];
            });

            return response()->json([
                'status'  => true,
                'data'    => $data,
                'message' => 'Vehicle reference data retrieved successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to retrieve vehicle reference data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get models for a specific vehicle make dynamically.
     */
    public function getModelsByMake(Request $request)
    {
        try {
            $makeName = trim((string) $request->input('make', $request->query('make', '')));
            $makeId = $request->input('vehicle_make_id', $request->query('vehicle_make_id'));

            if (empty($makeName) && empty($makeId)) {
                return response()->json([
                    'status' => true,
                    'make'   => '',
                    'models' => [],
                ]);
            }

            $cacheKey = 'client_vehicle_models_' . md5(strtolower($makeName) . '_' . (string)$makeId);
            $models = Cache::remember($cacheKey, 86400, function () use ($makeName, $makeId) {
                $makerQuery = CarMaker::query();
                if (!empty($makeId)) {
                    $makerQuery->where('id', $makeId);
                } else {
                    $makerQuery->where('name', 'like', $makeName);
                }
                $maker = $makerQuery->first();

                if (!$maker) {
                    return [];
                }

                return CarModel::where('parent_id', $maker->id)
                    ->whereNotNull('name')
                    ->where('name', '!=', '')
                    ->orderBy('name', 'ASC')
                    ->pluck('name')
                    ->unique()
                    ->values()
                    ->all();
            });

            return response()->json([
                'status' => true,
                'make'   => $makeName,
                'models' => $models,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to retrieve models: ' . $e->getMessage(),
            ], 500);
        }
    }
}

