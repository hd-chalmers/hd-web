<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PurchaseHistory
 *
 * @property int $id
 * @property int $account_id
 * @property int $sum
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account $account
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchaseHistoryProduct[] $purchase_history_products
 * @property-read int|null $purchase_history_products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PurchaseHistory extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_history_products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchaseHistoryProduct::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
