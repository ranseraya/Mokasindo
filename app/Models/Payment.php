<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payable_type',
        'payable_id',
        'user_id',
        'payment_code',
        'amount',
        'payment_type',
        'payment_method',
        'status',
        'payment_gateway',
        'payment_reference',
        'payment_url',
        'payment_details',
        'expired_at',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'expired_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    // Relationships
    public function payable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper Methods
    public function markAsSuccess()
    {
        $this->update([
            'status' => 'success',
            'paid_at' => now()
        ]);
    }

    public function isSuccess()
    {
        return $this->status === 'success';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isExpired()
    {
        return $this->expired_at && now()->greaterThan($this->expired_at);
    }
}
