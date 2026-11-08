<?php

namespace App\Http\Controllers\Api\V1\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Notification\NotificationResource;
use App\Traits\Api\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    // ! Trait For API Response
    use ApiResponse;

    /**
     * Get authenticated user notifications.
     */
    public function getNotification(Request $request): JsonResponse
    {
        try {
            // Get Authenticated User
            $user = Auth::guard('api')->user() ?: Auth::user();

            if (! $user) {
                return $this->unauthorized('Unauthenticated.');
            }

            $perPage  = (int) $request->query('per_page', 25);
            $category = $request->query('category');
            $status   = $request->query('status'); // 'read', 'unread'

            // Database Query
            $query = $user->notifications()->latest();

            if (! empty($category)) {
                $query->where('category', $category);
            }

            if ($status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($status === 'read') {
                $query->whereNotNull('read_at');
            }

            $notifications = $query->paginate($perPage);

            return $this->success(NotificationResource::collection($notifications), 'Data retrieved successfully.', 200, true);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(Request $request): JsonResponse
    {
        try {
            //Validation
            $validator = Validator::make($request->all(), [
                'notification_id' => 'required|string|exists:notifications,id',
            ]);

            if ($validator->fails()) {
                return $this->unprocessableEntity($validator->errors());
            }

            //Get Authenticated User
            $user = Auth::guard('api')->user() ?: Auth::user();

            if (! $user) {
                return $this->unauthorized('Unauthenticated.');
            }

            //Database Query
            $notification = $user->notifications()->where('id', $request->notification_id)->first();

            //Check exists
            if (! $notification) {
                return $this->notFound('Notification not found.');
            }

            $notification->markAsRead();
            return $this->success([], 'Notification marked as read successfully.', 200);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Mark all notifications as read.
     */
    public function AllNotificationMarkAsRead(Request $request): JsonResponse
    {
        try {
            // Get Authenticated User
            $user = Auth::guard('api')->user() ?: Auth::user();

            if (! $user) {
                return $this->unauthorized('Unauthenticated.');
            }

            $user->unreadNotifications->markAsRead();

            return $this->success([], 'All notifications marked as read successfully.', 200);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }


    /**
     * Delete a notification.
     */
    public function deleteNotification(string $id): JsonResponse
    {
        try {
            // Get Authenticated User
            $user = Auth::guard('api')->user() ?: Auth::user();

            if (! $user) {
                return $this->unauthorized('Unauthenticated.');
            }

            // Database Query
            $notification = $user->notifications()->find($id);

            // Check exists
            if (! $notification) {
                return $this->notFound('Notification not found.');
            }

            $notification->delete();

            return $this->success([], 'Notification deleted successfully.', 200);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete multiple selected notifications in bulk.
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'ids'   => 'required|array|min:1',
                'ids.*' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->unprocessableEntity($validator->errors());
            }

            // Get Authenticated User
            $user = Auth::guard('api')->user() ?: Auth::user();

            if (! $user) {
                return $this->unauthorized('Unauthenticated.');
            }

            // Delete selected notifications
            $deletedCount = $user->notifications()->whereIn('id', $request->ids)->delete();

            return $this->success([], "{$deletedCount} notification(s) deleted successfully.", 200);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete all notifications for the authenticated user.
     */
    public function deleteAll(): JsonResponse
    {
        try {
            // Get Authenticated User
            $user = Auth::guard('api')->user() ?: Auth::user();

            if (! $user) {
                return $this->unauthorized('Unauthenticated.');
            }

            // Delete all notifications
            $user->notifications()->delete();

            return $this->success([], 'All notifications deleted successfully.', 200);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }
}
