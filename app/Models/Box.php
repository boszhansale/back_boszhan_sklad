<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * App\Models\Box
 *
 * @property int $id
 * @property int $warehouse_id
 * @property int|null $item_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BoxItem|null $item
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BoxItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BoxProduct> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Box newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Box newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Box query()
 * @method static \Illuminate\Database\Eloquent\Builder|Box whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Box whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Box whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Box whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Box whereWarehouseId($value)
 * @mixin \Eloquent
 */
class Box extends Model
{
    use HasFactory;

    protected $fillable  = [
        'warehouse_id',
        'number'
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(BoxProduct::class);
    }
}
