<?php

namespace Modules\ClientHub\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Modules\Vender\Entities\Vehicle;

class VehicleDocument extends Model
{
    protected $guarded = [];
    protected $hidden = ['path', 'client_id'];
    protected $casts = ['expiry_date' => 'date', 'size_bytes' => 'integer'];

    protected static function booted(): void
    {
        static::deleted(function (self $document) {
            Storage::disk('vehicle_documents')->delete($document->path);
        });
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function toApiArray(): array
    {
        return [
            'id' => (string) $this->id,
            'label' => $this->label,
            'title' => $this->label,
            'description' => $this->description,
            'expiryDate' => $this->expiry_date?->format('Y-m-d'),
            'status' => $this->status,
            'fileName' => $this->file_name,
            'mimeType' => $this->mime_type,
            'type' => $this->mime_type === 'application/pdf' ? 'PDF' : 'Image',
            'sizeBytes' => $this->size_bytes,
            'size' => $this->size_bytes >= 1048576
                ? round($this->size_bytes / 1048576, 1) . ' MB'
                : max(1, (int) ceil($this->size_bytes / 1024)) . ' KB',
            'date' => $this->created_at->format('d M Y'),
        ];
    }
}
