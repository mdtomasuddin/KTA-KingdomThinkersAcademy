<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::updateOrCreate(
            ['id' => 1],
            [
                'title'               => 'Dashboard',
                'system_name'         => 'Dashboard',
                'email'               => 'info@example.com',
                'phone'               => '(818) 292-0969',
                'address'             => 'Los Angeles, CA',
                'copyright_text'      => '© 2026 Dashboard. All rights reserved.',
                'description'         => 'Professional Residential & Commercial Roofing Services in Los Angeles.',
                'logo'                => null,
                'favicon'             => null,
                'timezone'            => 'America/Los_Angeles',
                'maintenance_mode'    => false,
                'maintenance_message' => null,
            ]
        );
    }
}
