<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is Kingdom Thinkers Academy (KTA)?',
                'answer'   => 'Kingdom Thinkers Academy is an educational platform providing holistic, values-based learning, connecting parents, students, teachers, co-ops, and micro schools.',
            ],
            [
                'question' => 'How can I contact academy support?',
                'answer'   => 'You can contact our support team via support@kingdomthinkersacademy.org or submit a ticket from your account settings.',
            ],
            [
                'question' => 'How do I change or reset my password?',
                'answer'   => 'Go to Profile Settings, click on Change Password, enter your current password, and choose a new secure password.',
            ],
            [
                'question' => 'How can parents track student progress?',
                'answer'   => 'Parents can log in to their dashboard to view curriculum details, enrolled classes, and direct feedback from teachers.',
            ],
            [
                'question' => 'How can teachers manage courses and student evaluations?',
                'answer'   => 'Teachers and contracted teachers can access the academy portal to view student rosters, schedules, and lesson activities.',
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::updateOrCreate(
                [
                    'question' => $faq['question'],
                ],
                [
                    'answer' => $faq['answer'],
                ]
            );
        }
    }
}
