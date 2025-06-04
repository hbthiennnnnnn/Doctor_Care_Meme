<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'payment_code',
        'amount',
        'method',
        'type',
        'status',
        'note',
    ];

    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
