<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notifications = Notification::all();
        User::factory()->hasAttached($notifications)->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
    }
}
