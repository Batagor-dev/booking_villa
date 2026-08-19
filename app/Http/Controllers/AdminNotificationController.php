<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    /**
     * Display a full listing/history of notifications.
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        $status = $request->query('status'); // 'unread', 'read', 'all'

        $query = AdminNotification::with('booking.property')->latest();

        if ($type && in_array($type, ['order_created', 'order_cancelled', 'order_confirmed'])) {
            $query->where('type', $type);
        }

        if ($status === 'unread') {
            $query->unread();
        } elseif ($status === 'read') {
            $query->whereNotNull('read_at');
        }

        $notifications = $query->paginate(15)->withQueryString();

        $unreadCount = AdminNotification::unread()->count();
        $totalCount = AdminNotification::count();
        $orderCreatedCount = AdminNotification::where('type', 'order_created')->count();
        $orderCancelledCount = AdminNotification::where('type', 'order_cancelled')->count();

        return view('notification.index', compact(
            'notifications',
            'unreadCount',
            'totalCount',
            'orderCreatedCount',
            'orderCancelledCount',
            'type',
            'status'
        ));
    }

    /**
     * Polling feed endpoint for live sidebar/header badge and toast alerts.
     */
    public function feed(Request $request)
    {
        $unreadCount = AdminNotification::unread()->count();
        $latest = AdminNotification::latest()->limit(8)->get()->map(function ($item) {
            $data = $item->data ?? [];
            return [
                'id'            => $item->id,
                'uuid'          => $item->uuid,
                'type'          => $item->type,
                'title'         => $item->title,
                'message'       => $item->message,
                'is_unread'     => $item->isUnread(),
                'created_at_human' => $item->created_at->diffForHumans(),
                'created_at_time'  => $item->created_at->format('H:i, d M Y'),
                'booking_code'  => $data['booking_code'] ?? null,
                'guest_name'    => $data['guest_name'] ?? null,
                'property_name' => $data['property_name'] ?? null,
                'total_price'   => isset($data['total_price']) ? 'Rp ' . number_format($data['total_price'], 0, ',', '.') : null,
                'check_in'      => $data['check_in'] ?? null,
                'check_out'     => $data['check_out'] ?? null,
                'read_url'      => route('admin.notifications.read', $item->uuid),
                'status'        => $data['status'] ?? null,
            ];
        });

        // Check if there's any new notification since last_polled_id
        $lastPolledId = $request->query('last_id');
        $newItems = [];
        if ($lastPolledId) {
            $newItems = AdminNotification::where('id', '>', (int)$lastPolledId)
                ->latest()
                ->get()
                ->map(function ($item) {
                    $data = $item->data ?? [];
                    return [
                        'id'            => $item->id,
                        'uuid'          => $item->uuid,
                        'type'          => $item->type,
                        'title'         => $item->title,
                        'message'       => $item->message,
                        'booking_code'  => $data['booking_code'] ?? null,
                        'guest_name'    => $data['guest_name'] ?? null,
                        'property_name' => $data['property_name'] ?? null,
                        'total_price'   => isset($data['total_price']) ? 'Rp ' . number_format($data['total_price'], 0, ',', '.') : null,
                        'read_url'      => route('admin.notifications.read', $item->uuid),
                    ];
                });
        }

        $latestId = AdminNotification::max('id') ?? 0;

        return response()->json([
            'unread_count' => $unreadCount,
            'latest_id'    => $latestId,
            'latest'       => $latest,
            'new_items'    => $newItems,
        ]);
    }

    /**
     * Mark a single notification as read and redirect to the target order.
     */
    public function read(AdminNotification $notification)
    {
        $notification->markAsRead();

        $url = $notification->data['url'] ?? null;
        if (!$url && $notification->booking) {
            $url = route('bookings.show', $notification->booking->uuid);
        }

        if ($url) {
            return redirect($url);
        }

        return redirect()->route('admin.notifications.index');
    }

    /**
     * Mark all unread notifications as read.
     */
    public function markAllRead(Request $request)
    {
        AdminNotification::unread()->update(['read_at' => now()]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi telah ditandai sebagai dibaca.',
            ]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Delete a notification.
     */
    public function destroy(AdminNotification $notification)
    {
        $notification->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}
