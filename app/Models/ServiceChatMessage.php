<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'customer_id',
        'sender_id',
        'message'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
