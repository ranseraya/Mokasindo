<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status', // new, read, replied, spam
        'admin_reply',
    ];

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('status', 'new');
    }
}