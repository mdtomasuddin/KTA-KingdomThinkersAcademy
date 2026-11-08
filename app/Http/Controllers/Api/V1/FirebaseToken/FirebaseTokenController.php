<?php

namespace App\Http\Controllers\Api\V1\FirebaseToken;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\FirebaseToken\FirebaseTokenResource;
use App\Models\FirebaseToken;
use App\Traits\Api\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FirebaseTokenController extends Controller
{
    use ApiResponse;

    /**
     * Store a Firebase token for the authenticated user.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token'     => 'required|string',
            'device_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400);
        }

        $user = auth('api')->user();

        if (! $user) {
            return $this->error('Unauthorized. Please login again.', 401);
        }

        try {
            // Delete existing token for this user and device
            FirebaseToken::where('user_id', $user->id)->where('device_id', $request->device_id)->delete();

            $firebaseToken = FirebaseToken::create([
                'user_id'   => $user->id,
                'token'     => $request->token,
                'device_id' => $request->device_id,
            ]);

            return $this->success(new FirebaseTokenResource($firebaseToken), 'Token saved successfully.', 201);
        } catch (Exception $e) {
            Log::error('FirebaseTokenController::store: ' . $e->getMessage());

            return $this->error('Failed to save token.', 500);
        }
    }

    /**
     * Get a Firebase token by device ID for the authenticated user.
     */
    public function getToken(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400);
        }

        try {
            $user = auth('api')->user();

            if (! $user) {
                return $this->error('Unauthorized. Please login again.', 401);
            }

            $firebaseToken = FirebaseToken::where('user_id', $user->id)->where('device_id', $request->device_id)->first();

            if (! $firebaseToken) {
                return $this->error('No records found.', 404);
            }

            return $this->success(new FirebaseTokenResource($firebaseToken), 'Token fetched successfully.', 200);
        } catch (Exception $e) {
            return $this->error('Failed to fetch token.', 500);
        }
    }

    /**
     * Delete a Firebase token by device ID for the authenticated user.
     */
    public function deleteToken(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400);
        }

        try {
            $user = auth('api')->user();
            if (! $user) {
                return $this->error('Unauthorized. Please login again.', 401);
            }

            $deleted = FirebaseToken::where('user_id', $user->id)->where('device_id', $request->device_id)->delete();
            if (! $deleted) {
                return $this->error('No records found.', 404);
            }

            return $this->success([], 'Token deleted successfully.', 200);
        } catch (Exception $e) {
            Log::error('FirebaseTokenController::deleteToken: ' . $e->getMessage());

            return $this->error('Failed to delete token.', 500);
        }
    }
}

