<?php

namespace Modules\ClientHub\Services;

use DateTimeImmutable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DvlaVehicleEnquiryService
{
    public static function unavailableChecks(): array
    {
        return ['motStatus' => 'Unavailable', 'motExpiryDate' => null,
            'taxStatus' => 'Unavailable', 'taxExpiryDate' => null, 'lastChecked' => 'Not retrieved'];
    }

    private function cacheKey(string $vrm): string
    {
        // A new namespace excludes the old generated and client-supplied checks.
        return 'dvla_ves_checks_v1_' . hash('sha256', config('services.dvla.url') . '|' . $vrm);
    }

    public function cachedChecks(string $vrm): array
    {
        $vrm = strtoupper(preg_replace('/\s+/', '', $vrm));
        return Cache::get($this->cacheKey($vrm)) ?? self::unavailableChecks();
    }

    public function lookupChecks(string $vrm, bool $forceRefresh = false): array
    {
        $vrm = strtoupper(preg_replace('/\s+/', '', trim($vrm)));
        if (!preg_match('/^[A-Z0-9]{2,7}$/', $vrm)) {
            return ['status' => false, 'httpStatus' => 422, 'message' => 'Please enter a valid registration number.'];
        }

        if (!$forceRefresh && ($checks = Cache::get($this->cacheKey($vrm)))) {
            return ['status' => true, 'checks' => $checks];
        }

        $key = config('services.dvla.api_key');
        if (empty($key)) {
            return ['status' => false, 'httpStatus' => 503, 'message' => 'Vehicle checks are not configured yet. Please try again later.'];
        }

        try {
            // No automatic retries: VES has a limited request allowance.
            $response = Http::acceptJson()->asJson()->withHeaders(['x-api-key' => $key])
                ->connectTimeout(3)->timeout(5)
                ->post(config('services.dvla.url'), ['registrationNumber' => $vrm]);

            if (!$response->successful()) {
                // Do not log API keys, registration numbers, or response bodies.
                Log::warning('DVLA VES request failed.', ['status' => $response->status()]);
                return ['status' => false, 'httpStatus' => $response->status() === 404 ? 404 : 503,
                    'message' => $response->status() === 404
                        ? 'No DVLA vehicle checks were found for this registration.'
                        : 'Unable to retrieve vehicle checks from DVLA. Please try again.'];
            }

            $record = $response->json();
            if (!is_array($record) || ($record['registrationNumber'] ?? null) !== $vrm
                || (!isset($record['motStatus']) && !isset($record['taxStatus']))
                || (isset($record['motStatus']) && !is_string($record['motStatus']))
                || (isset($record['taxStatus']) && !is_string($record['taxStatus']))) {
                return ['status' => false, 'httpStatus' => 502, 'message' => 'DVLA returned an invalid vehicle checks response. Please try again.'];
            }

            $checks = [
                // Preserve official values, including SORN, Not valid and No details held by DVLA.
                'motStatus' => $record['motStatus'] ?? 'Unavailable',
                'motExpiryDate' => $this->formatDate($record['motExpiry'] ?? $record['motExpiryDate'] ?? null),
                'taxStatus' => $record['taxStatus'] ?? 'Unavailable',
                // The existing app field represents the tax due date.
                'taxExpiryDate' => $this->formatDate($record['taxDueDate'] ?? null),
                'lastChecked' => now()->format('d M Y, h:i A'),
                'source' => 'dvla',
            ];
            Cache::put($this->cacheKey($vrm), $checks, 86400);
            return ['status' => true, 'checks' => $checks];
        } catch (ConnectionException $e) {
            return ['status' => false, 'httpStatus' => 503, 'message' => 'DVLA vehicle checks are temporarily unavailable. Please try again.'];
        }
    }

    private function formatDate($value): ?string
    {
        if (!is_string($value) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return null;
        }
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
        return $date && $date->format('Y-m-d') === $value ? $date->format('d M Y') : null;
    }
}
