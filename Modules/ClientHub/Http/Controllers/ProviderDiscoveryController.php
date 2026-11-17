<?php

namespace Modules\ClientHub\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\JobType;
use Modules\ClientHub\Entities\Client;
use Modules\ClientHub\Entities\LinkVender;
use Modules\Vender\Entities\TradingUnit;

class ProviderDiscoveryController extends Controller
{
    public function filters()
    {
        $jobs = JobType::query()->select(['id', 'name', 'parent_id'])->whereNotNull('name')
            ->whereRaw("TRIM(name) <> ''")->orderBy('name')->orderBy('id')->get();
        $filters = [
            ['id' => 'operation-onsite', 'name' => 'On-site', 'hasDropdown' => false],
            ['id' => 'operation-mobile', 'name' => 'Mobile', 'hasDropdown' => false],
            ['id' => 'hub-connect', 'name' => 'Hub Connect', 'hasDropdown' => false, 'parentId' => null],
        ];
        foreach ($jobs as $job) {
            $filters[] = ['id' => 'job-' . $job->id, 'name' => trim($job->name), 'hasDropdown' => true,
                'parentId' => $job->parent_id ? 'job-' . $job->parent_id : null];
        }

        return response()->json(['status' => true, 'filters' => $filters])->header('Cache-Control', 'private, no-store');
    }

    private function approved(): Builder
    {
        // Match the existing approved-vendor discovery rules, including one unit per vendor.
        return TradingUnit::query()->whereIn('trading_units.status', ['ACTIVE', 'Active', 'active', 'APPROVED', 'approved'])
            ->whereHas('vender', function (Builder $vendor) {
                $vendor->where(function (Builder $status) {
                    $status->whereIn('status', ['ACTIVE', 'ACCEPTED', 'active', 'accepted', 'APPROVED', 'approved'])
                        ->orWhereIn('application_status', ['ACCEPTED', 'approved', 'APPROVED']);
                });
            })->whereIn('trading_units.id', function ($latest) {
                $latest->selectRaw('MAX(id)')->from('trading_units')
                    ->whereIn('status', ['ACTIVE', 'Active', 'active', 'APPROVED', 'approved'])
                    ->whereNotNull('vender_id')->groupBy('vender_id');
            })->with(['vender.profile', 'trading_name', 'site', 'job_types.job_type', 'product_offers']);
    }

