<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Plan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123123'),
                'email_verified_at' => now(),
            ]
        );

        // Create default plans if not exist
        if (Plan::count() === 0) {
            Plan::create([
                'name' => 'Basic Plan',
                'description' => 'Perfect for small businesses and startups',
                'price' => 29.99,
                'duration' => 'monthly',
                'features' => [
                    'Up to 100 users',
                    'Basic analytics',
                    'Email support',
                    '5GB storage'
                ],
                'is_active' => true,
            ]);

            Plan::create([
                'name' => 'Pro Plan',
                'description' => 'Advanced features for growing businesses',
                'price' => 79.99,
                'duration' => 'monthly',
                'features' => [
                    'Up to 1000 users',
                    'Advanced analytics',
                    'Priority support',
                    '25GB storage',
                    'Custom integrations',
                    'Team collaboration'
                ],
                'is_active' => true,
            ]);

            Plan::create([
                'name' => 'Enterprise Plan',
                'description' => 'Full-featured solution for large organizations',
                'price' => 199.99,
                'duration' => 'monthly',
                'features' => [
                    'Unlimited users',
                    'Enterprise analytics',
                    '24/7 phone support',
                    '100GB storage',
                    'Custom integrations',
                    'Advanced security',
                    'Dedicated account manager',
                    'SLA guarantee'
                ],
                'is_active' => true,
            ]);
        }
    }
}
