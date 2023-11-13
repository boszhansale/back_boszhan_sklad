<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\BoxProduct
 *
 * @property int $id
 * @property int $box_id
 * @property int $product_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|BoxProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxProduct whereBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxProduct whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BoxProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'box_id',
        'product_id',
        'count',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
