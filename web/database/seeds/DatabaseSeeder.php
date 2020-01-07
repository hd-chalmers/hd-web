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
        factory(App\Models\Event::class, 10)->create();
        $year = new \App\Models\ActiveYear();
        $year->year = \Carbon\Carbon::now();
        $year->description = 'This is the description field of the active year table';
        $year->save();
        $this->call(CommitteeMemberSeeder::class);
    }
}
