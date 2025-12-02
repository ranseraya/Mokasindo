<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_code',
        'auction_id',
        'buyer_id',
        'seller_id',
        'vehicle_id',
        'winning_bid',
        'deposit_paid',
        'remaining_payment',
        'total_amount',
        'platform_fee',
        'seller_amount',
        'status',
        'payment_deadline',
        'paid_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'winning_bid' => 'decimal:2',
        'deposit_paid' => 'decimal:2',
        'remaining_payment' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'seller_amount' => 'decimal:2',
        'payment_deadline' => 'datetime',
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    // Helper Methods
    public function markAsPaid()
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now()
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }

    public function isOverdue()
    {
        return now()->greaterThan($this->payment_deadline) && $this->status !== 'paid';
    }
}
