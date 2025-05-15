<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['email', 'sms', 'in_app'];

        foreach ($types as $type) {
            NotificationType::firstOrCreate(['name' => $type]);
        }
    }
}
