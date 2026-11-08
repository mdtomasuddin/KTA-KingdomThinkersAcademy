<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ProfileRequest;
use App\Http\Resources\Api\V1\Auth\ProfileResource;
use App\Models\User;
use App\Traits\Api\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // API Response formatting trait
    use ApiResponse;

    /**
     * Display the authenticated user's profile details.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            /** @var User $user */
            $user = Auth::user();

            if (! $user) {
                return $this->unauthorized('Unauthenticated.');
            }

            return $this->success(
                new ProfileResource($user),
                'Profile retrieved successfully.',
                200
            );
        } catch (Exception $e) {
            return $this->error('Failed to retrieve profile: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update the authenticated user's profile information.
     */
    public function update(ProfileRequest $request): JsonResponse
    {
        try {
            /** @var User $user */
            $user = Auth::user();

            if (! $user) {
                return $this->unauthorized('Unauthenticated.');
            }

            $validatedData = $request->validated();

            // Handle avatar image upload
            if ($request->hasFile('avatar')) {
                Helper::deleteFile($user->getRawOriginal('avatar'));
                $validatedData['avatar'] = Helper::uploadFile($request->file('avatar'), 'avatars');
            }

            // Handle cover banner image upload
            if ($request->hasFile('cover')) {
                Helper::deleteFile($user->getRawOriginal('cover'));
                $validatedData['cover'] = Helper::uploadFile($request->file('cover'), 'covers');
            }

            // Handle digital signature image upload
            if ($request->hasFile('signature_image')) {
                Helper::deleteFile($user->getRawOriginal('signature_image'));
                $validatedData['signature_image'] = Helper::uploadFile($request->file('signature_image'), 'signatures');
            }

            $user->update($validatedData);

            return $this->success(
                new ProfileResource($user->fresh()),
                'Profile updated successfully.',
                200
            );
        } catch (Exception $e) {
            return $this->error('Failed to update profile: ' . $e->getMessage(), 500);
        }
    }
}
