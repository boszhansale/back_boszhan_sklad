<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Formula
 *
 * @property int $id
 * @property int $product_id
 * @property int $material_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Formula newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Formula newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Formula query()
 * @method static \Illuminate\Database\Eloquent\Builder|Formula whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formula whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formula whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formula whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formula whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formula whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Formula extends Model
{
    use HasFactory;

    protected $fillable =[
        'product_id',
        'count',
        'material_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(FormulaProduct::class);
    }
}
