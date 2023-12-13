<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Moving
 *
 * @property int $id
 * @property int $status
 * @property int|null $coming_id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property int|null $from_box_id
 * @property int $to_box_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Coming|null $coming
 * @property-read \App\Models\Box|null $fromBox
 * @property-read \App\Models\User $fromUser
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MovingProduct> $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Box $toBox
 * @property-read \App\Models\User $toUser
 * @method static \Illuminate\Database\Eloquent\Builder|Moving newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Moving newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Moving query()
 * @method static \Illuminate\Database\Eloquent\Builder|Moving whereComingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moving whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moving whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moving whereFromBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moving whereFromUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moving whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moving whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moving whereToBoxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moving whereToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moving whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Moving extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'status',
        'from_user_id',
        'to_user_id',
        'count',
        'from_box_id',
        'to_box_id',
        'accept_at',
        'reject_at',
        'order_id',
    ];

    protected $casts = [
        'accept_at' => 'datetime:Y-m-d H:00',
        'reject_at' => 'datetime:Y-m-d H:00',
        'created_at' => 'datetime:Y-m-d H:00',
    ];

    public function coming(): BelongsTo
    {
        return $this->belongsTo(Coming::class);
    }
    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(MovingProduct::class);
    }

    public function fromBox(): BelongsTo
    {
        return $this->belongsTo(Box::class);
    }
    public function toBox(): BelongsTo
    {
        return $this->belongsTo(Box::class);
    }
}
