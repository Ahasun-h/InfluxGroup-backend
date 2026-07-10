<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'address',
        'industry',
        'status',
        'source',
        'lead_id',
        'assigned_to',
        'first_contact_at',
        'last_contact_at',
        'lifetime_value',
        'total_orders',
        'notes',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
        'lifetime_value' => 'decimal:2',
        'first_contact_at' => 'datetime',
        'last_contact_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the lead that converted to this customer.
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Get the user assigned to this customer.
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get all interactions for this customer.
     */
    public function interactions()
    {
        return $this->hasMany(CustomerInteraction::class);
    }

    /**
     * Get all leads associated with this customer.
     */
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    /**
     * Get all quote requests for this customer.
     */
    public function quoteRequests()
    {
        return $this->hasMany(QuoteRequest::class);
    }

    /**
     * Get all quotations for this customer.
     */
    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    /**
     * Scope a query to only include active customers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive customers.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to only include customers with purchases.
     */
    public function scopeHasPurchases($query)
    {
        return $query->where('total_orders', '>', 0);
    }

    /**
     * Scope a query to only include hot leads (recent contact).
     */
    public function scopeHotLead($query)
    {
        return $query->where('last_contact_at', '>=', now()->subDays(7));
    }

    /**
     * Scope a query to only include cold leads (no recent contact).
     */
    public function scopeColdLead($query)
    {
        return $query->where('last_contact_at', '<', now()->subDays(30));
    }

    /**
     * Calculate customer lifetime value from quotations.
     */
    public function calculateLifetimeValue(): void
    {
        $totalValue = $this->quotations()
            ->where('status', 'accepted')
            ->sum('total');

        $this->update([
            'lifetime_value' => $totalValue,
        ]);
    }

    /**
     * Get recent activity for the customer.
     */
    public function getRecentActivity(int $limit = 10)
    {
        return $this->interactions()
            ->with('createdBy')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Add an interaction to this customer.
     */
    public function addInteraction(array $data): CustomerInteraction
    {
        $interaction = $this->interactions()->create($data);

        // Update last contact timestamp
        $this->update(['last_contact_at' => now()]);

        return $interaction;
    }

    /**
     * Check if customer is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if customer has made purchases.
     */
    public function hasPurchases(): bool
    {
        return $this->total_orders > 0;
    }
}
