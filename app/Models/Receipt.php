<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'id',
        'status',
        'bank',
        'user_id',
        'warehouse_id',
        'total_price',
        'description',
        'nds',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(ReceiptProduct::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
