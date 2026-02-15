<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceCategory;

class ServiceProvider extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'approval_status', 'completed_jobs_count', 'promotion_credits'];
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'service_provider_id');
    }

    public function availabilities()
    {
        return $this->hasMany(ServiceAvailability::class, 'service_provider_id');
    }

    public function availabilityExceptions()
    {
        return $this->hasMany(ServiceAvailabilityException::class, 'service_provider_id');
    }
}
