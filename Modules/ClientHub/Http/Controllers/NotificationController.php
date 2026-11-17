<?php

namespace Modules\ClientHub\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ClientHub\Entities\Client;
use Modules\ClientHub\Entities\ClientNotification;

class NotificationController extends Controller
{
    private function authClient(Request $request): Client
    {
        abort_unless($request->user() instanceof Client, 403);
        return $request->user();
    }

    /**
     * Get paginated notifications for authenticated client.
     */
    public function index(Request $request)
    {
        $client = $this->authClient($request);

        $page = max(1, (int) $request->input('page', 1));
        $limit = max(1, min(100, (int) $request->input('limit', 10)));
        $filter = (string) $request->input('filter', 'all');

        $query = ClientNotification::where('client_id', $client->id);
        if ($filter === 'unread') {
            $query->unread();
        }

        $total = $query->count();
        $unreadCount = ClientNotification::where('client_id', $client->id)->unread()->count();

        $items = $query->orderByDesc('created_at')
            ->orderByDesc('id')
            ->forPage($page, $limit)
            ->get()
            ->map(fn ($n) => $n->toApiArray())
            ->values();

        $hasMore = ($page * $limit) < $total;

        return response()->json([
            'status' => true,
            'items' => $items,
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'hasMore' => $hasMore,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Get count of unread notifications for authenticated client.
     */
    public function unreadCount(Request $request)
    {
        $client = $this->authClient($request);

        $unreadCount = ClientNotification::where('client_id', $client->id)->unread()->count();

        return response()->json([
            'status' => true,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $client = $this->authClient($request);

        $notification = ClientNotification::where('client_id', $client->id)->findOrFail($id);
        if (is_null($notification->read_at)) {
            $notification->update(['read_at' => now()]);
        }

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Notification marked as read',
        ]);
    }

    /**
     * Mark a single notification as unread.
     */
    public function markAsUnread(Request $request, $id)
    {
        $client = $this->authClient($request);

        $notification = ClientNotification::where('client_id', $client->id)->findOrFail($id);
        if (!is_null($notification->read_at)) {
            $notification->update(['read_at' => null]);
        }

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Notification marked as unread',
        ]);
    }

    /**
     * Mark all notifications as read for authenticated client.
     */
    public function markAllAsRead(Request $request)
    {
        $client = $this->authClient($request);

        ClientNotification::where('client_id', $client->id)
            ->unread()
            ->update(['read_at' => now()]);

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'All notifications marked as read',
        ]);
    }

    /**
     * Delete (soft delete) a notification.
     */
    public function destroy(Request $request, $id)
    {
        $client = $this->authClient($request);

        $notification = ClientNotification::where('client_id', $client->id)->findOrFail($id);
        $notification->delete();

        return response()->json([
            'status' => true,
            'success' => true,
            'message' => 'Notification deleted',
        ]);
    }

    /**
     * Store a notification (can be invoked via API or programmatically).
     */
    public function store(Request $request)
    {
        $client = $this->authClient($request);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'nullable|string|max:50',
            'statusWord' => 'nullable|string|max:100',
            'statusColor' => 'nullable|string|max:50',
            'providerName' => 'nullable|string|max:255',
            'truId' => 'nullable|string|max:100',
            'relatedEntityId' => 'nullable|string|max:100',
            'relatedEntityType' => 'nullable|string|max:50',
            'actionLabel' => 'nullable|string|max:100',
            'actionRoute' => 'nullable|string|max:100',
            'actionParams' => 'nullable|array',
        ]);

        $notification = ClientNotification::create([
            'client_id' => $client->id,
            'title' => $data['title'],
            'message' => $data['message'],
            'type' => $data['type'] ?? 'general',
            'status_word' => $data['statusWord'] ?? null,
            'status_color' => $data['statusColor'] ?? null,
            'provider_name' => $data['providerName'] ?? null,
            'tru_id' => $data['truId'] ?? null,
            'related_entity_id' => $data['relatedEntityId'] ?? null,
            'related_entity_type' => $data['relatedEntityType'] ?? null,
            'action_label' => $data['actionLabel'] ?? null,
            'action_route' => $data['actionRoute'] ?? null,
            'action_params' => $data['actionParams'] ?? null,
        ]);

        return response()->json([
            'status' => true,
            'notification' => $notification->toApiArray(),
        ], 201);
    }
}

