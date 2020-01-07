<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CommitteeMember
 *
 * @property int $id
 * @property string $name
 * @property string $role
 * @property int $active_year_id
 * @property string $image_data
 * @property string $image_mime_type
 * @property string $description
 * @property string $favourite_game
 * @property string $favourite_sugar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember whereActiveYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember whereFavouriteGame($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember whereFavouriteSugar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember whereImageData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember whereImageMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommitteeMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CommitteeMember extends Model
{
    protected $fillable = ['name', 'role', 'active_year_id', 'favourite_game', 'favourite_sugar'];

    public function active_year() {
        return $this->belongsTo('active_year');
    }
}
