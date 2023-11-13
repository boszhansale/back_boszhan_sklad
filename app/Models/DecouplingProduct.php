<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DecouplingProduct
 *
 * @property int $id
 * @property int $product_id
 * @property int $box_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingProduct whereBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingProduct whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DecouplingProduct extends Model
{
    use HasFactory;
}
