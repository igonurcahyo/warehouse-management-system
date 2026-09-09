<?php

namespace App\Models;

use Database\Factories\InventoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['product_id', 'warehouse_id', 'quantity'])]
class Inventory extends Model
{
    protected $table = 'inventory';

    /** @use HasFactory<InventoryFactory> */
    use HasFactory;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /** @param Builder<Inventory> $query */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereColumn('quantity', '<', 'products.min_stock')
            ->join('products', 'inventory.product_id', '=', 'products.id');
    }
}
