<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'photo_url',
        'linkedin_url',
        'instagram_url',
        'bio',
        'order_number',
    ];

    protected $casts = [
        'order_number' => 'integer',
    ];

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number', 'asc');
    }
}