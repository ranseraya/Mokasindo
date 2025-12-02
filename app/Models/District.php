<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'code',
        'name',
    ];

    // Relationships
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function subDistricts()
    {
        return $this->hasMany(SubDistrict::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
