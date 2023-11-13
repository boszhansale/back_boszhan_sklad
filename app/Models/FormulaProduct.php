<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FormulaProduct
 *
 * @property int $id
 * @property int $product_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaProduct whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FormulaProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'count',
        'product_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
