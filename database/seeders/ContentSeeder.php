<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Data = [
            // 1. Terms & Conditions
            [
                'title'      => 'Terms & Conditions',
                'slug'       => 'terms-conditions',
                'content'    => "<h3>1. Introduction</h3><p>Welcome to our platform. By accessing or using our website and services, you agree to comply with and be bound by these Terms & Conditions.</p><h3>2. User Accounts</h3><p>You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p><h3>3. Acceptable Use</h3><p>You agree not to use the service for any unlawful purpose or in any way that interrupts, damages, or impairs the functionality of the service.</p><h3>4. Intellectual Property</h3><p>All content, trademarks, and data on this website are the property of the platform or its licensors and are protected by applicable intellectual property laws.</p><h3>5. Termination</h3><p>We reserve the right to suspend or terminate your access to the service at our sole discretion, without notice, for conduct that we believe violates these terms.</p><h3>6. Contact Us</h3><p>If you have any questions regarding these Terms & Conditions, please contact our support team.</p>",
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 2. Privacy Policy
            [
                'title'      => 'Privacy Policy',
                'slug'       => 'privacy-policy',
                'content'    => "<h3>1. Information We Collect</h3><p>We collect information you provide directly to us when registering an account, updating your profile, or communicating with us.</p><h3>2. How We Use Your Information</h3><p>We use the information we collect to provide, maintain, and improve our services, process transactions, and communicate updates with you.</p><h3>3. Data Protection</h3><p>We implement appropriate technical and organizational measures to safeguard your personal data against unauthorized access, alteration, or loss.</p><h3>4. Sharing of Information</h3><p>We do not sell, rent, or trade your personal information with third parties for marketing purposes.</p><h3>5. Your Rights</h3><p>You have the right to access, update, or request the deletion of your personal data at any time through your account settings or by contacting us.</p>",
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 3. Cookie Policy
            [
                'title'      => 'Cookie Policy',
                'slug'       => 'cookie-policy',
                'content'    => "<h3>1. What Are Cookies</h3><p>Cookies are small data files stored on your device that help us remember your preferences and enhance your user experience.</p><h3>2. How We Use Cookies</h3><p>We use essential cookies for user authentication, security, and session management, as well as analytics cookies to improve platform performance.</p><h3>3. Managing Cookies</h3><p>You can adjust your browser settings to refuse cookies or alert you when cookies are being sent.</p>",
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 4. About Us
            [
                'title'      => 'About Us',
                'slug'       => 'about-us',
                'content'    => "<h3>Our Mission</h3><p>We are dedicated to providing reliable, modern, and user-centric solutions designed to help you succeed.</p><h3>What We Do</h3><p>Our comprehensive platform provides intuitive tools, seamless management experiences, and dependable support for our community.</p><h3>Get In Touch</h3><p>For inquiries, support, or partnership opportunities, reach out to our team anytime.</p>",
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert or update the data
        foreach ($Data as $dataStore) {
            Content::updateOrCreate(
                ['slug' => $dataStore['slug']],
                $dataStore
            );
        }
    }
}

