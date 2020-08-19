<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Game
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $bgg_id
 * @property int $game_platform_id
 * @property int|null $min_players
 * @property int|null $max_players
 * @property string|null $published_year
 * @property int|null $min_playtime
 * @property int|null $max_playtime
 * @property int|null $expansion_to
 * @property int|null $game_owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Game[] $expansions
 * @property-read int|null $expansions_count
 * @property-read \App\Models\GameOwner|null $game_owner
 * @property-read \App\Models\GamePlatform $game_platform
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereBggId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereExpansionTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereGameOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereGamePlatformId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereMaxPlayers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereMaxPlaytime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereMinPlayers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereMinPlaytime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game wherePublishedYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $num_players
 * @property-read mixed $platform
 * @property-read mixed $playtime
 */
class Game extends Model
{

    protected $appends = [
        'platform',
        'num_players',
        'playtime'
    ];

    public function getPlatformAttribute ()
    {
        return ucfirst($this->game_platform->name);
    }

    public function getNumPlayersAttribute ()
    {
        return $this->min_players === $this->max_players ? $this->min_players : $this->min_players . ' - ' . $this->max_players;
    }

    public function getPlaytimeAttribute ()
    {
        return $this->min_playtime === $this->max_playtime ? $this->min_playtime : $this->min_playtime . ' - ' . $this->max_playtime.' min';
    }

    public function game_platform ()
    {
        return $this->belongsTo(GamePlatform::class);
    }

    public function expansion_to ()
    {
        return $this->belongsTo(__CLASS__, 'expansion_to');
    }

    public function expansions ()
    {
        return $this->hasMany(__CLASS__, 'expansion_to');
    }

    public function game_owner() {
        return $this->belongsTo(GameOwner::class);
    }
}
