<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Decoupling
 *
 * @property int $id
 * @property int $user_id
 * @property int $formula_id
 * @property int $box_id
 * @property int $product_id
 * @property int $material_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling query()
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling whereBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling whereFormulaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decoupling whereUserId($value)
 * @mixin \Eloquent
 */
class Decoupling extends Model
{
    use HasFactory;
}
