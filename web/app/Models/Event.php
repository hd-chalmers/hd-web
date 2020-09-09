<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Event
 *
 * @property int                             $id
 * @property string                          $title
 * @property string|null                     $description
 * @property string|null                     $location
 * @property string|null                     $poster
 * @property bool                            $show_on_frontpage
 * @property string|null                     $google_event_id
 * @property string|null                     $facebook_event_link
 * @property Carbon                          $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDate( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereFacebookEventLink( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereGoogleEventId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereLocation( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event wherePoster( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereShowOnFrontpage( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereTitle( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt( $value )
 * @mixin \Eloquent
 * @property mixed $time
 */
class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'poster',
        'show_on_frontpage',
        'google_event_id',
        'facebook_event_link',
        'date',
        'time',
    ];

    protected $dates = ['date'];

    protected $appends = ['time'];

    public function getDateAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getTimeAttribute() {
        return Carbon::parse($this->getAttributes()['date'])->format('H:i');
    }

    public function setTimeAttribute($value) {
        $this->attributes['date'] = Carbon::parse($this->getAttributes()['date'])->setTimeFromTimeString($value);
    }

    public function setDateAttribute($value) {
        $this->attributes['date'] = Carbon::parse($this->getAttributes()['date'] ?? Carbon::now())->setDateFrom(Carbon::parse($value));
    }
}
