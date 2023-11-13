<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MovingProduct
 *
 * @property int $id
 * @property int $moving_id
 * @property int $product_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|MovingProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovingProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovingProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|MovingProduct whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovingProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovingProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovingProduct whereMovingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovingProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovingProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MovingProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'moving_id',
        'product_id',
        'count',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
