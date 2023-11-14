<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CouplingProduct
 *
 * @property int $id
 * @property int $product_id
 * @property int $box_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingProduct whereBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingProduct whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CouplingProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'box_id',
        'product_id',
        'coupling_id',
        'count',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
