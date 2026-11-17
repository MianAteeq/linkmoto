<?php

namespace Modules\ClientHub\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientNotification extends Model
{
    use SoftDeletes;

    protected $table = 'client_notifications';

    protected $guarded = [];

    protected $casts = [
        'read_at' => 'datetime',
        'action_params' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function toApiArray(): array
    {
        return [
            'id' => (string) $this->id,
            'title' => (string) $this->title,
            'message' => (string) $this->message,
            'type' => (string) ($this->type ?: 'general'),
            'createdAt' => $this->created_at ? $this->created_at->toISOString() : now()->toISOString(),
            'isRead' => !is_null($this->read_at),
            'statusWord' => $this->status_word,
            'statusColor' => $this->status_color,
            'relatedEntityId' => $this->related_entity_id ? (string) $this->related_entity_id : null,
            'relatedEntityType' => $this->related_entity_type,
            'providerName' => $this->provider_name,
            'truId' => $this->tru_id,
            'actionLabel' => $this->action_label,
            'actionRoute' => $this->action_route,
            'actionParams' => $this->action_params,
        ];
    }
}

