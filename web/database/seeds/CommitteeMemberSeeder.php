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
                'name' => 'Ordförande',
                'role' => 'ordförande',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'Kassör',
                'role' => 'kassör',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'PRChef',
                'role' => 'prchef',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'inköpschef',
                'role' => 'inköpschef',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'Spelchef',
                'role' => 'spelchef',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'Kodchef',
                'role' => 'kodchef',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'Vice-Sysad',
                'role' => 'vice-sysad',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'Sysad',
                'role' => 'sysad',
                'active_year_id' => 1,
                'description' => 'This is the description field of the Committee_members table',
                'favourite_game' => 'Game',
                'favourite_sugar' => 'Sugar'
            ],
            [
                'name' => 'Ninja',
                'role' => 'ninja',
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
