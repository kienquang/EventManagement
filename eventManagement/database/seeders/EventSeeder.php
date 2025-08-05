<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Event::create([
            'title' => 'Laravel Workshop 2025',
            'date' => '2025-09-01',
            'location' => 'Hà Nội',
            'limit' => 100,
        ]);

        Event::create([
            'title' => 'Vue.js Conference',
            'date' => '2025-09-15',
            'location' => 'TP.HCM',
            'limit' => 200,
        ]);

        Event::create([
            'title' => 'AI & Laravel Hackathon',
            'date' => '2025-10-01',
            'location' => 'Đà Nẵng',
            'limit' => 150,
        ]);

        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) {
            Event::create([
                'title' => 'Sự kiện ' . $i,
                'date' => $faker->dateTimeBetween('+1 week', '+2 months')->format('Y-m-d'),
                'location' => $faker->city,
                'limit' => $faker->numberBetween(50, 200),
            ]);
        }
    }
}
