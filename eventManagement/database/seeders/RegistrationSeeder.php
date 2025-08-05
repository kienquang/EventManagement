<?php

namespace Database\Seeders;

use App\Models\Registration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Event;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Registration::create([
            'user_id' => 2,
            'event_id' => 1,
            'status' => 'confirmed',
            'checked_in_at' => null,
        ]);

        Registration::create([
            'user_id' => 2,
            'event_id' => 2,
            'status' => 'pending',
            'checked_in_at' => null,
        ]);

        $faker = Faker::create();

        $users = User::where('role', 'user')->pluck('id')->toArray();
        $events = Event::pluck('id')->toArray();

        foreach ($events as $eventId) {
            // Mỗi event có 5-10 người tham gia
            $userSample = $faker->randomElements($users, rand(5, 10));

            foreach ($userSample as $userId) {
                Registration::create([
                    'user_id' => $userId,
                    'event_id' => $eventId,
                    'status' => $faker->randomElement(['pending', 'confirmed']),
                    'checked_in_at' => $faker->boolean(40) ? now() : null,
                ]);
            }
        }
    }
}
