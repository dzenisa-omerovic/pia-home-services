<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAvailabilityException extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_provider_id',
        'date',
        'is_available',
        'start_time',
        'end_time'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }
}
