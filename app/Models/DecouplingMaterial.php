<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DecouplingMaterial
 *
 * @property int $id
 * @property int $material_id
 * @property int $box_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingMaterial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingMaterial query()
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingMaterial whereBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingMaterial whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingMaterial whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DecouplingMaterial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DecouplingMaterial extends Model
{
    use HasFactory;
}
