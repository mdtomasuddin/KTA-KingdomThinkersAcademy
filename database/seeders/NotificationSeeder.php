<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = 2;

        $notifications = [
            // 1. Reflection (Unread)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000001',
                'type'            => 'App\\Notifications\\DailyReflectionReminder',
                'category'        => 'reflection',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'Time for your daily reflection',
                    'message'           => 'Take 60 seconds to record your voice reflection today and keep your streak alive.',
                    'destination_route' => '/reflections/create',
                    'action_label'      => 'Record Now',
                ],
                'read_at'         => null,
                'created_at'      => now()->subMinutes(30),
                'updated_at'      => now()->subMinutes(30),
            ],

            // 2. Membership / Streak (Unread)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000002',
                'type'            => 'App\\Notifications\\StreakAchievedNotification',
                'category'        => 'membership',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => '7-Day Streak Master! 🔥',
                    'message'           => 'Amazing consistency! You have recorded voice reflections for 7 consecutive days.',
                    'destination_route' => '/profile',
                    'action_label'      => 'View Badge',
                ],
                'read_at'         => null,
                'created_at'      => now()->subHours(2),
                'updated_at'      => now()->subHours(2),
            ],

            // 3. Reflection Prompt (Read)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000003',
                'type'            => 'App\\Notifications\\NewPromptNotification',
                'category'        => 'reflection',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'New Daily Prompt Available',
                    'message'           => 'Explore today\'s guided prompt: "What small win brought you peace today?"',
                    'destination_route' => '/prompts/1',
                    'action_label'      => 'View Prompt',
                ],
                'read_at'         => now()->subHours(5),
                'created_at'      => now()->subHours(6),
                'updated_at'      => now()->subHours(5),
            ],

            // 4. Billing (Unread)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000004',
                'type'            => 'App\\Notifications\\PlanRenewalReminderNotification',
                'category'        => 'billing',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'Upcoming Plan Renewal',
                    'message'           => 'Your Monthly Sanctuary subscription is scheduled to renew in 3 days ($9.99/mo).',
                    'destination_route' => '/settings/subscription',
                    'action_label'      => 'Manage Plan',
                ],
                'read_at'         => null,
                'created_at'      => now()->subHours(10),
                'updated_at'      => now()->subHours(10),
            ],

            // 5. Security (Unread)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000005',
                'type'            => 'App\\Notifications\\SecurityAlertNotification',
                'category'        => 'security',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'New Device Signed In',
                    'message'           => 'Your account was logged in from iPhone 15 Pro (iOS 18) in San Francisco, CA.',
                    'destination_route' => '/settings/security',
                    'action_label'      => 'Review Security',
                ],
                'read_at'         => null,
                'created_at'      => now()->subDay(),
                'updated_at'      => now()->subDay(),
            ],

            // 6. Service Update (Read)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000006',
                'type'            => 'App\\Notifications\\ServiceUpdateNotification',
                'category'        => 'service',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'HD Voice Audio Enhancement',
                    'message'           => 'We have upgraded audio filtering for crystal clear voice notes and faster playback.',
                    'destination_route' => '/reflections',
                    'action_label'      => 'Learn More',
                ],
                'read_at'         => now()->subDay(),
                'created_at'      => now()->subDays(2),
                'updated_at'      => now()->subDay(),
            ],

            // 7. Legal Policy (Read)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000007',
                'type'            => 'App\\Notifications\\LegalPolicyUpdateNotification',
                'category'        => 'legal',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'Terms of Service & Privacy Update',
                    'message'           => 'We have updated our Terms & Conditions and Privacy Policy for enhanced data protection.',
                    'destination_route' => '/contents/terms-conditions',
                    'action_label'      => 'Read Terms',
                ],
                'read_at'         => now()->subDays(2),
                'created_at'      => now()->subDays(3),
                'updated_at'      => now()->subDays(2),
            ],

            // 8. Reflection Category (Read)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000008',
                'type'            => 'App\\Notifications\\CategorySpotlightNotification',
                'category'        => 'reflection',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'Category Spotlight: Mindful Spending',
                    'message'           => 'Explore new prompts designed to reflect on intentional choices and mindful habits.',
                    'destination_route' => '/categories/1',
                    'action_label'      => 'Explore Category',
                ],
                'read_at'         => now()->subDays(3),
                'created_at'      => now()->subDays(4),
                'updated_at'      => now()->subDays(3),
            ],

            // 9. Membership Milestone (Read)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000009',
                'type'            => 'App\\Notifications\\MilestoneAchievedNotification',
                'category'        => 'membership',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => '14 Reflections Recorded! 🎙️',
                    'message'           => 'You have recorded 14 voice reflections in VOXELÉ. Keep building your mindful archive.',
                    'destination_route' => '/profile',
                    'action_label'      => 'View Stats',
                ],
                'read_at'         => now()->subDays(4),
                'created_at'      => now()->subDays(5),
                'updated_at'      => now()->subDays(4),
            ],

            // 10. Billing Receipt (Read)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000010',
                'type'            => 'App\\Notifications\\PaymentReceiptNotification',
                'category'        => 'billing',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'Payment Receipt: Monthly Sanctuary',
                    'message'           => 'Your payment of $9.99 was processed successfully. Thank you for your support.',
                    'destination_route' => '/settings/billing',
                    'action_label'      => 'View Invoice',
                ],
                'read_at'         => now()->subDays(6),
                'created_at'      => now()->subDays(6),
                'updated_at'      => now()->subDays(6),
            ],

            // 11. Reflection Reminder (Unread)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000011',
                'type'            => 'App\\Notifications\\EveningReflectionReminder',
                'category'        => 'reflection',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'Evening Wind-Down Moment',
                    'message'           => 'End your day with a calm voice recording before bed. What are you grateful for tonight?',
                    'destination_route' => '/reflections/create',
                    'action_label'      => 'Record Reflection',
                ],
                'read_at'         => null,
                'created_at'      => now()->subDays(7),
                'updated_at'      => now()->subDays(7),
            ],

            // 12. Security Password Update (Read)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000012',
                'type'            => 'App\\Notifications\\PasswordChangedNotification',
                'category'        => 'security',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'Password Changed Successfully',
                    'message'           => 'Your VOXELÉ account password was recently changed. If this wasn\'t you, please secure your account.',
                    'destination_route' => '/settings/security',
                    'action_label'      => 'Security Center',
                ],
                'read_at'         => now()->subDays(8),
                'created_at'      => now()->subDays(8),
                'updated_at'      => now()->subDays(8),
            ],

            // 13. Service Notice (Unread)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000013',
                'type'            => 'App\\Notifications\\SystemMaintenanceNotification',
                'category'        => 'service',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'Scheduled Maintenance Notice',
                    'message'           => 'VOXELÉ cloud services will undergo a brief 15-minute maintenance on Sunday at 02:00 UTC.',
                    'destination_route' => '/settings',
                    'action_label'      => 'Details',
                ],
                'read_at'         => null,
                'created_at'      => now()->subDays(10),
                'updated_at'      => now()->subDays(10),
            ],

            // 14. Membership Welcome (Read)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000014',
                'type'            => 'App\\Notifications\\WelcomeNotification',
                'category'        => 'membership',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'Welcome to VOXELÉ ✨',
                    'message'           => 'Welcome to your safe sanctuary for mindful voice journaling and daily reflection.',
                    'destination_route' => '/onboarding',
                    'action_label'      => 'Get Started',
                ],
                'read_at'         => now()->subDays(14),
                'created_at'      => now()->subDays(14),
                'updated_at'      => now()->subDays(14),
            ],

            // 15. Reflection Favorite (Read)
            [
                'id'              => '9f8e7d6c-5b4a-4321-8765-000000000015',
                'type'            => 'App\\Notifications\\ReflectionFavoritedNotification',
                'category'        => 'reflection',
                'notifiable_type' => User::class,
                'notifiable_id'   => $userId,
                'data'            => [
                    'title'             => 'Reflection Added to Favorites',
                    'message'           => 'You saved your voice reflection to your private favorites library.',
                    'destination_route' => '/favorites',
                    'action_label'      => 'View Favorites',
                ],
                'read_at'         => now()->subDays(15),
                'created_at'      => now()->subDays(15),
                'updated_at'      => now()->subDays(15),
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::updateOrCreate(
                ['id' => $notification['id']],
                $notification
            );
        }
    }
}
