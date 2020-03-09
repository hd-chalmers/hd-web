<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PurchaseHistoryProduct
 *
 * @property int $id
 * @property int $purchase_history_id
 * @property int $price
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PurchaseHistory $purhcase_histoy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistoryProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistoryProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistoryProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistoryProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistoryProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistoryProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistoryProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistoryProduct wherePurchaseHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistoryProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PurchaseHistoryProduct extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purhcase_histoy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PurchaseHistory::class);
    }
}
