<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CouplingMaterial
 *
 * @property int $id
 * @property int $material_id
 * @property int $box_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingMaterial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingMaterial query()
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingMaterial whereBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingMaterial whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingMaterial whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouplingMaterial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CouplingMaterial extends Model
{
    use HasFactory;
}
