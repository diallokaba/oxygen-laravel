<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_phone',
        'amount',
        'type',
        'status',
        'scheduled_at',
        'recurrence'
    ];

    protected $dates = [
        'scheduled_at',
        'cancelled_at'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function canCancel()
    {
        return $this->status === 'SUCCES' && 
               $this->created_at->diffInMinutes(now()) <= 30;
    }
}
