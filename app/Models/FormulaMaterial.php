<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FormulaMaterial
 *
 * @property int $id
 * @property int $material_id
 * @property float $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaMaterial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaMaterial query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaMaterial whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaMaterial whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormulaMaterial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FormulaMaterial extends Model
{
    use HasFactory;
}
