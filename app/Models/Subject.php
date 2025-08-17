<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'cover_image',
        'preview_video',
        'is_compulsory',
        'is_active',
    ];

    protected $casts = [
        'is_compulsory' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the topics for the subject.
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * Get the forms the subject is offered in.
     */
    public function forms(): BelongsToMany
    {
        return $this->belongsToMany(Form::class, 'form_subjects')->withTimestamps();
    }

    /**
     * Get the live sessions for the subject.
     */
    public function liveSessions(): HasMany
    {
        return $this->hasMany(LiveSession::class);
    }

    /**
     * Get the pricing plans for the subject.
     */
    public function pricing(): HasMany
    {
        return $this->hasMany(SubjectPricing::class);
    }
}