    public function index(Request $request)
    {
        $input = $request->validate([
            'lat' => 'nullable|required_with:lng|numeric|between:-90,90',
            'lng' => 'nullable|required_with:lat|numeric|between:-180,180',
            'postcode' => 'nullable|string|max:16',
            'page' => 'sometimes|integer|min:1', 'search' => 'nullable|string|max:150',
            'providerNames' => 'sometimes|array|max:20', 'providerNames.*' => 'string|max:150',
            'providerIds' => 'sometimes|array|max:20', 'providerIds.*' => 'integer|min:1',
            'jobTerms' => 'sometimes|array|max:30', 'jobTerms.*' => 'string|max:150',
            'categories' => 'sometimes|array|max:30', 'categories.*' => 'string|max:150',
            'filterIds' => 'sometimes|array|max:30',
            'filterIds.*' => ['string', 'max:64', 'regex:/^(operation-(onsite|mobile)|hub-connect|job-[1-9][0-9]*)$/'],
        ]);
        $query = $this->approved()->select('trading_units.*');
        $client = $request->user('sanctum');
        $linked = $client instanceof Client ? LinkVender::where('hub_id', $client->id)->pluck('vender_id')->all() : [];
        if (in_array('hub-connect', $input['filterIds'] ?? [], true)) {
            // Apply account-scoped links before pagination and the other filters.
            $query->where(function (Builder $match) use ($linked) {
                $match->whereIn('trading_units.id', $linked)->orWhereIn('trading_units.vender_id', $linked);
            });
        }
        $postcode = strtoupper(str_replace(' ', '', trim($input['postcode'] ?? '')));
        // Mobile coverage requires an exact selected-postcode match; radius is not used.
        $query->where(function (Builder $coverage) use ($postcode) {
            $coverage->whereRaw("LOWER(COALESCE(trading_units.operation_type, '')) NOT LIKE ?", ['%mobile%']);
            if ($postcode !== '') {
                $coverage->orWhereRaw("UPPER(REPLACE(TRIM(COALESCE(trading_units.postcode, '')), ' ', '')) = ?", [$postcode]);
            }
        });
        if (!empty($input['providerIds'])) $query->whereIn('trading_units.id', $input['providerIds']);
        if (!empty($input['search'])) {
            $query->where(function (Builder $match) use ($input) {
                $term = '%' . $input['search'] . '%';
                $match->where('trading_units.name', 'like', $term)
                    ->orWhere('trading_units.city', 'like', $term)->orWhere('trading_units.postcode', 'like', $term)
                    ->orWhere('trading_units.operation_type', 'like', $term)
                    ->orWhereHas('trading_name', fn (Builder $q) => $q->where('name', 'like', $term))
                    ->orWhereHas('vender.profile', fn (Builder $q) => $q->where('company_name', 'like', $term))
                    ->orWhereHas('site', function (Builder $q) use ($term) {
                        $q->where('address_line_1', 'like', $term)->orWhere('city', 'like', $term)->orWhere('postcode', 'like', $term);
                    })->orWhereHas('job_types.job_type', fn (Builder $q) => $q->where('name', 'like', $term))
                    ->orWhereHas('product_offers', fn (Builder $q) => $q->where('product_name', 'like', $term));
            });
        }
        foreach ($input['providerNames'] ?? [] as $name) {
            $query->where(function (Builder $match) use ($name) {
                $term = '%' . $name . '%';
                $match->where('trading_units.name', 'like', $term)
                    ->orWhereHas('trading_name', fn (Builder $q) => $q->where('name', 'like', $term))
                    ->orWhereHas('vender.profile', fn (Builder $q) => $q->where('company_name', 'like', $term));
            });
        }
        foreach ($input['jobTerms'] ?? [] as $term) {
            $query->where(function (Builder $match) use ($term) {
                $match->whereHas('job_types.job_type', fn (Builder $q) => $q->where('name', 'like', '%' . $term . '%'))
                    ->orWhereHas('product_offers', fn (Builder $q) => $q->where('product_name', 'like', '%' . $term . '%'));
            });
        }
        // Match any selected operation AND any selected job, before pagination.
        $operationTypes = [];
        $jobIds = [];
        foreach ($input['filterIds'] ?? [] as $filterId) {
            if ($filterId === 'operation-onsite') $operationTypes[] = 'On-site';
            elseif ($filterId === 'operation-mobile') $operationTypes[] = 'Mobile';
            elseif (str_starts_with($filterId, 'job-')) $jobIds[] = (int) substr($filterId, 4);
        }
        $jobNames = [];
        foreach ($input['categories'] ?? [] as $category) {
            if (in_array($category, ['On-site', 'Mobile'], true)) $operationTypes[] = $category;
            else $jobNames[] = $category;
        }
        if ($operationTypes) {
            $query->where(function (Builder $match) use ($operationTypes) {
                foreach (array_unique($operationTypes) as $operation) {
                    $match->orWhere('trading_units.operation_type', 'like', '%' . $operation . '%');
                }
            });
        }
        if ($jobIds || $jobNames) {
            $jobIds = $this->includeChildJobs($jobIds);
            $query->whereHas('job_types', function (Builder $jobs) use ($jobIds, $jobNames) {
                $jobs->where(function (Builder $match) use ($jobIds, $jobNames) {
                    if ($jobIds) $match->whereIn('job_type_id', $jobIds);
                    foreach ($jobNames as $name) {
                        $term = $name === 'Service' ? 'servic' : $name;
                        $match->orWhereHas('job_type', fn (Builder $q) => $q->where('name', 'like', '%' . $term . '%'));
                    }
                });
            });
        }
        if ($this->withDistance($query, $input)) {
            $query->orderByRaw('discovery_distance IS NULL')->orderBy('discovery_distance');
        }
        $page = $query->orderByDesc('trading_units.id')->paginate(20, ['*'], 'page', $input['page'] ?? 1);
        return response()->json(['status' => true,
            'providers' => $page->getCollection()->map(fn ($unit) => $this->card($unit, $linked))->values(),
            'nextPage' => $page->hasMorePages() ? $page->currentPage() + 1 : null,
        ])->header('Cache-Control', 'private, no-store');
    }

