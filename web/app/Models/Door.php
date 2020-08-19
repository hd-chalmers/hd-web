<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Door
 *
 * @property int $id
 * @property string $updated
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Door newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Door newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Door query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Door whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Door whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Door whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Door whereUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Door whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Door extends Model
{
    protected $fillable = [
        'status',
    ];

    protected $casts = [
        'status' => 'bool',
    ];
}
