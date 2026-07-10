<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'type',
        'subject',
        'content',
        'created_by',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer that owns the interaction.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user who created the interaction.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include interactions of a specific type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include recent interactions.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope a query to only include interactions for a specific customer.
     */
    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Get the interaction type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'email' => 'Email',
            'call' => 'Phone Call',
            'meeting' => 'Meeting',
            'note' => 'Note',
            'quote' => 'Quote',
            'lead' => 'Lead',
            default => ucfirst($this->type),
        };
    }

    /**
     * Get the interaction type color.
     */
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'email' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'call' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'meeting' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            'note' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
            'quote' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
            'lead' => 'bg-brand-100 text-brand-800 dark:bg-brand-900 dark:text-brand-200',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
