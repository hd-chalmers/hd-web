<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(['Brädspel' => 'boardgame', 'Playstation X' => 'videogame', 'XBOX Q' => 'videogame', 'Nintendo Switch' => 'videogame', 'PC' => 'videogame', 'VR' => 'videogame'] as $platform => $type) {
            $gp = new \App\Models\GamePlatform();
            $gp->name = $platform;
            $gp->type = $type;
            $gp->save();
        }
        foreach (\App\Models\GamePlatform::all() as $platform) {
            $platform->games()->saveMany(factory(\App\Models\Game::class, 10)->make());
        }
    }
}
