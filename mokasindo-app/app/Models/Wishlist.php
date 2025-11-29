<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'vehicle_id'];

    // Relasi balik ke kendaraan
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Relasi balik ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}