    private function includeChildJobs(array $jobIds): array
    {
        $allIds = array_values(array_unique($jobIds));
        $pending = $allIds;
        // Walk the actual hierarchy, including nested groups, with cycle protection.
        while ($pending) {
            $children = JobType::query()->whereIn('parent_id', $pending)->pluck('id')->all();
            $pending = array_values(array_diff($children, $allIds));
            $allIds = array_merge($allIds, $pending);
        }
        return $allIds;
    }

    private function withDistance(Builder $query, array $input): bool
    {
        if (isset($input['lat'], $input['lng']) && ((float) $input['lat'] !== 0.0 || (float) $input['lng'] !== 0.0)) {
            $query->leftJoin('vender_addresses as discovery_site', 'discovery_site.id', '=', 'trading_units.site_id');
            $unitCoordinates = "NULLIF(trading_units.lat, '') IS NOT NULL AND NULLIF(trading_units.long, '') IS NOT NULL AND NOT (trading_units.lat = 0 AND trading_units.long = 0)";
            $lat = "CASE WHEN $unitCoordinates THEN trading_units.lat ELSE NULLIF(discovery_site.lat, '') END";
            $lng = "CASE WHEN $unitCoordinates THEN trading_units.long ELSE NULLIF(discovery_site.long, '') END";
            $cosine = "COS(RADIANS(?))*COS(RADIANS($lat))*COS(RADIANS($lng)-RADIANS(?))+SIN(RADIANS(?))*SIN(RADIANS($lat))";
            $query->selectRaw("CASE WHEN ($lat) = 0 AND ($lng) = 0 THEN NULL ELSE 3958.7613 * ACOS(LEAST(1, GREATEST(-1, $cosine))) END AS discovery_distance",
                [$input['lat'], $input['lng'], $input['lat']]);
            return true;
        }
        return false;
    }

    private function favoriteClient(Request $request): Client
    {
        abort_unless($request->user() instanceof Client, 403);
        return $request->user();
    }

    public function favorites(Request $request)
    {
        $client = $this->favoriteClient($request);
        $input = $request->validate([
            'lat' => 'nullable|required_with:lng|numeric|between:-90,90',
            'lng' => 'nullable|required_with:lat|numeric|between:-180,180',
            'postcode' => 'nullable|string|max:16',
        ]);
        $query = $this->approved()->select('trading_units.*')
            ->join('client_favorites as saved', 'saved.trading_unit_id', '=', 'trading_units.id')
            ->where('saved.client_id', $client->id);
        $this->withDistance($query, $input);
        $linked = LinkVender::where('hub_id', $client->id)->pluck('vender_id')->all();
        $postcode = strtoupper(preg_replace('/\s+/', '', $input['postcode'] ?? ''));
        // A saved mobile provider remains saved when the client changes location.
        $favorites = $query->orderByDesc('saved.created_at')->orderByDesc('saved.id')->get()
            ->map(function ($unit) use ($linked, $postcode) {
                $card = $this->card($unit, $linked);
                $card['isFavorite'] = true;
                if (stripos($unit->operation_type ?? '', 'Mobile') !== false &&
                    ($postcode === '' || $postcode !== strtoupper(preg_replace('/\s+/', '', $unit->postcode ?? '')))) {
                    $card['distanceOrCoverage'] = 'Mobile service';
                    $card['isCoverageItalic'] = false;
                }
                return $card;
            })->values();
        return response()->json(['status' => true, 'favorites' => $favorites])->header('Cache-Control', 'private, no-store');
    }

