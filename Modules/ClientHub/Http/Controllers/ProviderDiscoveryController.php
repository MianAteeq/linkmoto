<?php

namespace Modules\ClientHub\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ClientHub\Entities\Client;
use Modules\ClientHub\Entities\LinkVender;
use Modules\Vender\Entities\TradingUnit;

class ProviderDiscoveryController extends Controller
{
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
            'page' => 'sometimes|integer|min:1', 'search' => 'nullable|string|max:150',
            'providerNames' => 'sometimes|array|max:20', 'providerNames.*' => 'string|max:150',
            'jobTerms' => 'sometimes|array|max:30', 'jobTerms.*' => 'string|max:150',
            'categories' => 'sometimes|array|max:30', 'categories.*' => 'string|max:150',
        ]);
        $query = $this->approved()->select('trading_units.*');
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
        if (!empty($input['categories'])) {
            $query->where(function (Builder $match) use ($input) {
                foreach ($input['categories'] as $category) {
                    if (in_array($category, ['On-site', 'Mobile'], true)) {
                        $match->orWhere('trading_units.operation_type', 'like', '%' . $category . '%');
                    } else {
                        $term = $category === 'Service' ? 'servic' : $category;
                        $match->orWhereHas('job_types.job_type', fn (Builder $q) => $q->where('name', 'like', '%' . $term . '%'));
                    }
                }
            });
        }
        if (isset($input['lat'], $input['lng'])) {
            $query->leftJoin('vender_addresses as discovery_site', 'discovery_site.id', '=', 'trading_units.site_id');
            $lat = "COALESCE(NULLIF(trading_units.lat, ''), NULLIF(discovery_site.lat, ''))";
            $lng = "COALESCE(NULLIF(trading_units.long, ''), NULLIF(discovery_site.long, ''))";
            $cosine = "COS(RADIANS(?))*COS(RADIANS($lat))*COS(RADIANS($lng)-RADIANS(?))+SIN(RADIANS(?))*SIN(RADIANS($lat))";
            $query->selectRaw("3958.7613 * ACOS(LEAST(1, GREATEST(-1, $cosine))) AS discovery_distance",
                [$input['lat'], $input['lng'], $input['lat']])
                ->orderByRaw('discovery_distance IS NULL')->orderBy('discovery_distance');
        }
        $page = $query->orderByDesc('trading_units.id')->paginate(20, ['*'], 'page', $input['page'] ?? 1);
        $client = $request->user('sanctum');
        $linked = $client instanceof Client ? LinkVender::where('hub_id', $client->id)->pluck('vender_id')->all() : [];
        return response()->json(['status' => true,
            'providers' => $page->getCollection()->map(fn ($unit) => $this->card($unit, $linked))->values(),
            'nextPage' => $page->hasMorePages() ? $page->currentPage() + 1 : null,
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
        $coverage = $mobile && !$onsite
            ? ($unit->radius ? "Up to {$unit->radius} miles from " . trim("{$unit->city} {$unit->postcode}") : 'Coverage available on enquiry')
            : ($distance !== null ? number_format((float) $distance, 1) . ' miles away' : 'Distance unavailable');
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
            'isCoverageItalic' => $mobile && !$onsite, 'address' => $address,
            'ratings' => [], 'services' => implode(' • ', $services),
        ];
    }
}
