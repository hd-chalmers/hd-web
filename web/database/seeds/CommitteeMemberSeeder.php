<?php

use Illuminate\Database\Seeder;

class CommitteeMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Mushi',
                'role' => 'ordförande',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'Hell',
                'role' => 'kassör',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar',
                'quote' => 'Sug mitt FINGER!'
            ],
            [
                'name' => 'Tengil',
                'role' => 'prchef',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar',
                'quote' => 'All makt åt tengil'
            ],
            [
                'name' => 'Pålen',
                'role' => 'inköpschef',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'Hatomik',
                'role' => 'spelchef',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'Penta',
                'role' => 'kodchef',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'Mini',
                'role' => 'vice-sysad',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'Null',
                'role' => 'sysad',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'CK',
                'role' => 'matslav',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],

        ];

        foreach ($users as $user) {
            $member = new \App\Models\CommitteeMember($user);
            $member->save();
    }
    }
}
