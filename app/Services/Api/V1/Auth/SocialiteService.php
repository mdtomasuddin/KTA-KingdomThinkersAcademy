<?php

namespace App\Services\Api\V1\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialiteService
{
    /**
     * Handle socialite authentication (Google, Facebook, Apple).
     *
     * @return array<string, mixed>
     *
     * @throws UnauthorizedHttpException|Exception
     */
    public function loginWithSocialite(string $provider, string $socialToken, string $role = 'student'): array
    {
        if (! in_array($provider, ['google', 'facebook', 'apple'])) {
            throw new UnauthorizedHttpException('', 'Provider not supported.');
        }

        // Retrieve user details from provider token
        try {
            $socialUser = Socialite::driver($provider)->stateless()->userFromToken($socialToken);
        } catch (Exception $e) {
            throw new UnauthorizedHttpException('', 'Invalid token or provider.');
        }

        if (! $socialUser || ! $socialUser->getEmail()) {
            throw new UnauthorizedHttpException('', 'Invalid social user data or missing email.');
        }

        $email            = strtolower($socialUser->getEmail());
        $providerIdColumn = $provider . '_id';
        $socialId         = $socialUser->getId();

        return DB::transaction(function () use ($socialUser, $email, $providerIdColumn, $socialId, $role) {
            // Locate existing user account including soft-deleted entries
            $existingUser = User::withTrashed()->where(function ($query) use ($providerIdColumn, $socialId, $email) {
                if ($socialId) {
                    $query->where($providerIdColumn, $socialId);
                }
                $query->orWhere('email', $email);
            })->first();

            if ($existingUser && $existingUser->trashed()) {
                throw new UnauthorizedHttpException('', 'Your account has been deleted. Please contact support.');
            }

            $isNewUser = false;

            if ($existingUser) {
                // Update profile metadata for existing user
                $user    = $existingUser;
                $updates = [];

                if ($socialId && empty($user->{$providerIdColumn})) {
                    $updates[$providerIdColumn] = $socialId;
                }

                if (empty($user->avatar) && $socialUser->getAvatar()) {
                    $updates['avatar'] = $socialUser->getAvatar();
                }

                if (! empty($updates)) {
                    $user->update($updates);
                }
            } else {
                // Register new user
                $fullName = trim($socialUser->getName() ?? $socialUser->getNickname() ?? 'User');
                $parts    = explode(' ', $fullName, 2);
                $userRole = in_array($role, ['parent', 'student', 'teacher', 'contracted_teacher', 'coop', 'micro_school', 'admin', 'super_admin']) ? $role : 'student';

                $user = User::create([
                    'first_name'           => $parts[0] ?? $fullName,
                    'last_name'            => $parts[1] ?? null,
                    'email'                => $email,
                    'password'             => bcrypt(Str::random(16)),
                    'email_verified_at'    => now(),
                    'terms_and_conditions' => true,
                    'role'                 => $userRole,
                    'avatar'               => $socialUser->getAvatar(),
                    $providerIdColumn      => $socialId,
                    'status'               => 'active',
                ]);

                $isNewUser = true;
            }

            if ($user->status !== 'active') {
                throw new UnauthorizedHttpException('', 'Your account is ' . $user->status . '. Please contact support.');
            }

            // Generate JWT authentication token
            $token = JWTAuth::fromUser($user);

            if (! $token) {
                throw new Exception('Could not generate authentication token.');
            }

            return [
                'access_token'         => $token,
                'token_type'           => 'bearer',
                'expires_in'           => JWTAuth::factory()->getTTL() * 60,
                'user'                 => $user->fresh(),
                'was_recently_created' => $isNewUser,
            ];
        });
    }
}
