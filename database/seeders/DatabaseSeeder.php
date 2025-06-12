<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Governorate;
use App\Models\City;
use App\Models\Location;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        // User::factory(10)->create();
//
//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        // إنشاء 10 محافظات
        for ($i = 1; $i <= 10; $i++) {
            $governorate = Governorate::create([
                'name' => "Governorate $i"
            ]);

            // لكل محافظة، إنشاء 10 مدن
            for ($j = 1; $j <= 10; $j++) {
                $city = City::create([
                    'name' => "City $j - Gov $i",
                    'governorate_id' => $governorate->id,
                ]);

                // لكل مدينة، إنشاء 10 مواقع
                for ($k = 1; $k <= 10; $k++) {
                    Location::create([
                        'description' => "Location $k in City $j - Gov $i",
                        'city_id' => $city->id,
                    ]);
                }
            }
        }
    }
}

