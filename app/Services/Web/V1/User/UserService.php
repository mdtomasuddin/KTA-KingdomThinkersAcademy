<?php

namespace App\Services\Web\V1\User;

use App\Helpers\Helper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserService
{
    /**
     * Create a new user.
     */
    public function create(array $data): Model | Builder
    {
        $firstName = $data['first_name'];
        $lastName  = $data['last_name'] ?? null;
        $fullName  = trim($firstName . ' ' . ($lastName ?? ''));

        // Auto-generate username from full name
        $userData = [
            'first_name'           => $firstName,
            'last_name'            => $lastName,
            'employee_id'          => $data['employee_id'] ?? null,
            'username'             => $this->generateUsername($fullName),
            'email'                => $data['email'],
            'phone'                => $data['phone'] ?? null,
            'designation'          => $data['designation'] ?? null,
            'gender'               => $data['gender'] ?? null,
            'password'             => bcrypt($data['password']),
            'role'                 => $data['role'] ?? 'student',
            'status'               => $data['status'] ?? 'active',
            'bio'                  => $data['bio'] ?? null,
            'address'              => $data['address'] ?? ($data['location'] ?? null),
            'birthday'             => $data['birthday'] ?? null,
            'terms_and_conditions' => true,
        ];

        // Handle avatar
        if (isset($data['avatar']) && $data['avatar']) {
            $userData['avatar'] = Helper::uploadFile($data['avatar'], 'avatars');
        }

        // Handle cover photo
        if (isset($data['cover']) && $data['cover']) {
            $userData['cover'] = Helper::uploadFile($data['cover'], 'covers');
        }

        $user = User::query()->create($userData);

        return $user;
    }

    /**
     * Update an existing user.
     */
    public function update(int $id, array $data): Model | Collection | Builder | array | null
    {
        $user = User::query()->findOrFail($id);

        $firstName = $data['first_name'] ?? $user->first_name;
        $lastName  = array_key_exists('last_name', $data) ? $data['last_name'] : $user->last_name;
        $fullName  = trim(($firstName ?? '') . ' ' . ($lastName ?? ''));

        $userData = [
            'first_name'  => $firstName,
            'last_name'   => $lastName,
            'employee_id' => array_key_exists('employee_id', $data) ? $data['employee_id'] : $user->employee_id,
            'email'       => $data['email'],
            'phone'       => $data['phone'] ?? $user->phone,
            'designation' => array_key_exists('designation', $data) ? $data['designation'] : $user->designation,
            'gender'      => array_key_exists('gender', $data) ? $data['gender'] : $user->gender,
            'role'        => $data['role'] ?? $user->role,
            'status'      => $data['status'] ?? $user->status,
            'bio'         => $data['bio'] ?? $user->bio,
            'address'     => $data['address'] ?? ($data['location'] ?? $user->address),
            'birthday'    => $data['birthday'] ?? ($user->birthday ? Carbon::parse($user->birthday)->format('Y-m-d') : null),
        ];

        // Only update username if full_name changed
        if ($fullName !== $user->full_name && ! empty($fullName)) {
            $userData['username'] = $this->generateUsername($fullName);
        }

        // Update password if provided
        if (! empty($data['password'])) {
            $userData['password'] = bcrypt($data['password']);
        }

        // Handle avatar
        if (isset($data['avatar']) && $data['avatar']) {
            if ($user->avatar) {
                Helper::deleteFile($user->avatar);
            }
            $userData['avatar'] = Helper::uploadFile($data['avatar'], 'avatars');
        }

        // Handle cover photo
        if (isset($data['cover']) && $data['cover']) {
            if ($user->cover) {
                Helper::deleteFile($user->cover);
            }
            $userData['cover'] = Helper::uploadFile($data['cover'], 'covers');
        }

        $user->update($userData);

        return $user->fresh();
    }

    /**
     * Generate a unique username from name.
     */
    private function generateUsername(string $name, string $lastName = ''): string
    {
        $base     = Str::slug(trim($name . ' ' . $lastName)) ?: 'user';
        $username = $base;
        $counter  = 1;

        while (User::query()->where('username', $username)->exists()) {
            $username = $base . '-' . $counter;
            $counter++;
        }

        return $username;
    }
}
