<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Coupling
 *
 * @property int $id
 * @property int $user_id
 * @property int $formula_id
 * @property int $product_id
 * @property int $material_id
 * @property int $box_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling whereBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling whereFormulaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupling whereUserId($value)
 * @mixin \Eloquent
 */
class Coupling extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'count',
        'material_id',
        'user_id',
        'box_id',
        'formula_id'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(CouplingProduct::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function formula(): BelongsTo
    {
        return $this->belongsTo(Formula::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
