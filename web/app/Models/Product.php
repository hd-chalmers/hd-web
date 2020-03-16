<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int                                                                 $id
 * @property int                                                                 $category_id
 * @property string                                                              $name
 * @property int                                                                 $purchase_price
 * @property int                                                                 $discount
 * @property int                                                                 $price
 * @property bool                                                                $active
 * @property \Illuminate\Support\Carbon|null                                     $created_at
 * @property \Illuminate\Support\Carbon|null                                     $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Barcode[] $barcodes
 * @property-read int|null                                                       $barcodes_count
 * @property-read \App\Models\Category                                           $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePurchasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $package_size
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePackageSize($value)
 * @property bool $pant
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePant($value)
 */
class Product extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barcodes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Barcode::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function updatePrice()
    {
        $this->price = ceil(($this->purchase_price/100 - ($this->discount/100 ?? 0)) / $this->package_size * 1.25 + ($this->pant ? 100 : 0));
    }
}
