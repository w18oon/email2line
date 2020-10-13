<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        // DB::table('users')->create([
        //     'name' => 'Admin',
        //     'email' => 'notify2email@gmail.com',
        //     'password' => Hash::make('Admin'),
        // ]);
        User::create([
            'name' => 'Admin',
            'email' => 'notify2email@gmail.com',
            'password' => Hash::make('Admin'),
        ]);
    }
}
