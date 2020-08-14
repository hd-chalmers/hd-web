<?php

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
        $user = new \App\Models\User();
        $user->email = 'test@example.com';
        $user->password = \Illuminate\Support\Facades\Hash::make('password');
        $user->name = 'test';
        $user->remember_token = '';
        $user->save();
        factory(App\Models\Event::class, 10)->create();
        $year = new \App\Models\ActiveYear();
        $year->year = '2016-05-01';
        $year->description = 'Det är vi som är HD';
        $year->save();
        $this->call(CommitteeMemberSeeder::class);
        $this->call(StrecklistaSeeder::class);
        $this->call(GameSeeder::class);
        //factory(\App\Models\DoorStatus::class, 20)->create();
    }
}
