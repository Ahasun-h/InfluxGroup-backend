<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'item_type',
        'product_id',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'specifications',
        'sort_order',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    /**
     * Get the quotation that owns the item.
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    /**
     * Get the product associated with the item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate total price
     */
    public function calculateTotal()
    {
        $this->total_price = $this->quantity * $this->unit_price;
        return $this;
    }

    /**
     * Get item type label
     */
    public function getItemTypeLabelAttribute()
    {
        return match($this->item_type) {
            'product' => 'Product',
            'service' => 'Service',
            'custom' => 'Custom Item',
            default => 'Unknown',
        };
    }
}