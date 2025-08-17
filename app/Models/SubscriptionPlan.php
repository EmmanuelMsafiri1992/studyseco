<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'duration_months',
        'price',
        'currency',
        'features',
        'is_popular',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function studentSubscriptions(): HasMany
    {
        return $this->hasMany(StudentSubscription::class, 'plan_id');
    }

    public function subjectPricing(): HasMany
    {
        return $this->hasMany(SubjectPricing::class, 'plan_id');
    }
}
