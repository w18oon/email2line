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
            'email' => 'admin@email2line.com',
            'password' => Hash::make('Admin'),
        ]);

        factory(App\Group::class, 10)->create()->each(function($group) {
            $group->mappings()->saveMany(
                factory(App\Mapping::class, rand(1,8))->make()
            )->each(function($mapping) {
                $mapping->logs()->saveMany(
                    factory(App\Log::class, rand(1,30))->make()
                );
            });
        });
    }
}
