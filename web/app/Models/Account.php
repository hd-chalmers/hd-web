<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Account
 *
 * @property int                                                                         $id
 * @property string                                                                      $uid
 * @property string                                                                      $name
 * @property string                                                                      $password
 * @property int                                                                         $balance
 * @property bool                                                                        $active
 * @property Carbon|null                                                                 $created_at
 * @property Carbon|null                                                                 $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchaseHistory[] $purchase_history
 * @property-read int|null                                                               $purchase_history_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereActive( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereBalance( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account wherePassword( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereUid( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereUpdatedAt( $value )
 * @mixin \Eloquent
 * @property bool $print
 * @property string|null $inactive_since
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereInactiveSince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account wherePrint($value)
 */
class Account extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_history () : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchaseHistory::class);
    }
}
