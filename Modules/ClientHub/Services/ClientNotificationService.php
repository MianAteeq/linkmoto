<?php

namespace Modules\ClientHub\Services;

use Modules\ClientHub\Entities\ClientNotification;
use Modules\Vender\Entities\Booking;
use Modules\Vender\Entities\Invoice;
use Modules\Vender\Entities\Quotation;

class ClientNotificationService
{
    public static function notifyForBooking(Booking $booking): void
    {
        try {
            $booking->loadMissing([
                'contact_detail',
                'trading_name.trading_name',
                'vender.profile',
            ]);

            $clientId = $booking->contact_detail?->hub_id;
            if (empty($clientId)) {
                return;
            }

            $providerName = $booking->trading_name?->trading_name?->name
                ?: ($booking->vender?->profile?->company_name
                    ?: ($booking->vender?->name ?: 'Service Provider'));
            $truId = $booking->vender?->profile?->tru_id ?: null;

            $rawStatus = strtoupper(trim((string) $booking->status));
            $isJobStatus = in_array($rawStatus, [
                'IN_PROGRESS',
                'IN PROGRESS',
                'WORKING',
                'STARTED',
                'FINAL_CHECKS',
                'FINAL CHECKS',
                'READY_FOR_COLLECTION',
                'READY FOR COLLECTION',
                'COMPLETED',
                'DELIVERED',
                'COLLECTED',
            ], true);
            $isJob = ((int) ($booking->job_id ?? 0) > 0) || $isJobStatus;

            if ($isJob) {
                $mapping = match ($rawStatus) {
                    'IN_PROGRESS', 'IN PROGRESS', 'WORKING', 'STARTED' => [
                        'title' => 'Job update',
                        'statusWord' => 'In progress',
                        'statusColor' => '#111827',
                        'message' => "{$providerName} has changed your job status to In progress.",
                    ],
                    'FINAL_CHECKS', 'FINAL CHECKS' => [
                        'title' => 'Job update',
                        'statusWord' => 'Final checks',
                        'statusColor' => '#1E40AF',
                        'message' => "{$providerName} has changed your job status to Final checks.",
                    ],
                    'READY_FOR_COLLECTION', 'READY FOR COLLECTION', 'COMPLETED' => [
                        'title' => 'Job update',
                        'statusWord' => 'Ready for collection',
                        'statusColor' => '#1E40AF',
                        'message' => "{$providerName} has changed your job status to Ready for collection.",
                    ],
                    'DELIVERED', 'COLLECTED' => [
                        'title' => 'Job update',
                        'statusWord' => 'Collected',
                        'statusColor' => '#111827',
                        'message' => "{$providerName} has changed your job status to Collected.",
                    ],
                    'CANCELLED', 'CANCELED' => [
                        'title' => 'Job update',
                        'statusWord' => 'Cancelled',
                        'statusColor' => '#DC2626',
                        'message' => "Your job with {$providerName} has been Cancelled.",
                    ],
                    default => [
                        'title' => 'Job update',
                        'statusWord' => ucwords(strtolower(str_replace('_', ' ', $rawStatus))) ?: 'Updated',
                        'statusColor' => '#111827',
                        'message' => "{$providerName} has changed your job status to " . (ucwords(strtolower(str_replace('_', ' ', $rawStatus))) ?: 'Updated') . '.',
                    ],
                };
                $mapping['type'] = 'job_update';
                $mapping['entityType'] = 'job';
                $mapping['route'] = 'ViewJob';
                $mapping['params'] = ['jobId' => (string) $booking->id];
            } else {
                $mapping = match ($rawStatus) {
                    'BOOKING_REQUEST', 'PENDING' => [
                        'title' => 'Booking request submitted',
                        'statusWord' => 'Pending',
                        'statusColor' => '#D97706',
                        'message' => "Your booking request with {$providerName} is Pending.",
                    ],
                    'CONFIRMED', 'BOOKED', 'APPROVED' => [
                        'title' => 'Booking update',
                        'statusWord' => 'Booked',
                        'statusColor' => '#1E40AF',
                        'message' => "{$providerName} has changed your booking status to Booked.",
                    ],
                    'ARRIVED' => [
                        'title' => 'Booking update',
                        'statusWord' => 'Arrived',
                        'statusColor' => '#111827',
                        'message' => "{$providerName} has changed your booking status to Arrived.",
                    ],
                    'CANCELLED', 'CANCELED' => [
                        'title' => 'Booking update',
                        'statusWord' => 'Cancelled',
                        'statusColor' => '#DC2626',
                        'message' => "Your booking with {$providerName} has been Cancelled.",
                    ],
                    'DECLINED', 'REJECTED' => [
                        'title' => 'Booking update',
                        'statusWord' => 'Declined',
                        'statusColor' => '#DC2626',
                        'message' => "{$providerName} has changed your booking status to Declined.",
                    ],
                    default => [
                        'title' => 'Booking update',
                        'statusWord' => ucwords(strtolower(str_replace('_', ' ', $rawStatus))) ?: 'Updated',
                        'statusColor' => '#111827',
                        'message' => "{$providerName} has updated your booking status to " . (ucwords(strtolower(str_replace('_', ' ', $rawStatus))) ?: 'Updated') . '.',
                    ],
                };
                $mapping['type'] = 'booking_update';
                $mapping['entityType'] = 'booking';
                $mapping['route'] = 'ViewBooking';
                $mapping['params'] = ['bookingId' => (string) $booking->id];
            }

            ClientNotification::create([
                'client_id' => $clientId,
                'title' => $mapping['title'],
                'message' => $mapping['message'],
                'type' => $mapping['type'],
                'status_word' => $mapping['statusWord'],
                'status_color' => $mapping['statusColor'],
                'related_entity_id' => (string) $booking->id,
                'related_entity_type' => $mapping['entityType'],
                'provider_name' => $providerName,
                'tru_id' => $truId,
                'action_label' => 'View',
                'action_route' => $mapping['route'],
                'action_params' => $mapping['params'],
            ]);
        } catch (\Throwable $e) {
            \Log::warning('Failed to create booking ClientNotification: ' . $e->getMessage());
        }
    }

