<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Coming
 *
 * @property int $id
 * @property int $user_id
 * @property int $box_id
 * @property int $product_id
 * @property int $material_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Coming newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coming newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coming query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coming whereBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coming whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coming whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coming whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coming whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coming whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coming whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coming whereUserId($value)
 * @property-read \App\Models\Box $box
 * @property-read \App\Models\Material $material
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class Coming extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'product_id',
        'count',
        'box_id',
        'user_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function box(): BelongsTo
    {
        return $this->belongsTo(Box::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
