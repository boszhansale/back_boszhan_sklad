<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ReceiptProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'deleted_at',
        'created_at',
        'updated_at',
        'id',
        'comment',
        'all_price',
        'count',
        'price',
        'old_price',
        'storage_life',
        'receipt_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function receipt(): BelongsTo
    {
        return $this->belongsTo(Receipt::class);
    }
}
