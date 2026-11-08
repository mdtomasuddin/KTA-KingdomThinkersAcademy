<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            // 1. Super Admin Role
            [
                'first_name'           => 'Super',
                'last_name'            => 'Admin',
                'username'             => 'super_admin_1',
                'employee_id'          => 'KTA-SA-01',
                'email'                => 'admin@gmail.com',
                'avatar'               => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80',
                'designation'          => 'Chief Administrator',
                'gender'               => 'male',
                'phone'                => '+15550100001',
                'email_verified_at'    => now(),
                'password'             => bcrypt('12345678'),
                'role'                 => 'super_admin',
                'status'               => 'active',
                'terms_and_conditions' => true,
                'remember_token'       => Str::random(10),
            ],

            // 2. Admin Role
            [
                'first_name'           => 'System',
                'last_name'            => 'Admin',
                'username'             => 'admin_user',
                'employee_id'          => 'KTA-ADM-01',
                'email'                => 'academy_admin@gmail.com',
                'avatar'               => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80',
                'designation'          => 'Academy Operations Manager',
                'gender'               => 'female',
                'phone'                => '+15550100002',
                'email_verified_at'    => now(),
                'password'             => bcrypt('12345678'),
                'role'                 => 'admin',
                'status'               => 'active',
                'terms_and_conditions' => true,
                'remember_token'       => Str::random(10),
            ],

            // 3. Teacher Role
            [
                'first_name'           => 'Eleanor',
                'last_name'            => 'Vance',
                'username'             => 'eleanor_teacher',
                'employee_id'          => 'KTA-TCH-01',
                'email'                => 'teacher@gmail.com',
                'avatar'               => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=600&q=80',
                'designation'          => 'Senior Mathematics Teacher',
                'gender'               => 'female',
                'phone'                => '+15550100003',
                'email_verified_at'    => now(),
                'password'             => bcrypt('12345678'),
                'role'                 => 'teacher',
                'status'               => 'active',
                'terms_and_conditions' => true,
                'remember_token'       => Str::random(10),
            ],

            // 4. Contracted Teacher Role
            [
                'first_name'           => 'Marcus',
                'last_name'            => 'Sterling',
                'username'             => 'marcus_contractor',
                'employee_id'          => 'KTA-CT-01',
                'email'                => 'contracted_teacher@gmail.com',
                'avatar'               => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80',
                'designation'          => 'Adjunct Science Instructor',
                'gender'               => 'male',
                'phone'                => '+15550100004',
                'email_verified_at'    => now(),
                'password'             => bcrypt('12345678'),
                'role'                 => 'contracted_teacher',
                'status'               => 'active',
                'terms_and_conditions' => true,
                'remember_token'       => Str::random(10),
            ],

            // 5. Co-op Role
            [
                'first_name'           => 'Grace',
                'last_name'            => 'Community',
                'username'             => 'grace_coop',
                'employee_id'          => 'KTA-COP-01',
                'email'                => 'coop@gmail.com',
                'avatar'               => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=600&q=80',
                'designation'          => 'Co-op Education Coordinator',
                'gender'               => 'female',
                'phone'                => '+15550100005',
                'email_verified_at'    => now(),
                'password'             => bcrypt('12345678'),
                'role'                 => 'coop',
                'status'               => 'active',
                'terms_and_conditions' => true,
                'remember_token'       => Str::random(10),
            ],

            // 6. Micro School Role
            [
                'first_name'           => 'Beacon',
                'last_name'            => 'Academy',
                'username'             => 'beacon_microschool',
                'employee_id'          => 'KTA-MS-01',
                'email'                => 'microschool@gmail.com',
                'avatar'               => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=600&q=80',
                'designation'          => 'Micro School Director',
                'gender'               => 'male',
                'phone'                => '+15550100006',
                'email_verified_at'    => now(),
                'password'             => bcrypt('12345678'),
                'role'                 => 'micro_school',
                'status'               => 'active',
                'terms_and_conditions' => true,
                'remember_token'       => Str::random(10),
            ],

            // 7. Parent Role
            [
                'first_name'           => 'David',
                'last_name'            => 'Miller',
                'username'             => 'david_parent',
                'employee_id'          => 'KTA-PAR-01',
                'email'                => 'parent@gmail.com',
                'avatar'               => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=600&q=80',
                'designation'          => 'Parent Guardian',
                'gender'               => 'male',
                'phone'                => '+15550100007',
                'email_verified_at'    => now(),
                'password'             => bcrypt('12345678'),
                'role'                 => 'parent',
                'status'               => 'active',
                'terms_and_conditions' => true,
                'remember_token'       => Str::random(10),
            ],

            // 8. Student Role
            [
                'first_name'           => 'Samuel',
                'last_name'            => 'Miller',
                'username'             => 'samuel_student',
                'employee_id'          => 'KTA-STU-01',
                'email'                => 'student@gmail.com',
                'avatar'               => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=600&q=80',
                'designation'          => 'Grade 10 Student',
                'gender'               => 'male',
                'phone'                => '+15550100008',
                'email_verified_at'    => now(),
                'password'             => bcrypt('12345678'),
                'role'                 => 'student',
                'status'               => 'active',
                'terms_and_conditions' => true,
                'remember_token'       => Str::random(10),
            ],
        ];

        foreach ($userData as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
