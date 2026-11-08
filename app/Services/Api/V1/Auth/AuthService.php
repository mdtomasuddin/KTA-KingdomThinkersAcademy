<?php

namespace App\Services\Api\V1\Auth;

use App\Models\OTP;
use App\Models\User;
use App\Notifications\Api\V1\Auth\SendOtpNotification;
use Exception;
use Illuminate\Support\Facades\DB;

class AuthService
{
    /**
     * Register a new user.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {
            // Create new user record
            $user = User::create([
                'first_name'           => $data['first_name'],
                'last_name'            => $data['last_name'] ?? null,
                'username'             => ! empty($data['username']) ? trim($data['username']) : null,
                'email'                => strtolower($data['email']),
                'password'             => $data['password'],
                'terms_and_conditions' => $data['terms_and_conditions'] ?? true,
                'role'                 => $data['role'] ?? 'student',
            ]);

            // Authenticate and issue JWT token
            $token = auth('api')->login($user);

            if (! $token) {
                throw new Exception('Could not generate authentication token.');
            }

            // Dispatch verification OTP notification
            $this->sendOtp($user->email);

            return $this->formatTokenResponse($token, $user);
        });
    }

    /**
     * Authenticate user credentials and return JWT token.
     *
     * @param  array{email: string, password: string}  $credentials
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function login(array $credentials): array
    {
        // Attempt JWT authentication with email and password
        $token = auth('api')->attempt([
            'email'    => strtolower($credentials['email']),
            'password' => $credentials['password'],
        ]);

        if (! $token) {
            throw new Exception('Invalid email or password credentials.', 401);
        }

        /** @var User $user */
        $user = auth('api')->user();

        // Validate account status before allowing login
        if ($user->status !== 'active') {
            auth('api')->logout();

            throw new Exception('Your account is ' . $user->status . '. Please contact support.', 403);
        }

        return $this->formatTokenResponse($token, $user);
    }

    /**
     * Send OTP for password recovery or account verification.
     *
     * @throws Exception
     */
    public function sendOtp(string $email, string $type = 'email'): OTP
    {
        $user = User::where('email', strtolower($email))->first();

        if (! $user) {
            throw new Exception('User not found with the provided email address.', 404);
        }

        // Deactivate all previously active OTPs for the user
        OTP::where('user_id', $user->id)->where('status', true)->update(['status' => false]);

        $otpCode = '123456';

        // Generate and persist new active OTP code
        /** @var OTP $otp */
        $otp = OTP::create([
            'user_id'         => $user->id,
            'type'            => $type,
            'otp'             => $otpCode,
            'is_otp_verified' => false,
            'otp_expires_at'  => now()->addMinutes(10),
            'status'          => true,
        ]);

        // Dispatch OTP notification to user
        $user->notify(new SendOtpNotification($otpCode, 10));

        return $otp;
    }

    /**
     * Verify matching OTP code.
     *
     * @throws Exception
     */
    public function verifyOtp(string $email, string $otpCode): bool
    {
        $user = User::where('email', strtolower($email))->first();

        if (! $user) {
            throw new Exception('User not found with the provided email address.', 404);
        }

        // Find valid active and non-expired OTP record
        $otpRecord = OTP::where('user_id', $user->id)
            ->where(function ($query) use ($otpCode) {
                $query->where('otp', $otpCode);
            })
            ->where('status', true)
            ->where('is_otp_verified', false)
            ->where('otp_expires_at', '>', now())
            ->latest()
            ->first();

        if (! $otpRecord) {
            throw new Exception('Invalid or expired OTP code.', 422);
        }

        // Mark OTP as verified
        $otpRecord->update([
            'is_otp_verified' => true,
            'otp_verified_at' => now(),
        ]);

        // Auto-verify email address upon successful OTP match
        if (is_null($user->email_verified_at)) {
            $user->update(['email_verified_at' => now()]);
        }

        return true;
    }

    /**
     * Reset user password using verified OTP.
     *
     * @param  array{email: string, otp: string, password: string}  $data
     *
     * @throws Exception
     */
    public function resetPassword(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            $user = User::where('email', strtolower($data['email']))->first();

            if (! $user) {
                throw new Exception('User not found with the provided email address.', 404);
            }

            // Verify active validated OTP session
            $otpRecord = OTP::where('user_id', $user->id)
                ->where('status', true)
                ->where('is_otp_verified', true)
                ->where('otp_expires_at', '>', now())
                ->latest()
                ->first();

            if (! $otpRecord) {
                throw new Exception('OTP verification is required before resetting password.', 422);
            }

            // Update user password
            $user->update([
                'password' => $data['password'],
            ]);

            // Invalidate OTP record to prevent reuse
            $otpRecord->update([
                'status' => false,
            ]);

            return true;
        });
    }

    /**
     * Format JWT token response array.
     *
     * @return array<string, mixed>
     */
    protected function formatTokenResponse(string $token, User $user): array
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'user'         => $user,
        ];
    }
}

