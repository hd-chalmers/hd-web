<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Barcode
 *
 * @property int                             $id
 * @property int                             $product_id
 * @property string                          $barcode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product        $product
 * @method static Builder|Barcode newModelQuery()
 * @method static Builder|Barcode newQuery()
 * @method static Builder|Barcode query()
 * @method static Builder|Barcode whereBarcode( $value )
 * @method static Builder|Barcode whereCreatedAt( $value )
 * @method static Builder|Barcode whereId( $value )
 * @method static Builder|Barcode whereProductId( $value )
 * @method static Builder|Barcode whereUpdatedAt( $value )
 * @mixin \Eloquent
 * @property string|null                     $variant_name
 * @method static Builder|Barcode whereVariantName( $value )
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
