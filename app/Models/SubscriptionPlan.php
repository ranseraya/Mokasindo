<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'features',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array', // JSON ke Array
        'is_active' => 'boolean',
    ];

    // Relationships
    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
}