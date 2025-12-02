<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'pickup_address',
        'destination_address',
        'distance_km',
        'shipping_cost',
        'courier_name',
        'tracking_code',
        'status', // pending, processing, on_delivery, delivered, confirmed
        'proof_of_delivery',
        'received_at',
    ];

    protected $casts = [
        'distance_km' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'received_at' => 'datetime',
    ];

    // Relationships
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}