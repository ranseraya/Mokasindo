<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacancy_id',
        'name',
        'email',
        'phone',
        'cover_letter',
        'cv_path',
        'status', // pending, reviewed, rejected, accepted
    ];

    // Relationships
    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }

    // Helpers
    public function isPending()
    {
        return $this->status === 'pending';
    }
}