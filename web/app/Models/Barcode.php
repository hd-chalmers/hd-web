<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Barcode
 *
 * @property int $id
 * @property int $product_id
 * @property string $barcode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Barcode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Barcode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Barcode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Barcode whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Barcode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Barcode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Barcode whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Barcode whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $variant_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Barcode whereVariantName($value)
 */
class Barcode extends Model
{
    protected $fillable = ['barcode', 'variant_name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
