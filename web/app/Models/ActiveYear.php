<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActiveYear
 *
 * @property int                             $id
 * @property string                          $year
 * @property string|null                     $description
 * @property string|null                     $group_photo
 * @property string|null                     $front_image
 * @property string|null                     $christmas_image
 * @property string|null                     $background_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear whereBackgroundImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear whereChristmasImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear whereFrontImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear whereGroupPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActiveYear whereYear($value)
 * @mixin \Eloquent
 */
class ActiveYear extends Model
{
    public function committee_members()
    {
        return $this->hasMany(CommitteeMember::class);
    }
}
