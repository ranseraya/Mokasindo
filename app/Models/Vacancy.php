<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'type', // fulltime, contract, internship
        'location',
        'salary_range',
        'is_active',
        'closed_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'closed_at' => 'datetime',
    ];

    // Relationships
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}