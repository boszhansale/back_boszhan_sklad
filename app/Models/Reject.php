<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


//Списание
/**
 * App\Models\Reject
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $product_id
 * @property int|null $material_id
 * @property float $count
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Material|null $material
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Reject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reject query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reject whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reject whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reject whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reject whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reject whereUserId($value)
 * @mixin \Eloquent
 */
class Reject extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'material_id',
        'count'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }


}
