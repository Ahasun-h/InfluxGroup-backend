<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quotation_number',
        'client_name',
        'client_email',
        'client_phone',
        'client_company',
        'client_address',
        'quotation_date',
        'valid_until',
        'subtotal',
        'tax_percentage',
        'tax_amount',
        'discount_percentage',
        'discount_amount',
        'total',
        'status',
        'notes',
        'terms_and_conditions',
        'items',
        'currency',
        'created_by',
    ];

    protected $casts = [
        'quotation_date' => 'date',
        'valid_until' => 'date',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'items' => 'array',
        'tax_percentage' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
    ];

    /**
     * Get the user who created the quotation.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the items for the quotation.
     */
    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class)->orderBy('sort_order');
    }

    /**
     * Generate unique quotation number
     */
    public static function generateQuotationNumber()
    {
        $prefix = 'QT';
        $year = date('Y');
        $month = date('m');

        // Get the last quotation number for this month/year
        $lastQuotation = self::where('quotation_number', 'like', "{$prefix}{$year}{$month}%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastQuotation) {
            $lastNumber = intval(substr($lastQuotation->quotation_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "{$prefix}{$year}{$month}{$newNumber}";
    }

    /**
     * Scope a query to only include quotations with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include draft quotations.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include sent quotations.
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Calculate totals based on items
     */
    public function calculateTotals()
    {
        $items = $this->quotationItems;
        $subtotal = 0;

        foreach ($items as $item) {
            $subtotal += $item->total_price;
        }

        $this->subtotal = $subtotal;
        $this->tax_amount = ($subtotal * $this->tax_percentage) / 100;
        $this->discount_amount = ($subtotal * $this->discount_percentage) / 100;
        $this->total = $subtotal + $this->tax_amount - $this->discount_amount;

        return $this;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            'sent' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'expired' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'Draft',
            'sent' => 'Sent',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'expired' => 'Expired',
            default => 'Unknown',
        };
    }
}