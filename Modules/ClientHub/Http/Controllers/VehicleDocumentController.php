<?php

namespace Modules\ClientHub\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Modules\ClientHub\Entities\Client;
use Modules\ClientHub\Entities\VehicleDocument;
use Modules\Vender\Entities\Vehicle;
use Throwable;

class VehicleDocumentController extends Controller
{
    private function ownedVehicle(Request $request, $id): Vehicle
    {
        abort_unless($request->user() instanceof Client, 403);
        return Vehicle::where('vender_id', $request->user()->id)
            ->where(function ($query) {
                $query->where('type', 'Client')->orWhereNull('type');
            })->findOrFail($id);
    }

    private function ownedDocument(Request $request, $vehicleId, $documentId): VehicleDocument
    {
        $vehicle = $this->ownedVehicle($request, $vehicleId);
        return $vehicle->documents()->where('client_id', $request->user()->id)->findOrFail($documentId);
    }

    private function metadataRules(): array
    {
        return [
            'label' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:5000'],
            'expiryDate' => ['nullable', 'date_format:Y-m-d'],
            'status' => ['nullable', 'string', 'max:80'],
        ];
    }

    public function index(Request $request, $vehicle)
    {
        $owned = $this->ownedVehicle($request, $vehicle);
        return response()->json([
            'status' => true,
            'documents' => $owned->documents()->where('client_id', $request->user()->id)
                ->latest()->get()->map->toApiArray()->values(),
        ]);
    }

    public function store(Request $request, $vehicle)
    {
        $owned = $this->ownedVehicle($request, $vehicle);
        $data = $request->validate($this->metadataRules() + [
            'file' => ['required', 'file', 'max:20480',
                'mimetypes:application/pdf,image/jpeg,image/png,image/webp,image/gif,image/heic,image/heif,image/avif'],
        ]);
        $file = $request->file('file');
        $path = $file->store("{$request->user()->id}/{$owned->id}", 'vehicle_documents');

        try {
            $document = $owned->documents()->create([
                'client_id' => $request->user()->id,
                'label' => $data['label'],
                'description' => $data['description'] ?? null,
                'expiry_date' => $data['expiryDate'] ?? null,
                'status' => $data['status'] ?? null,
                'file_name' => Str::limit(basename(str_replace('\\', '/', $file->getClientOriginalName())), 255, ''),
                'mime_type' => $file->getMimeType(),
                'size_bytes' => $file->getSize(),
                'path' => $path,
            ]);
        } catch (Throwable $error) {
            Storage::disk('vehicle_documents')->delete($path);
            throw $error;
        }

        return response()->json(['status' => true, 'document' => $document->toApiArray()], 201);
    }

    public function update(Request $request, $vehicle, $document)
    {
        $owned = $this->ownedDocument($request, $vehicle, $document);
        $data = $request->validate($this->metadataRules());
        $owned->update([
            'label' => $data['label'],
            'description' => $data['description'] ?? null,
            'expiry_date' => $data['expiryDate'] ?? null,
            'status' => $data['status'] ?? null,
        ]);
        return response()->json(['status' => true, 'document' => $owned->toApiArray()]);
    }

    public function destroy(Request $request, $vehicle, $document)
    {
        $this->ownedDocument($request, $vehicle, $document)->delete();
        return response()->json(['status' => true]);
    }

    public function access(Request $request, $vehicle, $document)
    {
        $owned = $this->ownedDocument($request, $vehicle, $document);
        abort_unless(Storage::disk('vehicle_documents')->exists($owned->path), 404);
        return response()->json([
            'status' => true,
            'url' => URL::temporarySignedRoute('client.vehicle-documents.file', now()->addMinutes(5), [
                'vehicle' => $owned->vehicle_id, 'document' => $owned->id,
            ]),
        ]);
    }

    // The browser cannot send the app's bearer token; only short-lived signed links can reach this route.
    public function file($vehicle, $document)
    {
        $owned = VehicleDocument::where('vehicle_id', $vehicle)->findOrFail($document);
        abort_unless(Client::whereKey($owned->client_id)->exists(), 404);
        abort_unless($owned->vehicle && $owned->vehicle->vender_id == $owned->client_id
            && in_array($owned->vehicle->type, ['Client', null], true), 404);
        $disk = Storage::disk('vehicle_documents');
        abort_unless($disk->exists($owned->path), 404);

        return response()->file($disk->path($owned->path), [
            'Content-Type' => $owned->mime_type,
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ])->setContentDisposition('inline', $owned->file_name,
            'vehicle-document.' . pathinfo($owned->path, PATHINFO_EXTENSION))->setPrivate();
    }
}