    public static function notifyForQuotation(Quotation $quotation): void
    {
        try {
            $quotation->loadMissing([
                'contact_detail',
                'trading_unit.trading_name',
                'vender.profile',
            ]);

            $clientId = $quotation->contact_detail?->hub_id ?? $quotation->client_id;
            if (empty($clientId)) {
                return;
            }

            $providerName = $quotation->trading_unit?->trading_name?->name
                ?: ($quotation->vender?->profile?->company_name
                    ?: ($quotation->vender?->name ?: 'Service Provider'));
            $truId = $quotation->vender?->profile?->tru_id ?: null;

            $rawStatus = strtoupper(trim((string) $quotation->status));
            $statusWord = ucwords(strtolower(str_replace('_', ' ', $rawStatus))) ?: 'Updated';
            $isBlue = in_array($rawStatus, ['APPROVED', 'ACCEPTED', 'SENT', 'PENDING'], true);

            ClientNotification::create([
                'client_id' => $clientId,
                'title' => 'Quote update',
                'message' => "{$providerName} has changed your quote status to {$statusWord}.",
                'type' => 'quote_update',
                'status_word' => $statusWord,
                'status_color' => $isBlue ? '#1E40AF' : '#111827',
                'related_entity_id' => (string) $quotation->id,
                'related_entity_type' => 'quote',
                'provider_name' => $providerName,
                'tru_id' => $truId,
                'action_label' => 'View',
                'action_route' => 'ViewQuote',
                'action_params' => ['quoteId' => (string) $quotation->id],
            ]);
        } catch (\Throwable $e) {
            \Log::warning('Failed to create quotation ClientNotification: ' . $e->getMessage());
        }
    }

    public static function notifyForInvoice(Invoice $invoice, bool $isCreated = false): void
    {
        try {
            $invoice->loadMissing([
                'contact',
                'booking.contact_detail',
                'booking.trading_name.trading_name',
                'booking.vender.profile',
            ]);

            $clientId = $invoice->contact?->hub_id ?? $invoice->booking?->contact_detail?->hub_id;
            if (empty($clientId)) {
                return;
            }

            $providerName = $invoice->booking?->trading_name?->trading_name?->name
                ?: ($invoice->booking?->vender?->profile?->company_name
                    ?: ($invoice->booking?->vender?->name ?: 'Service Provider'));
            $truId = $invoice->booking?->vender?->profile?->tru_id ?: null;

            $rawStatus = strtoupper(trim((string) $invoice->status));
            $statusWord = match ($rawStatus) {
                'PAID' => 'Paid',
                'OVERDUE' => 'Overdue',
                default => 'Due',
            };
            $statusColor = match ($rawStatus) {
                'OVERDUE' => '#DC2626',
                'PAID' => '#111827',
                default => '#1E40AF',
            };

            $invoiceNo = $invoice->invoice_no ?: ('INV-' . $invoice->id);
            $title = $isCreated ? 'New invoice' : 'Invoice update';
            $message = $isCreated
                ? "{$providerName} has created invoice {$invoiceNo} ({$statusWord})."
                : "{$providerName} has changed your invoice status to {$statusWord}.";

            ClientNotification::create([
                'client_id' => $clientId,
                'title' => $title,
                'message' => $message,
                'type' => 'invoice_update',
                'status_word' => $statusWord,
                'status_color' => $statusColor,
                'related_entity_id' => (string) $invoice->id,
                'related_entity_type' => 'invoice',
                'provider_name' => $providerName,
                'tru_id' => $truId,
                'action_label' => 'View',
                'action_route' => 'ViewInvoice',
                'action_params' => ['invoiceId' => (string) $invoice->id],
            ]);
        } catch (\Throwable $e) {
            \Log::warning('Failed to create invoice ClientNotification: ' . $e->getMessage());
        }
    }
}
