<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DoorStatus
 *
 * @property int $id
 * @property string $updated
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DoorStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DoorStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DoorStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DoorStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DoorStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DoorStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DoorStatus whereUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DoorStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DoorStatus extends Model
{
    protected $casts = [
        'status' => 'bool'
        ];

    protected $dates = [
        'updated', 'updated_at', 'created_at'
    ];

    protected $appends = [
        'updated', 'duration', 'duration_str'
    ];

    protected $hidden = [
        'updated_at', 'created_at', 'id'
    ];

    public function getUpdatedAttribute() {
        return $this->created_at->toDateTimeString();
    }

    public function getDurationAttribute() {
        return $this->created_at->diffInSeconds(Carbon::now());
    }

    public function getDurationStrAttribute() {
        return CarbonInterval::seconds($this->getDurationAttribute())->cascade()->forHumans();
    }

}
