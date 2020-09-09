<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereActive($value)
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDiscount($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product wherePurchasePrice($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $package_size
 * @method static Builder|Product wherePackageSize($value)
 * @property bool $pant
 * @method static Builder|Product wherePant($value)
 * @property int $adjustment
 * @property-read mixed $category_name
 * @property-read mixed $combobox_barcodes
 * @method static Builder|Product whereAdjustment($value)
 */
class Product extends Model
{
    protected $appends = ['category_name', 'combobox_barcodes'];

    public function getCategoryNameAttribute() {
        return $this->category->name;
    }

    public function getComboboxBarcodesAttribute() {
        $ret = [];
        foreach ($this->barcodes as $barcode) {
            if ($barcode->variant_name) {
                $ret[] = "{$barcode->variant_name}={$barcode->barcode}";
            } else {
                $ret[] = (string) $barcode->barcode;
            }
        }
        return $ret;
    }

    public function getPurchasePriceAttribute($value) {
        return $value/100;
    }

    public function setPurchasePriceAttribute($value) {
        $this->attributes['purchase_price'] = $value*100;
    }

    /**
     * @return HasMany
     */
    public function barcodes(): HasMany
    {
        return $this->hasMany(Barcode::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
