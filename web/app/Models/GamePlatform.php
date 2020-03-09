<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GamePlatform
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Game[] $games
 * @property-read int|null $games_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GamePlatform newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GamePlatform newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GamePlatform query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GamePlatform whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GamePlatform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GamePlatform whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GamePlatform whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GamePlatform whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GamePlatform extends Model
{
    public function games(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Game::class)->orderBy('name');
    }
}