    public function addFavorite(Request $request)
    {
        $client = $this->favoriteClient($request);
        $input = $request->validate(['providerId' => 'required|integer|min:1']);
        $unit = $this->approved()->findOrFail($input['providerId']);
        DB::table('client_favorites')->insertOrIgnore([
            'client_id' => $client->id, 'trading_unit_id' => $unit->id,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        return response()->json([
            'status' => true, 'success' => true, 'isFavorite' => true,
            'providerId' => (string) $unit->id, 'message' => 'Added to favourites',
        ])->header('Cache-Control', 'private, no-store');
    }

    public function removeFavorite(Request $request, int $id)
    {
        $client = $this->favoriteClient($request);
        DB::table('client_favorites')->where('client_id', $client->id)->where('trading_unit_id', $id)->delete();
        return response()->json([
            'status' => true, 'success' => true, 'isFavorite' => false,
            'providerId' => (string) $id, 'message' => 'Removed from favourites',
        ])->header('Cache-Control', 'private, no-store');
    }

    public function favoriteStatus(Request $request, int $id)
    {
        $client = $this->favoriteClient($request);
        return response()->json([
            'status' => true, 'isFavorite' => DB::table('client_favorites')
                ->where('client_id', $client->id)->where('trading_unit_id', $id)->exists(),
        ])->header('Cache-Control', 'private, no-store');
    }

    private function card(TradingUnit $unit, array $linked): array
    {
        $company = trim($unit->vender->profile->company_name ?? '');
        $trading = trim($unit->trading_name->name ?? '');
        $name = $trading ?: ($company ?: $unit->name);
        if ((int) $unit->trading_template === 1) $name = $company ?: $name;
        elseif ((int) $unit->trading_template === 2 && $company && $trading) $name = "$company Trading as $trading";
        $mobile = stripos($unit->operation_type ?? '', 'Mobile') !== false;
        $onsite = stripos($unit->operation_type ?? '', 'On-site') !== false;
        $distance = $unit->discovery_distance;
        $coverage = $mobile
            ? 'Serves your area'
            : ($distance !== null ? number_format((float) $distance, 1) . ' miles away' : '0.0 miles away');
        $site = $unit->site;
        $address = $onsite && $site ? implode(', ', array_filter([
            $site->address_line_1, $site->address_line_2, $site->address_line_3, $site->address_line_4,
            trim("{$site->city} {$site->postcode}"),
        ])) : null;
        $services = $unit->job_types->map(fn ($job) => $job->job_type->name ?? null)->filter()->unique()->values()->all();
        return [
            'id' => (string) $unit->id, 'name' => $name,
            'truId' => $unit->tru_id ?: 'TRU' . str_pad((string) $unit->id, 6, '0', STR_PAD_LEFT),
            'isFavorite' => false, 'isLinked' => in_array($unit->id, $linked) || in_array($unit->vender_id, $linked),
            'serviceType' => $unit->operation_type ?: '', 'distanceOrCoverage' => trim($coverage),
            'isCoverageItalic' => $mobile, 'address' => $address,
            'ratings' => [], 'services' => implode(' • ', array_slice($services, 0, 2)),
            'additionalServices' => count($services) > 2 ? $services[2] . (count($services) > 3 ? '… and more' : '') : null,
        ];
    }

    public function show(Request $request, int $id)
    {
        $unit = $this->approved()->with(['hub_setting', 'product_offers.job_type', 'payment_methods.payment_method',
            'warranty_jobs.warranty_job', 'vehicle_specialists.vehicle_specialist', 'accreditations.accreditation'])->findOrFail($id);
        $card = $this->card($unit, []);
        $schedule = [];
        $open = false;
        $todayHours = '';
        $now = Carbon::now('Europe/London');
        if ($unit->hub_setting) {
            foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day) {
                $key = strtolower($day);
                $closed = !(bool) $unit->hub_setting->{'is_' . $key};
                $hours = $closed ? 'Closed' : $unit->hub_setting->{$key . '_start_time'} . ' – ' . $unit->hub_setting->{$key . '_end_time'};
                $schedule[] = ['day' => $day, 'hours' => $hours, 'isClosed' => $closed];
                if ($now->format('l') === $day) {
                    $todayHours = $hours;
                    if (!$closed) {
                        try {
                            $start = Carbon::parse($unit->hub_setting->{$key . '_start_time'}, 'Europe/London');
                            $end = Carbon::parse($unit->hub_setting->{$key . '_end_time'}, 'Europe/London');
                            if ($end->lessThan($start)) $end->addDay();
                            $open = $now->between($start, $end);
                        } catch (\Exception $e) { $todayHours = ''; }
                    }
                }
            }
        }
        $names = fn ($collection, $relation) => $collection->map(fn ($item) => $item->{$relation}->name ?? null)->filter()->unique()->values()->all();
        $profile = [
            'id' => $card['id'], 'name' => $card['name'], 'truId' => $card['truId'], 'isFavorite' => false,
            'location' => ['serviceType' => $card['serviceType'], 'distanceDisplay' => '', 'address' => $card['address'] ?? trim("{$unit->city} {$unit->postcode}"),
                'latitude' => is_numeric($unit->lat ?? $unit->site->lat ?? null) ? (float) ($unit->lat ?? $unit->site->lat) : null,
                'longitude' => is_numeric($unit->long ?? $unit->site->long ?? null) ? (float) ($unit->long ?? $unit->site->long) : null],
            'ratings' => [], 'openingHours' => ['isOpenNow' => $open, 'todayHoursDisplay' => $todayHours, 'schedule' => $schedule],
            'contact' => ['businessName' => $card['name'], 'phoneNumbers' => array_values(array_filter([$unit->landline, $unit->mobile])),
                'website' => $unit->website ?: ($unit->hub_setting->website ?? ''), 'email' => $unit->email ?: ''],
            'serviceCategories' => $unit->job_types->filter(fn ($item) => $item->job_type)->map(fn ($item) => [
                'id' => (string) $item->job_type_id, 'title' => $item->job_type->name,
                'services' => [['id' => (string) $item->job_type_id, 'name' => $item->job_type->name]],
            ])->values(),
            'products' => $unit->product_offers->map(fn ($product) => ['id' => (string) $product->id, 'name' => $product->product_name,
                'jobType' => $product->job_type->name ?? '', 'description' => $product->description ?: '', 'jobCoverage' => '',
                'priceDisplay' => is_numeric($product->price) ? (($product->price_type === 'STARTING_FROM' ? 'from ' : '') . '£' . number_format($product->price, 2)) : 'Price on enquiry',
            ])->values(),
            'warranty' => ['warrantyWork' => [], 'selectedWarrantyProviders' => $names($unit->warranty_jobs, 'warranty_job')],
            'vehicleSpecialist' => ['manufacturerSpecialists' => $names($unit->vehicle_specialists, 'vehicle_specialist'), 'otherSpecialisms' => []],
            'accreditations' => ['accreditations' => $names($unit->accreditations, 'accreditation')],
            'paymentMethods' => ['methods' => $names($unit->payment_methods, 'payment_method')],
        ];
        if ($profile['location']['latitude'] === 0.0 && $profile['location']['longitude'] === 0.0) {
            $profile['location']['latitude'] = null;
            $profile['location']['longitude'] = null;
        }
        return response()->json(['status' => true, 'profile' => $profile])->header('Cache-Control', 'private, no-store');
    }
}
