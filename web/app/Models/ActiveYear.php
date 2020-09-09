<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\ActiveYear
 *
 * @property int         $id
 * @property string      $year
 * @property string|null $description
 * @property string|null $group_photo
 * @property string|null $front_image
 * @property string|null $christmas_image
 * @property string|null $background_image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ActiveYear newModelQuery()
 * @method static Builder|ActiveYear newQuery()
 * @method static Builder|ActiveYear query()
 * @method static Builder|ActiveYear whereBackgroundImage($value)
 * @method static Builder|ActiveYear whereChristmasImage($value)
 * @method static Builder|ActiveYear whereCreatedAt($value)
 * @method static Builder|ActiveYear whereDescription($value)
 * @method static Builder|ActiveYear whereFrontImage($value)
 * @method static Builder|ActiveYear whereGroupPhoto($value)
 * @method static Builder|ActiveYear whereId($value)
 * @method static Builder|ActiveYear whereUpdatedAt($value)
 * @method static Builder|ActiveYear whereYear($value)
 * @mixin Eloquent
 * @property-read Collection|CommitteeMember[] $committee_members
 * @property-read int|null                     $committee_members_count
 * @property-read mixed $displayed_year
 */
class ActiveYear extends Model
{

    protected $dates = ['year'];

    protected $appends = ['displayed_year'];

    public function committee_members()
    {
        return $this->hasMany(CommitteeMember::class)->orderBy('id');
    }

    public function getDisplayedYearAttribute() {
        return $this->year . '/' . ($this->year+1);
    }

    public function getYearAttribute($value) {
        return Carbon::parse($value)->year;
    }

    static function getLatest($cache = true) {
        Cache::forget('active_year');
        if ($cache) {
            return Cache::remember('active_year', 30 * 24 * 60 * 60, static function () {
                return ActiveYear::latest()->with(['committee_members'])->first();
            });
        }

        return ActiveYear::latest()->with(['committee_members'])->first();
    }
}
